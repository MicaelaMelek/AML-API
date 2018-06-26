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
}
