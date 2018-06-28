<?php

namespace App\Transformers;

use App\Factura;
use League\Fractal\TransformerAbstract;

/**
 * Class FacturaTransformer
 * @package App\Transformers
 */
class FacturaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Factura $factura
     * @return array
     */
    public function transform(Factura $factura)
    {
        return [
            'numero'        =>  $factura->numero,
            'subtotal'      =>  $factura->subtotal,
            'iva'           =>  $factura->iva,
            'total'         =>  $factura->total,
            'empresa_id'    =>  $factura->empresa_id,
            'cliente_id'    =>  $factura->cliente_id,
            'empresa'       =>  $factura->empresa,
            'cliente'       =>  $factura->cliente,
            'created_at'    =>  $factura->created_at,
            'updated_at'    =>  $factura->updated_at,
        ];
    }
}
