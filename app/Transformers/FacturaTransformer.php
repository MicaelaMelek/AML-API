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
            'id_empresa'    =>  $factura->id_empresa,
            'id_cliente'    =>  $factura->id_cliente
        ];
    }
}
