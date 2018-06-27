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

    protected $guarded = ['empresa_id', 'cliente_id'];

    protected $dates = ['created_at', 'updated_at'];

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
     * @return Factura
     */
    public function scopeWhereNumero($query, $numero)
    {
        if (empty($numero)) {
            return $this;
        }

        return $query->where('numero', $numero);
    }

    /**
     * @param $query
     * @param $subTotal
     * @return Factura
     */
    public function scopeWhereSubtotal($query, $subTotal)
    {
        if (empty($subTotal)) {
            return $this;
        }

        return $query->where('subtotal', $subTotal);
    }

    /**
     * @param $query
     * @param $iva
     * @return Factura
     */
    public function scopeWhereIVA($query, $iva)
    {
        if (empty($iva)) {
            return $this;
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
            return $this;
        }

        return $query->where('total', $total);
    }

    /**
     * @param $query
     * @param $empresaNombre
     * @return Factura
     */
    public function scopeWhereEmpresa($query, $empresaNombre)
    {
        if (!empty($empresaNombre)) {
            return $query->whereHas('empresa', function ($query) use ($empresaNombre) {
                return $query->where('nombre', 'LIKE', "%$empresaNombre%");
            });
        }

        return $this;
    }

    /**
     * @param $query
     * @param $clienteNombre
     * @return Factura
     */
    public function scopeWhereCliente($query, $clienteNombre)
    {
        if (!empty($cliente)) {
            return $query->whereHas('cliente', function ($query) use ($clienteNombre) {
                return $query->where('nombre', 'LIKE', "%$clienteNombre%");
            });
        }

        return $this;
    }

}
