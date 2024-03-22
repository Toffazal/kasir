<?php

namespace App\Models;

use CodeIgniter\Model;

class Pemesanan extends Model
{

  protected $table = 'pemesanan';
  protected $allowedFields = ['no_pesanan', 'nama_pemesan', 'username', 'nama', 'harga', 'jumlah', 'waktu'];



}