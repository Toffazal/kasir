<?php

namespace App\Controllers;
use \App\Models\User;
use \App\Models\Menu;
use \App\Models\MenuHarian;
use \App\Models\History;
use \App\Models\Pemesanan;
use \App\Models\Riwayat;

class Home extends BaseController
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
        if(session()->has('username'))
        {
            return redirect()->to(base_url('dashboard'));
        }

        $data = [
            'title' => 'Halaman Login',
            'validation' => \Config\Services::validation()
        ];

        return view('login', $data);
    }
    
    
    
    
    
    public function loginAdmin()
    {
        if(session()->has('username'))
        {
            return redirect()->to(base_url('dashboard'));
        }

        $data = [
            'title' => 'Halaman Login',
            'validation' => \Config\Services::validation()
        ];

        return view('loginAdmin', $data);
    }



    public function prosesLogin()
    {
        if(session()->has('username'))
        {
            return redirect()->to(base_url('dashboard'));
        }

        //Validasi input
        if(!$this->validate([

        'username' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Username tidak boleh kosong.'
            ]
        ],

        'password' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Password tidak boleh kosong.'
            ]
        ]

        ])) {
            return redirect()->to(base_url())->withInput();
        }

    $username = $this->request->getVar('username');
    $password = $this->request->getVar('password');

    $user = $this->User->where(['username' => $username])->first();

    if(session()->get('gagal') >= 5)
    {
        session()->setFlashdata('danied', 'ACCESS DANIED!');
        return redirect()->to(base_url());
    }

    //jika user ada
    if($user)
    {
        //cek password
        if(password_verify($password, $user->password))
        {
          session()->set('username', $user->username);
          session()->set('role', $user->role);

        session()->setFlashdata('pesan', 'Berhasil login.');
        return redirect()->to(base_url('dashboard'));  
        }else{
            $gagal = session()->get('gagal');
            if($gagal)
            {
                $baru = session()->get('gagal') + 1;
                session()->remove('gagal');
                session()->set('gagal', $baru);
            }else{
                session()->set('gagal', 1);
            }

            session()->setFlashdata('danied', 'Username/password salah.');
            return redirect()->to(base_url());
        }
      }else{
            $gagal = session()->get('gagal');
            if($gagal)
            {
                $baru = session()->get('gagal') + 1;
                session()->remove('gagal');
                session()->set('gagal', $baru);
            }else{
                session()->set('gagal', 1);
            }

          session()->setFlashdata('danied', 'Username/password salah.');
          return redirect()->to(base_url());
        }
    }
    




    public function dashboard()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('role') == 'karyawan')
        {
            return redirect()->to(base_url('karyawan'));
        }

        $data = [
            'title' => 'Dashboard',
            'menu' => $this->MenuHarian->orderBy('nama', 'esc')->find(),
            'history' => $this->History->findAll()
        ];

        return view('dashboard', $data);
    }




    public function karyawan()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Karyawan',
            'menu' => $this->MenuHarian->orderBy('nama', 'esc')->find(),
            'history' => $this->History->findAll()
        ];

        return view('karyawan', $data);
    }




    public function menu()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        $data = [
            'title' => 'Menu',
            'menu' => $this->Menu->orderBy('nama', 'esc')->find()
        ];

        return view('menu', $data);
    }




    public function tambahMenu()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        $data = [
            'title' => 'Tambah Menu',
            'validation' => \Config\Services::validation()
        ];

        return view('tambahMenu', $data);
    }




    public function simpanMenu()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        //Validasi input
        if(!$this->validate([

        'nama' => [
            'rules' => 'required|is_unique[menu.nama]',
            'errors' => [
            'required' => 'Nama menu harus diisi.',
            'is_unique' => 'Menu sudah terdaftar.'
            ]
        ],

        'harga' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Harga tidak boleh kosong.'
            ]
        ]

        ])) {
        return redirect()->to(base_url('tambahMenu/'))->withInput();
        }

        $slug = url_title($this->request->getVar('nama'), '-', true);

        $this->Menu->save([
        'slug' => $slug,
        'nama' => htmlspecialchars($this->request->getVar('nama')),
        'harga' => htmlspecialchars($this->request->getVar('harga'))
        ]);

        $this->MenuHarian->save([
        'nama' => htmlspecialchars($this->request->getVar('nama')),
        'harga' => htmlspecialchars($this->request->getVar('harga')),
        'jumlah' => 0
        ]);

        session()->setFlashdata('pesan', 'Menu telah ditambah.');
        return redirect()->to(base_url('menu'));
    }




    public function editMenu($slug = false)
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        $data = [
            'title' => 'Tambah Menu',
            'menu' => $this->Menu->where('slug', $slug)->first(),
            'validation' => \Config\Services::validation()
        ];

        return view('editMenu', $data);
    }




    public function updateMenu()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        $id = $this->request->getVar('id');
        $slug = url_title($this->request->getVar('nama'), '-', true);

        //Validasi input
        if(!$this->validate([

        'nama' => [
            'rules' => 'required|is_unique[menu.nama,id,'.$id.']',
            'errors' => [
            'required' => 'Nama menu harus diisi.',
            'is_unique' => 'Menu sudah terdaftar.'
            ]
        ],

        'harga' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Harga tidak boleh kosong.'
            ]
        ]

        ])) {
        return redirect()->to(base_url('editMenu/'.$slug))->withInput();
        }

        $this->Menu->save([
        'id' => $id,
        'slug' => $slug,
        'nama' => htmlspecialchars($this->request->getVar('nama')),
        'harga' => htmlspecialchars($this->request->getVar('harga'))
        ]);

        session()->setFlashdata('pesan', 'Menu telah diubah.');
        return redirect()->to(base_url('menu'));
    }




    public function hapusMenu($id = false)
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        if(!$id)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('menu'));
        }

        $menu = $this->Menu->where('id', $id)->first();

        if(!$menu)
        {
            session()->setFlashdata('danied', 'Menu tidak tersedia');
            return redirect()->to(base_url('menu'));
        }

        $menuHarian = $this->MenuHarian->where('nama', $menu->nama)->first();

        $this->Menu->delete($id);
        $this->MenuHarian->delete($menuHarian->id);

        session()->setFlashdata('pesan', 'Menu berhasil dihapus');
        return redirect()->to(base_url('menu'));
    }




    // public function tambahMenuHarian()
    // {
    //     if(!session()->has('username'))
    //     {
    //         return redirect()->to(base_url());
    //     }

    //     if(session()->get('username') != 'admin')
    //     {
    //         session()->setFlashdata('danied', 'ACCESS DANIED!');
    //         return redirect()->to(base_url('karyawan'));
    //     }

    //     $data = [
    //         'title' => 'Tambah Menu Harian',
    //         'menu' => $this->Menu->findAll(),
    //         'validation' => \Config\Services::validation()
    //     ];

    //     return view('tambahMenuHarian', $data);
    // }




    // public function simpanMenuHarian()
    // {
    //     if(!session()->has('username'))
    //     {
    //         return redirect()->to(base_url());
    //     }

    //     if(session()->get('username') != 'admin')
    //     {
    //         session()->setFlashdata('danied', 'ACCESS DANIED!');
    //         return redirect()->to(base_url('karyawan'));
    //     }

    //     //Validasi input
    //     if(!$this->validate([

    //     'nama' => [
    //         'rules' => 'required|is_unique[menu_harian.nama]',
    //         'errors' => [
    //         'required' => 'Nama menu harus diisi.',
    //         'is_unique' => 'Menu sudah terdaftar.'
    //         ]
    //     ],

    //     'jumlah' => [
    //         'rules' => 'required',
    //         'errors' => [
    //         'required' => 'Jumlah tidak boleh kosong.'
    //         ]
    //     ]

    //     ])) {
    //     return redirect()->to(base_url('tambahMenuHarian/'))->withInput();
    //     }

    //     $menu = $this->Menu->where('nama', $this->request->getVar('nama'))->first();

    //     $this->MenuHarian->save([
    //     'nama' => $menu->nama,
    //     'harga' => $menu->harga,
    //     'jumlah' => $this->request->getVar('jumlah')
    //     ]);

    //     session()->setFlashdata('pesan', 'Menu harian telah ditambah.');
    //     return redirect()->to(base_url('dashboard'));
    // }




    public function editMenuHarian($id = false)
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        $data = [
            'title' => 'Edit Menu Harian',
            'm' => $this->MenuHarian->where('id', $id)->first(),
            'menu' => $this->Menu->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('editMenuHarian', $data);
    }




    public function updateMenuHarian()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        $id = $this->request->getVar('id');

        //Validasi input
        if(!$this->validate([

        'nama' => [
            'rules' => 'required|is_unique[menu_harian.nama,id,'.$id.']',
            'errors' => [
            'required' => 'Nama menu harus diisi.',
            'is_unique' => 'Menu sudah terdaftar.'
            ]
        ],

        'jumlah' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Harga tidak boleh kosong.'
            ]
        ]

        ])) {
        return redirect()->to(base_url('editMenuHarian/'.$id))->withInput();
        }

        $menu = $this->Menu->where('nama', $this->request->getVar('nama'))->first();

        $this->MenuHarian->save([
        'id' => $id,
        'nama' => htmlspecialchars($this->request->getVar('nama')),
        'harga' => $menu->harga,
        'jumlah' => htmlspecialchars($this->request->getVar('jumlah'))
        ]);

        session()->setFlashdata('pesan', 'Menu telah diubah.');
        return redirect()->to(base_url('dashboard'));
    }




    // public function hapusMenuHarian($id = false)
    // {
    //     if(!session()->has('username'))
    //     {
    //         return redirect()->to(base_url());
    //     }

    //     if(session()->get('username') != 'admin')
    //     {
    //         session()->setFlashdata('danied', 'ACCESS DANIED!');
    //         return redirect()->to(base_url('karyawan'));
    //     }

    //     if(!$id)
    //     {
    //         session()->setFlashdata('danied', 'ACCESS DANIED!');
    //         return redirect()->to(base_url('dashboard'));
    //     }

    //     $this->MenuHarian->delete($id);

    //     session()->setFlashdata('pesan', 'Menu berhasil dihapus');
    //     return redirect()->to(base_url('dashboard'));
    // }




    public function user()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        $data = [
            'title' => 'User',
            'user' => $this->User->where('role', 'karyawan')->find()
        ];

        return view('user', $data);
    }




     public function tambahUser()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        $data = [
            'title' => 'Tambah User',
            'validation' => \Config\Services::validation()
        ];

        return view('tambahUser', $data);
    }




    public function simpanUser()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        //Validasi input
        if(!$this->validate([

        'username' => [
            'rules' => 'required|is_unique[user.username]',
            'errors' => [
            'required' => 'Username harus diisi.',
            'is_unique' => 'username sudah terdaftar.'
            ]
        ],

        'password' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Password tidak boleh kosong.'
            ]
        ]

        ])) {
        return redirect()->to(base_url('tambahUser/'))->withInput();
        }

        $this->User->save([
        'username' => htmlspecialchars($this->request->getVar('username')),
        'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        'role' => 'karyawan'
        ]);

        session()->setFlashdata('pesan', 'User telah ditambah.');
        return redirect()->to(base_url('user'));
    }




    public function editUser($id = false)
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        $data = [
            'title' => 'Edit User',
            'user' => $this->User->where('id', $id)->first(),
            'validation' => \Config\Services::validation()
        ];

        return view('editUser', $data);
    }




    public function updateUser()
    {
        if(!session()->has('username'))
        {
            session()->setFlashdata('danied', 'Anda belum Login.');
            return redirect()->to(base_url());
        }

        //Validasi input
        if(!$this->validate([

        'username' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Nama harus diisi.'
            ]
        ]

        ])) {
        return redirect()->to(base_url('akun/'))->withInput();
        }

        $id = $this->request->getVar('id');
        $data = $this->User->where('id', $id)->first();

        if($this->request->getVar('password'))
        {
            $pass = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        }else{
            $pass = $data->password;
        }

        $this->User->save([
        'id' => $id,
        'username' => $this->request->getVar('username'),
        'password' => $pass,
        'role' => $data->role
        ]);

        session()->setFlashdata('pesan', 'User telah diperbarui.');
        return redirect()->to(base_url('user'));
    }




    public function hapusUser($id = false)
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        if(!$id)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('menu'));
        }

        $this->User->delete($id);

        session()->setFlashdata('pesan', 'User berhasil dihapus');
        return redirect()->to(base_url('user'));
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

        return view('akun', $data);
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

        'username' => [
            'rules' => 'required',
            'errors' => [
            'required' => 'Nama harus diisi.'
            ]
        ]

        ])) {
        return redirect()->to(base_url('akun/'))->withInput();
        }

        $id = $this->request->getVar('id');
        $data = $this->User->where('id', $id)->first();

        if($this->request->getVar('password'))
        {
            $pass = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        }else{
            $pass = $data->password;
        }

        $this->User->save([
        'id' => $id,
        'username' => $this->request->getVar('username'),
        'password' => $pass,
        'role' => $data->role
        ]);

        session()->setFlashdata('pesan', 'Akun telah diperbarui.');

        session()->remove('username');

        return redirect()->to(base_url());
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

        if(session()->get('role') != 'admin')
        {
            return redirect()->to(base_url('karyawan'));
        }

        $timezone = time() + (60 * 60 * 7);
        $waktu = gmdate('d-m-y', $timezone);

        $tanggall = $this->request->getVar('tanggal');

        if($tanggall)
        {
            $tanggal = date("d-m-y", strtotime($tanggall));
            $pesanan = $this->History->like('waktu', $tanggal)->orderBy('id', 'desc')->find();
        }else{
            $pesanan = $this->History->like('waktu', $waktu)->orderBy('id', 'desc')->find();
        }
        
        $history = $this->History->orderBy('id', 'desc')->paginate(10);
        $histori = $this->History->orderBy('id', 'desc')->find();

        $data = [
            'title' => 'Riwayat Pemesanan',
            'history_harian' => $pesanan,
            'history' => $history,
            'histori' => $histori,
            'pager' => $this->History->pager,
            'nomor' => $this->nomor($this->request->getVar('page'), 10)
        ];

        return view('riwayat', $data);
    }




    public function pemesanan()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('role') != 'admin')
        {
            return redirect()->to(base_url('karyawan'));
        }

        $data = [
            'title' => 'Buat Pesanan',
            'menu' => $this->Menu->orderBy('nama', 'esc')->find(),
            'validation' => \Config\Services::validation()
        ];

        return view('pemesanan', $data);
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

        if(session()->get('role') != 'admin')
        {
            return redirect()->to(base_url('karyawan'));
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
                return redirect()->to(base_url('pemesanan'));
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
        return redirect()->to(base_url('kasir'));
    }




    public function hapusPemesanan($id = false)
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('username') != 'admin')
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        if(!$id)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('kasir'));
        }

        $riwayat = $this->Riwayat->where('id', $id)->first();
        if(!$riwayat)
        {
            session()->setFlashdata('danied', 'Pesanan tidak ditemukan.');
            return redirect()->to(base_url('kasir'));
        }

        $pesanan = $this->Pemesanan->where('no_pesanan', $riwayat->no_pesanan)->find();
        foreach($pesanan as $p)
        {
            $menu = $this->MenuHarian->where('nama', $p->nama)->first();
            $jumlah = $menu->jumlah + $p->jumlah;
            $data['jumlah'] = $jumlah;

            $this->MenuHarian->update($menu->id, $data);
            $this->Pemesanan->delete($p->id);
        }

        
        $this->Riwayat->delete($id);

        session()->setFlashdata('pesan', 'Pesanan berhasil dihapus');
        return redirect()->to(base_url('kasir'));
    }




    public function kasir()
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('role') != 'admin')
        {
            return redirect()->to(base_url('karyawan'));
        }

        $pesanan = $this->Riwayat->orderBy('id', 'desc')->find();

        $data = [
            'title' => 'Kasir',
            'pesanan' => $pesanan
        ];

        return view('kasir', $data);
    }




    public function pembayaran($no_pesanan = false)
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('role') != 'admin')
        {
            return redirect()->to(base_url('karyawan'));
        }

        $pesanan = $this->Pemesanan->where('no_pesanan', $no_pesanan)->find();
        $data = $this->Pemesanan->where('no_pesanan', $no_pesanan)->first();

        $data = [
            'title' => 'Pembayaran',
            'pesanan' => $pesanan,
            'data' => $data
        ];

        return view('pembayaran', $data);
    }




    public function cetakTransaksi($no_pesanan = false)
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(session()->get('role') != 'admin')
        {
            return redirect()->to(base_url('karyawan'));
        }

        $pesanan = $this->Pemesanan->where('no_pesanan', $no_pesanan)->find();
        if(!$pesanan)
        {
            $pesanan = $this->History->where('no_pesanan', $no_pesanan)->find();
        }

        $data = $this->Pemesanan->where('no_pesanan', $no_pesanan)->first();
        if(!$data)
        {
            $data = $this->History->where('no_pesanan', $no_pesanan)->first();
        }

        $data = [
            'title' => 'Pembayaran',
            'pesanan' => $pesanan,
            'data' => $data
        ];

        return view('cetakTransaksi', $data);
    }




    public function simpanTransaksi($no = false)
    {
        if(!session()->has('username'))
        {
            return redirect()->to(base_url());
        }

        if(!$no)
        {
            session()->setFlashdata('danied', 'ACCESS DANIED!');
            return redirect()->to(base_url('karyawan'));
        }

        $pesanan = $this->Pemesanan->where('no_pesanan', $no)->find();
        $riwayat = $this->Riwayat->where('no_pesanan', $no)->first();

        $this->Riwayat->delete($riwayat->id);
        
        foreach($pesanan as $p)
        {
            $this->History->save([
            'no_pesanan' => $no,
            'nama_pemesan' => $p->nama_pemesan ,
            'username' => $p->username,
            'nama' => $p->nama,
            'harga' => $p->harga,
            'jumlah' => $p->jumlah,
            'waktu' => $p->waktu
            ]);

            $this->Pemesanan->delete($p->id);
        }

        session()->setFlashdata('pesan', 'Pesanan telah disimpan.');
        return redirect()->to(base_url('kasir'));
    }




    public function logout()
    {
        if(!session()->has('username'))
        {
            session()->setFlashdata('danied', 'Anda belum Login.');
            return redirect()->to(base_url());
        }

        session()->remove('username');
        session()->remove('role');

        session()->setFlashdata('pesan', 'Anda telah logout.');
        return redirect()->to(base_url());
    }


}
