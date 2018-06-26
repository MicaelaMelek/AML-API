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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'empresa_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }
}
