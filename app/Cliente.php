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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'empresa_id');
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

    /**
     * @param $query
     * @param $cuil
     * @return bool
     */
    public function scopeWhereCuil($query, $cuil)
    {
        if (empty($cuil)) {
            return false;
        }

        return $query->where('cuil', str_replace('-', '', $cuil));
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

    /**
     * @param $query
     * @param $empresa
     * @return bool
     */
    public function scopeWhereEmpresa($query, $empresa)
    {
        if (!empty($empresa)) {
            return $query->whereHas('empresa', function ($query) use ($empresa) {
                return $query->where('nombre', $empresa);
            });
        }

        return false;
    }
}
