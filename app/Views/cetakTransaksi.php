<?php

namespace App\Controllers;

use \App\Models\Pemesanan;

    $Pemesanan = new Pemesanan;

    $dipesan = $Pemesanan->where('no_pesanan', $data->no_pesanan)->find();
        if($dipesan)
        {
            $redirect = 'pembayaran/'.$data->no_pesanan;
        }else{
            $redirect = 'riwayat';
        }

?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Halaman admin">
    <meta name="robots" content="noindex,nofollow">
    <meta http-equiv="refresh" content="2; url=<?=base_url($redirect);?>">
    <title><?= $title; ?></title>
    <!-- Icon -->
    <link rel="shortcut icon" href="<?=base_url('public/icon.png');?>">
    <!-- Custom CSS -->
    <link href="<?= base_url('public/plugins/bower_components/chartist/dist/chartist.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('public/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css'); ?>">
    <!-- Custom CSS -->
    <link href="<?= base_url('public/css/style.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('public/css/style.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('public/fontawesome/css/all.min.css'); ?>" rel="stylesheet">

    <script src="<?= base_url('public/'); ?>/plugins/bower_components/jquery/dist/jquery.min.js"></script>
</head>

<body>

            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->  
                <div class="row">

                    <div class="col-sm-12">

                        <div class="white-box">
                            <h3 class="box-title mb-0">RM. Gulai Asam Batu Malenggang</h3>
                            <small class="text-secondary"><?= $data->waktu; ?></small>
                            
                            <div class="table-responsive">
                                <table id="nilai" class="table text-nowrap search-table">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Menu</th>
                                            <th class="border-top-0">Harga</th>
                                            <th class="border-top-0">Jumlah</th>
                                            <th class="border-top-0">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no=1; $jum=1; foreach($pesanan as $d) { $jumlahHarga = $d->harga * $d->jumlah; ?>
                                        <tr>
                                            <td><?= $no++; ?>.</td>
                                            <td><?= $d->nama; ?></td>
                                            <?php $harga = "Rp" . number_format($d->harga,0,',','.');  ?>
                                            <?php $jumlahHargaa = "Rp" . number_format($jumlahHarga,0,',','.');  ?>
                                            <td><?= $harga; ?></td>
                                            <td><?= $d->jumlah; ?></td>
                                            <td class="hide"><?= $jumlahHarga; ?></td>
                                            <td><?= $jumlahHargaa; ?></td>

                                            <input type="hidden" value="<?= $jumlahHarga; ?>" class="harga<?=$jum++;?>">
                                        </tr>

                                    <?php  }  ?>  

                                    </tbody>
                                </table>
                            </div>

                            <h4 id="hasil" class="mt-3" style="text-align: right;"></h4>
                        </div>
                    </div>

                </div>

<script>

        var table = document.getElementById("nilai"), sumHsl = 0;
        for(var t = 1; t < table.rows.length; t++)
        {
            sumHsl = sumHsl + parseInt(table.rows[t].cells[4].innerHTML);
        }

        var number_string = sumHsl.toString(),
        sisa    = number_string.length % 3,
        rupiah  = number_string.substr(0, sisa),
        ribuan  = number_string.substr(sisa).match(/\d{3}/g);
        
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        document.getElementById("hasil").innerHTML = "Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rp"+rupiah;

        print();
        
</script>


    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url('public/'); ?>/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('public/'); ?>/js/app-style-switcher.js"></script>
    <script src="<?= base_url('public/'); ?>/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!--Wave Effects -->
    <script src="<?= base_url('public/'); ?>/js/waves.js"></script>
    <script src="<?= base_url('public/'); ?>/fontawesome/js/all.min.js"></script>
    <!--Menu sidebar -->
    <script src="<?= base_url('public/'); ?>/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url('public/'); ?>/js/custom.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="<?= base_url('public/'); ?>/plugins/bower_components/chartist/dist/chartist.min.js"></script>
    <script src="<?= base_url('public/'); ?>/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="<?= base_url('public/'); ?>/js/pages/dashboards/dashboard1.js"></script>
</body>

</html>