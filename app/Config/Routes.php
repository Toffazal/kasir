<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// Auth
$routes->add('/home', 'Home::index');
$routes->add('/home/index', 'Home::index');
$routes->add('/admin', 'Home::loginAdmin');
$routes->add('/home/prosesLogin', 'Home::prosesLogin');

// Dashboard
$routes->add('/dashboard', 'Home::dashboard');

// Karyawan
$routes->add('/karyawan', 'Karyawan::index');
$routes->add('/karyawan/riwayat', 'Karyawan::riwayat');
$routes->add('/karyawan/akun', 'Karyawan::akun');
$routes->add('/karyawan/updateAkun', 'Karyawan::updateAkun');
$routes->add('/karyawan/pemesanan', 'Karyawan::pemesanan');
$routes->add('/karyawan/simpanPemesanan', 'Karyawan::simpanPemesanan');
$routes->add('/karyawan/lihatPesanan', 'Karyawan::lihatPesanan');
$routes->add('/karyawan/lihatPesanan/(:num)', 'Karyawan::lihatPesanan/$1');

$routes->add('/karyawan/tambahPesanan', 'Karyawan::tambahPesanan');
$routes->add('/karyawan/simpanPesanan', 'Karyawan::simpanPesanan');
$routes->add('/karyawan/tambahPesanan/(:num)', 'Karyawan::tambahPesanan/$1');

// Bedanya tambahPesanan dan tambahPemesanan adalah, tambahPesanan untuk menambah pesanan yang sudah ada sebelumnya, sedangkan tambahPemesanan, untuk menambah pesanan baru
$routes->add('/karyawan/hapusPemesanan', 'Karyawan::hapusPemesanan');
$routes->add('/karyawan/hapusPemesanan/(:num)', 'Karyawan::hapusPemesanan/$1');

// Menu
$routes->add('/menu', 'Home::menu');
$routes->add('/tambahMenu', 'Home::tambahMenu');
$routes->add('/simpanMenu', 'Home::simpanMenu');
$routes->add('/editMenu/(:any)', 'Home::editMenu/$1');
$routes->add('/updateMenu', 'Home::updateMenu');
$routes->add('/hapusMenu', 'Home::hapusMenu');
$routes->add('/hapusMenu/(:num)', 'Home::hapusMenu/$1');

// Menu Harian
// $routes->add('/tambahMenuHarian', 'Home::tambahMenuHarian');
// $routes->add('/simpanMenuHarian', 'Home::simpanMenuHarian');
$routes->add('/editMenuHarian/(:any)', 'Home::editMenuHarian/$1');
$routes->add('/updateMenuHarian', 'Home::updateMenuHarian');
// $routes->add('/hapusMenuHarian', 'Home::hapusMenuHarian');
// $routes->add('/hapusMenuHarian/(:num)', 'Home::hapusMenuHarian/$1');

// Pemesanan
$routes->add('/pemesanan', 'Home::pemesanan');
$routes->add('/simpanPemesanan', 'Home::simpanPemesanan');
$routes->add('/hapusPemesanan/(:num)', 'Home::hapusPemesanan/$1');

// Kasir
$routes->add('/kasir', 'Home::kasir');
$routes->add('/pembayaran/(:any)', 'Home::pembayaran/$1');
$routes->add('/cetakTransaksi/(:any)', 'Home::cetakTransaksi/$1');
$routes->add('/simpanTransaksi/(:any)', 'Home::simpanTransaksi/$1');

// User
$routes->add('/user', 'Home::user');
$routes->add('/tambahUser', 'Home::tambahUser');
$routes->add('/simpanUser', 'Home::simpanUser');
$routes->add('/editUser/(:num)', 'Home::editUser/$1');
$routes->add('/updateUser', 'Home::updateUser');
$routes->add('/hapusUser', 'Home::hapusUser');
$routes->add('/hapusUser/(:num)', 'Home::hapusUser/$1');

// Akun
$routes->add('/akun', 'Home::akun');
$routes->add('/updateAkun', 'Home::updateAkun');

// Riwayat
$routes->add('/riwayat', 'Home::riwayat');
$routes->add('/riwayat/(:any)', 'Home::riwayat/$1');

// Logout
$routes->add('/logout', 'Home::logout');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
