<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Halaman admin">
    <meta name="robots" content="noindex,nofollow">
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
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="<?= base_url('dashboard'); ?>">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="<?=base_url('public/icon.png');?>" width="50px" height="50px" alt="homepage" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <h2 class="orange mt-4" title="Sistem Informasi Rumah Makan">SIRUMA</h2>
                        </span>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                        href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                   
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center">

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li>
                            <a class="profile-pic" type="button" data-bs-toggle="modal" href="#exampleModal">
                        <img class="img-circle" src="<?=base_url('public/img/default.png');?>" width="40px">
                        <span class="text-white font-medium"><?= session()->get('username'); ?></span></a>
                        </li>

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah anda ingin logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="<?= base_url('logout'); ?>" class="btn btn-primary">Logout</a>
      </div>
    </div>
  </div>
</div>


        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('dashboard'); ?>"
                                aria-expanded="false">
                                <i class="fas fa-home me-3" aria-hidden="true"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('menu'); ?>"
                                aria-expanded="false">
                                <i class="fas fa-utensils me-3" aria-hidden="true"></i>
                                <span class="hide-menu">Menu</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('kasir'); ?>"
                                aria-expanded="false">
                                <i class="fas fa-cash-register me-3" aria-hidden="true"></i>
                                <span class="hide-menu">Kasir</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('riwayat'); ?>"
                                aria-expanded="false">
                                <i class="fas fa-clock-rotate-left me-3" aria-hidden="true"></i>
                                <span class="hide-menu">Riwayat Pemesanan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('user'); ?>"
                                aria-expanded="false">
                                <i class="fas fa-users me-3" aria-hidden="true"></i>
                                <span class="hide-menu">User</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('akun'); ?>"
                                aria-expanded="false">
                                <i class="fas fa-cog me-3" aria-hidden="true"></i>
                                <span class="hide-menu">Akun</span>
                            </a>
                        </li>
                        <li class="sidebar-item bg-danger">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link text-white" href="<?= base_url('logout'); ?>"
                                aria-expanded="false">
                                <i class="fas fa-lock-open text-white me-3" aria-hidden="true"></i>
                                <span class="hide-menu">Logout</span>
                            </a>
                        </li>
                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="d-lg-none"><br></div>
            
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title text-primary">Riwayat Pemesanan</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal">History</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Three charts -->
                <!-- ============================================================== -->

  <?php if(session()->getFlashdata('danied')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <?= session()->getFlashdata('danied'); ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
  <?php endif; ?>

  <?php if(session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
  <?= session()->getFlashdata('pesan'); ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
  <?php endif; ?>

                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Semua</h3>
                            <ul class="list-inline two-part d-flex align-items-center mb-0">
                                <li>
                                    <div id="sparklinedash"><canvas width="67" height="30"
                                            style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                    </div>
                                </li>
                                <li class="ms-auto"><span class="counter text-success"><?= count($histori); ?></span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Hari Ini</h3>
                            <ul class="list-inline two-part d-flex align-items-center mb-0">
                                <li>
                                    <div id="sparklinedash2"><canvas width="67" height="30"
                                            style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                    </div>
                                </li>
                                <li class="ms-auto"><span class="counter text-purple"><?= count($history_harian); ?></span></li>
                            </ul>
                        </div>
                    </div>

                </div>


  
                <div class="row">

                    <div class="col-sm-12">
                        <div class="white-box">

<p class="position-relative d-inline-block p-0" style="left: -25px; top: -25px;">
    <a id="hariann" class="btn btn-primary me-0" role="button" data-bs-toggle="collapse" href="#harian" aria-expanded="false" aria-controls="collapse" style="border-left: 0px; border-top: 0px;">
        Harian
    </a>

    <a id="semuaa" class="btn btn-outline-primary ms-0" role="button" data-bs-toggle="collapse" href="#semua" aria-expanded="false" aria-controls="collapse" style="border-left: 0px; border-top: 0px;">
        Semua
    </a>
</p>

<form method="get" class="float-end d-inline-block">
    <input type="date" name="tanggal" class="p-1 border-light bg-light shadow-sm" style="border-bottom-left-radius: 15px; border-top-left-radius: 15px; border: 1px solid;">
    <button type="submit" class="btn btn-sm bg-orange text-white shadow-sm" style="border-bottom-right-radius: 15px; border-top-right-radius: 15px;">Filter</button>
    <a href="<?= base_url('riwayat'); ?>" title="Refresh"><i class="fa-solid fa-arrows-rotate orange"></i></a>
</form>
                        
                        
                            <h3 class="box-title">HISTORY</h3>
                            <div class="table-responsive">

                                <div class="collapse show" id="harian">
                                <table id="nilai" class="table text-nowrap search-table">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nama Pemesan</th>
                                            <th class="border-top-0">Menu</th>
                                            <th class="border-top-0">Jumlah</th>
                                            <th class="border-top-0">Waktu</th>
                                            <th class="border-top-0">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no=1; foreach($history_harian as $d) { $jumlahHarga = $d->harga * $d->jumlah; ?>
                                        <tr>
                                            <td><?= $no++; ?>.</td>
                                            <td><?= $d->nama_pemesan; ?> <br> <small class="text-center text-secondary">(<?= $d->username; ?>)</small></td>
                                            <td><?= $d->nama; ?></td>
                                            <td><?= $d->jumlah; ?></td>
                                            <td><?= $d->waktu; ?></td>
                                            <td><a href="<?= base_url('cetakTransaksi/'.$d->no_pesanan);?>" class="btn btn-success text-white mb-2"><i class="fas fa-print"></i> Cetak</a></td>
                                            <td class="hide"><?= $jumlahHarga; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <h4 id="hasil" class="mt-3" style="text-align: right;"></h4>
                            </div>

                            <div class="collapse" id="semua">
                                <table class="table text-nowrap search-table">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Nama Pemesan</th>
                                            <th class="border-top-0">Menu</th>
                                            <th class="border-top-0">Jumlah</th>
                                            <th class="border-top-0">Waktu</th>
                                            <th class="border-top-0">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($history as $d) { ?>
                                        <tr>
                                            <td><?= $nomor++; ?>.</td>
                                            <td><?= $d->nama_pemesan; ?> <br> <small class="text-center text-secondary">(<?= $d->username; ?>)</small></td>
                                            <td><?= $d->nama; ?></td>
                                            <td><?= $d->jumlah; ?></td>
                                            <td><?= $d->waktu; ?></td>
                                            <td><a href="<?= base_url('cetakTransaksi/'.$d->no_pesanan);?>" class="btn btn-success text-white mb-2"><i class="fas fa-print"></i> Cetak</a></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?= $pager->links(); ?>
                            </div>
                            
                            </div>
                        </div>
                    </div>

                </div>


               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center"> 2022 © Rumah Makan Gulai Asam Hinai Batu Malenggang</footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?= base_url('public/'); ?>/plugins/bower_components/jquery/dist/jquery.min.js"></script>
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

    <script type="text/javascript">
    $(document).ready(function() {
      $("#semuaa").click(function(){ 
          $('#harian').removeClass('show');
          $('#semuaa').removeClass('btn-outline-primary');
          $('#hariann').removeClass('btn-primary');
          $('#hariann').removeClass('text-white');
          $('#hariann').addClass('btn-outline-primary');
          $('#semuaa').addClass('btn-primary');
          $('#semuaa').addClass('text-white');
      });

      $("#hariann").click(function(){ 
          $('#semua').removeClass('show');
          $('#hariann').removeClass('btn-outline-primary');
          $('#semuaa').removeClass('btn-primary');
          $('#semuaa').removeClass('text-white');
          $('#semuaa').addClass('btn-outline-primary');
          $('#hariann').addClass('btn-primary');
          $('#hariann').addClass('text-white');
      });

    });

    var table = document.getElementById("nilai"), sumHsl = 0;
        for(var t = 1; t < table.rows.length; t++)
        {
            sumHsl = sumHsl + parseInt(table.rows[t].cells[6].innerHTML);
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
    
</script>
</body>

</html>