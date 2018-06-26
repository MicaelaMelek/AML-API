<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Factura
 * @package App
 */
class Factura extends Model
{
    protected $fillable = ['numero', 'subtotal', 'iva', 'total', 'empresa_id', 'cliente_id'];
}
