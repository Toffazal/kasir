<?php

namespace App\Models;

use CodeIgniter\Model;

class History extends Model
{

  protected $table = 'history';
  protected $allowedFields = ['no_pesanan', 'nama_pemesan', 'username', 'nama', 'harga', 'jumlah', 'waktu'];



}