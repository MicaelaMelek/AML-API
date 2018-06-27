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

    /**
     * @param $query
     * @param $nombre
     * @return bool
     */
    public function scopeWhereNombre($query, $nombre)
    {
        if (empty($nombre)) {
            return false;
        }

        return $query->where('nombre', 'LIKE', $nombre);
    }

    public function scopeWhereRazonSocial($query, $razonSocial)
    {
        if (empty($razonSocial)) {
            return false;
        }

        return $query->where('nombre', 'LIKE', $razonSocial);
    }

    /**
     * @param $query
     * @param $cuit
     * @return bool
     */
    public function scopeWhereCuit($query, $cuit)
    {
        if (empty($cuit)) {
            return false;
        }

        return $query->where('cuit', str_replace('-', '', $cuit));
    }

}
