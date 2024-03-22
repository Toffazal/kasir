<?php

namespace App\Models;

use CodeIgniter\Model;

class Menu extends Model
{

  protected $table = 'menu';
  protected $allowedFields = ['slug', 'nama', 'harga'];



}