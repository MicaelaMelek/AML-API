<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 * @package App
 */

class Cliente extends Model
{
    protected $fillable = ['nombre', 'cuit', 'cuil', 'empresa_id'];
}
