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

    protected $guarded = ['empresa_id'];

    protected $dates = ['created_at', 'updated_at'];


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
     * @return Cliente
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
     * @param $cuil
     * @return Cliente
     */
    public function scopeWhereCuil($query, $cuil)
    {
        if (empty($cuil)) {
            return $this;
        }

        return $query->where('cuil', str_replace('-', '', $cuil));
    }

    /**
     * @param $query
     * @param $cuit
     * @return Cliente
     */
    public function scopeWhereCuit($query, $cuit)
    {
        if (empty($cuit)) {
            return $this;
        }

        return $query->where('cuit', str_replace('-', '', $cuit));
    }

    /**
     * @param $query
     * @param $empresa
     * @return Cliente
     */
    public function scopeWhereEmpresa($query, $empresaNombre)
    {
        if (!empty($empresaNombre)) {
            return $query->whereHas('empresa', function ($query) use ($empresaNombre) {
                return $query->where('nombre', 'LIKE' ,"%$empresaNombre%");
            });
        }

        return $this;
    }
}
