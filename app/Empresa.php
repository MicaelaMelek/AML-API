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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientes()
    {
        return $this->hasMany('App\Cliente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }
}
