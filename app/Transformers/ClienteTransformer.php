<?php

namespace App\Transformers;

use App\Cliente;
use League\Fractal\TransformerAbstract;

/**
 * Class ClienteTransformer
 * @package App\Transformers
 */
class ClienteTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Cliente $cliente
     * @return array
     */
    public function transform(Cliente $cliente)
    {
        return [
            'nombre'        =>  $cliente->nombre,
            'cuit'          =>  $cliente->cuit,
            'cuil'          =>  $cliente->cuil,
            'empresa_id'    =>  $cliente->empresa_id,
            'created_at'    =>  $cliente->created_at,
            'updated_at'    =>  $cliente->updated_at,
        ];
    }
}
