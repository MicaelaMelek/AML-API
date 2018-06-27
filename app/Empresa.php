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
     * @return Empresa
     */
    public function scopeWhereNombre($query, $nombre)
    {
        if (empty($nombre)) {
            return $this;
        }

        return $query->where('nombre', 'LIKE', "%$nombre%");
    }

    /**
     * @param $query
     * @param $razonSocial
     * @return Empresa
     */
    public function scopeWhereRazonSocial($query, $razonSocial)
    {
        if (empty($razonSocial)) {
            return $this;
        }

        return $query->where('razon_social', 'LIKE', "%$razonSocial%");
    }

    /**
     * @param $query
     * @param $cuit
     * @return Empresa
     */
    public function scopeWhereCuit($query, $cuit)
    {
        if (empty($cuit)) {
            return $this;
        }

        return $query->where('cuit', str_replace('-', '', $cuit));
    }

}
