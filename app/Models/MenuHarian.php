<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuHarian extends Model
{

  protected $table = 'menu_harian';
  protected $allowedFields = ['nama', 'harga', 'jumlah'];



}