<?php

namespace App\Models;

use CodeIgniter\Model;

class Riwayat extends Model
{

  protected $table = 'riwayat';
  protected $allowedFields = ['no_pesanan', 'nama_pemesan', 'username', 'waktu'];



}