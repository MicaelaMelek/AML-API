<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Empresa
 * @package App
 */
class Empresa extends Model
{
    protected $fillable = ['nombre', 'razon_social', 'cuit'];
}
