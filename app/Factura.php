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

    /**
     * @param $query
     * @param $numero
     * @return bool
     */
    public function scopeWhereNumero($query, $numero)
    {
        if (empty($numero)) {
            return false;
        }

        return $query->where('numero', $numero);
    }

    /**
     * @param $query
     * @param $subTotal
     * @return bool
     */
    public function scopeWhereSubtotal($query, $subTotal)
    {
        if (empty($subTotal)) {
            return false;
        }

        return $query->where('subtotal', $subTotal);
    }

    /**
     * @param $query
     * @param $iva
     * @return bool
     */
    public function scopeWhereIVA($query, $iva)
    {
        if (empty($iva)) {
            return false;
        }

        return $query->where('iva', $iva);
    }

    /**
     * @param $query
     * @param $total
     * @return bool
     */
    public function scopeWhereTotal($query, $total)
    {
        if (empty($total)) {
            return false;
        }

        return $query->where('total', $total);
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

    public function scopeWhereCliente($query, $cliente)
    {
        if (!empty($cliente)) {
            return $query->whereHas('cliente', function ($query) use ($cliente) {
                return $query->where('nombre', $cliente);
            });
        }

        return false;
    }

}
