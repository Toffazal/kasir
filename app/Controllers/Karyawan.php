<?php

namespace App\Controllers;
use \App\Models\User;
use \App\Models\Menu;
use \App\Models\MenuHarian;
use \App\Models\History;
use \App\Models\Pemesanan;
use \App\Models\Riwayat;

class Karyawan extends BaseController
{
    protected $User;
    protected $Menu;
    protected $MenuHarian;
    protected $History;
    protected $Pemesanan;
    protected $Riwayat;

    public function __construct()
    {
        $this->User = new User;
        $this->Menu = new Menu;
        $this->MenuHarian = new MenuHarian;
        $this->History = new History;
        $this->Pemesanan = new Pemesanan;
        $this->Riwayat = new Riwayat;
    }



    public function index()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('role') == 'admin')
        {
            return redirect()->to(base_url('dashboard'));
        }

        $timezone = time() + (60 * 60 * 7);
        $tanggal = gmdate('d-m-y', $timezone);

        $pesanan = $this->Pemesanan->where('username', session()->get('username'))->find();
        $history = $this->History->where('username', session()->get('username'))->like('waktu', $tanggal)->find();

        $data = [
            'title' => 'Menu Karyawan',
            'menu' => $this->MenuHarian->orderBy('nama', 'esc')->find(),
            'pesanan' => $pesanan,
            'history' => $history
        ];

        return view('karyawan/index', $data);
    }




     public function akun()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Pengaturan Akun',
            'user' => $this->User->where('username', session()->get('username'))->first(),
            'validation' => \Config\Services::validation()
        ];

        return view('karyawan/akun', $data);
    }




    public function updateAkun()
    {
        if(!session()->has('username'))
        {
            session()->setFlashdata('danied', 'Anda belum Login.');
            return redirect()->to(base_url());
        }

        //Validasi input
        if(!$this->validate([

        'password' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Password harus diisi.'
            ]
        ]

        ])) {
        return redirect()->to(base_url('karyawan/akun/'))->withInput();
        }

        $id = $this->request->getVar('id');
        $data = $this->User->where('id', $id)->first();

        if($data->username != session()->get('username'))
        {
             session()->setFlashdata('danied', 'ACCESS DANIED!');
             return redirect()->to(base_url('karyawan/akun'));
        }

        $pass = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);

        $this->User->save([
        'id' => $id,
        'username' => $data->username,
        'password' => $pass,
        'role' => $data->role
        ]);

        session()->setFlashdata('pesan', 'Akun telah diperbarui.');
        return redirect()->to(base_url('karyawan/akun'));
    }




    public function pemesanan()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Buat Pesanan',
            'menu' => $this->Menu->orderBy('nama', 'esc')->find(),
            'validation' => \Config\Services::validation()
        ];

        return view('karyawan/pemesanan', $data);
    }




    function randomString($length)
{
    $str        = "";
    $characters = '0123456789';
    $max        = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}



    public function simpanPemesanan()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        $nama = $this->request->getVar('nama');
        $jumlah = $this->request->getVar('jumlah');
        $total = count($nama);

        $timezone = time() + (60 * 60 * 7);
        $tanggal = gmdate('dmy', $timezone);

        $no = $tanggal.$this->randomString(3); 
        $waktu = gmdate('d-m-y, H:i', $timezone);

        for($i=0; $i<$total; $i++){

            $namaa = $nama[$i];
            $menu = $this->Menu->where('nama', $namaa)->first();

            $namaPemesan = $this->request->getVar('nama_pemesan');

            $menuHarian = $this->MenuHarian->where('nama', $namaa)->first();
            $jumlahMenu = $menuHarian->jumlah - $jumlah[$i];

            if($jumlahMenu < 0)
            {
                $pesananSebelumnya = $this->Pemesanan->where('no_pesanan', $no)->find();
                if($pesananSebelumnya)
                {
                    $totalPesananSebelumnya = count($pesananSebelumnya);

                    if($totalPesananSebelumnya == 1)
                    {
                        $sebelumnya = $this->Pemesanan->where('no_pesanan', $no)->first();
                        $this->Pemesanan->delete($sebelumnya->id);
                    }else{
                        foreach($pesananSebelumnya as $p)
                        {
                            $this->Pemesanan->delete($p->id);
                        }
                    }
                }

                session()->setFlashdata('danied', 'Menu tidak cukup.');
                return redirect()->to(base_url('karyawan/pemesanan'));
            }

            $this->Pemesanan->save([
            'no_pesanan' => $no,
            'nama_pemesan' => $namaPemesan,
            'username' => session()->get('username'),
            'nama' => $nama[$i],
            'harga' => $menu->harga,
            'jumlah' => $jumlah[$i],
            'waktu' => $waktu
            ]);

            $data['jumlah'] = $jumlahMenu;
            $this->MenuHarian->update($menuHarian->id, $data);
        }

        $this->Riwayat->save([
            'no_pesanan' => $no,
            'nama_pemesan' => $namaPemesan,
            'username' => session()->get('username'),
            'waktu' => $waktu
        ]);

        session()->setFlashdata('pesan', 'Pesanan telah ditambah.');
        return redirect()->to(base_url('karyawan'));
    }




    public function hapusPemesanan($id = false)
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(!$id)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        $pesanan = $this->Pemesanan->where('id', $id)->first();

        if(!$pesanan)
        {
            session()->setFlashdata('danied', 'Pesanan tidak ditemukan');
            return redirect()->to(base_url('karyawan'));
        }

        if($pesanan->username != session()->get('username'))
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        $menu = $this->MenuHarian->where('nama', $pesanan->nama)->first();
        $jumlah = $menu->jumlah + $pesanan->jumlah;
        $data['jumlah'] = $jumlah;

        $riwayat = $this->Riwayat->where('no_pesanan', $pesanan->no_pesanan)->first();
        $jumPesanan = $this->Pemesanan->where('no_pesanan', $riwayat->no_pesanan)->find();
        $jumlahPesanan = count($jumPesanan);

        if($jumlahPesanan <= 1)
        {
            $this->Riwayat->delete($riwayat->id);
        }    
        
        $this->MenuHarian->update($menu->id, $data);
        $this->Pemesanan->delete($id);

        session()->setFlashdata('pesan', 'Pesanan berhasil dihapus');
        return redirect()->to(base_url('karyawan'));
    }




    public function lihatPesanan($no_pesanan = false)
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        $pesanan = $this->Pemesanan->where('no_pesanan', $no_pesanan)->find();
        $data = $this->Pemesanan->where('no_pesanan', $no_pesanan)->first();

        $data = [
            'title' => 'Pembayaran',
            'pesanan' => $pesanan,
            'data' => $data
        ];

        return view('karyawan/lihatPesanan', $data);
    }




    public function tambahPesanan($no_pesanan = false)
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Tambah Pesanan',
            'no_pesanan' => $no_pesanan,
            'menu' => $this->Menu->orderBy('nama', 'esc')->find(),
            'validation' => \Config\Services::validation()
        ];

        return view('karyawan/tambahPesanan', $data);
    }




    public function simpanPesanan()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        $nama = $this->request->getVar('nama');
        $jumlah = $this->request->getVar('jumlah');
        $total = count($nama);

        $timezone = time() + (60 * 60 * 7);
        $tanggal = gmdate('dmy', $timezone);

        $no = $this->request->getVar('no_pesanan');
        $waktu = gmdate('d-m-y, H:i', $timezone);

        $p = $this->Pemesanan->where('no_pesanan', $no)->first();

        for($i=0; $i<$total; $i++){

            $namaa = $nama[$i];
            $menu = $this->Menu->where('nama', $namaa)->first();

            $this->Pemesanan->save([
            'no_pesanan' => $no,
            'nama_pemesan' => $p->nama_pemesan,
            'username' => session()->get('username'),
            'nama' => $nama[$i],
            'harga' => $menu->harga,
            'jumlah' => $jumlah[$i],
            'waktu' => $waktu
            ]);

            $menuHarian = $this->MenuHarian->where('nama', $namaa)->first();
            $jumlahMenu = $menuHarian->jumlah - $jumlah[$i];

            $data['jumlah'] = $jumlahMenu;

            $this->MenuHarian->update($menuHarian->id, $data);

        }

        session()->setFlashdata('pesan', 'Pesanan telah ditambah.');
        return redirect()->to(base_url('karyawan'));
    }


    public function nomor($currentPage, $perPage)
    {
        if (is_null($currentPage)) {
            $nomor = 1;
        } else {
            $nomor = 1 + ($perPage * ($currentPage - 1));
        }
        return $nomor;
    }


    public function riwayat()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('role') == 'admin')
        {
            return redirect()->to(base_url('dashboard'));
        }

        $timezone = time() + (60 * 60 * 7);
        $waktu = gmdate('d-m-y', $timezone);

        $tanggall = $this->request->getVar('tanggal');
        $tanggal = date("d-m-y", strtotime($tanggall));

        if($tanggall)
        {
            $pesanan = $this->History->like('waktu', $tanggal)->orderBy('id', 'desc')->where('username', session()->get('username'))->find();
        }else{
            $pesanan = $this->History->like('waktu', $waktu)->orderBy('id', 'desc')->where('username', session()->get('username'))->find();
        }
        
        $history = $this->History->orderBy('id', 'desc')->where('username', session()->get('username'))->paginate(10);
        $histori = $this->History->findAll();

        $data = [
            'title' => 'Riwayat Pemesanan',
            'history_harian' => $pesanan,
            'history' => $history,
            'histori' => $histori,
            'pager' => $this->History->pager,
            'nomor' => $this->nomor($this->request->getVar('page'), 10)
        ];

        return view('karyawan/riwayat', $data);
    }



}
