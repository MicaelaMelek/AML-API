<?php

namespace App\Http\Controllers\Api\v1;

use App\Factura;
use App\Transformers\FacturaTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Factory;

/**
 * Class FacturaController
 * @package App\Http\Controllers\Api\v1
 */
class FacturaController extends ApiController
{
    private $facturaTransformer;

    /**
     * FacturaController constructor.
     * @param FacturaTransformer $facturaTransformer
     */
    public function __construct(FacturaTransformer $facturaTransformer)
    {
        $this->facturaTransformer = $facturaTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $factura = Factura::whereNumero($request->get('numero'))
            ->whereEmpresa($request->get('empresa'))
            ->whereCliente($request->get('cliente'))
            ->whereSubtotal($request->get('subtotal'))
            ->whereIVA($request->get('iva'))
            ->whereTotal($request->get('total'))
            ->paginate(15);

        return $this->respondCollection($factura, $this->facturaTransformer);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Factory $factoryValidation
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Factory $factoryValidation)
    {
        $validations = $factoryValidation->make($request->all(), [
            'numero'        =>  'required',
            'subtotal'      =>  'required',
            'iva'           =>  'required',
            'total'         =>  'required',
            'empresa_id'    =>  'required|exists:empresas,id',
            'cliente_id'    =>  'required|exists:clientes,id',
        ]);

        if ($validations->fails()) {
            return $this->respondValidationFail($validations->errors());
        }

        $factura = Factura::create([
            'numero'        =>  $request->get('numero'),
            'subtotal'      =>  $request->get('subtotal'),
            'iva'           =>  $request->get('iva'),
            'total'         =>  $request->get('total'),
            'empresa_id'    =>  $request->get('empresa_id'),
            'cliente_id'    =>  $request->get('cliente_id')
        ]);

        return $this->respondItem($factura, $this->facturaTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $factura = Factura::with(['empresa','cliente'])->findOrFail($id);
            return $this->respondItem($factura, $this->facturaTransformer);
        } catch (ModelNotFoundException $exception) {
            return $this->respondNotFound('No se encontro la factura');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $factura = Factura::findOrFail($id);
            $factura->update([
            ]);
            return $this->respondItem($factura, $this->facturaTransformer);
        } catch (ModelNotFoundException $exception) {
            return $this->respondNotFound('No se encontro la factura');
        } catch (QueryException $queryException) {
            Log::info('Error con la factura '.$queryException->getMessage());
            return $this->respondInternalError('Intente nuevamente más tarde');
        }
    }

}
