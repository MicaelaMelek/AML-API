<?php

namespace App\Transformers;

use App\Empresa;
use League\Fractal\TransformerAbstract;

/**
 * Class EmpresaTransformer
 * @package App\Transformers
 */
class EmpresaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Empresa $empresa
     * @return array
     */
    public function transform(Empresa $empresa)
    {
        return [
            'id'            =>  $empresa->id,
            'nombre'        =>  $empresa->nombre,
            'razon_social'  =>  $empresa->razon_social,
            'cuit'          =>  $empresa->cuit,
            'created_at'    =>  $empresa->created_at,
            'updated_at'    =>  $empresa->updated_at,
        ];
    }
}
