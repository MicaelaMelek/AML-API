<?php

namespace App\Http\Controllers\Api\v1;

use App\Cliente;
use App\Transformers\ClienteTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Factory;

/**
 * Class ClienteController
 * @package App\Http\Controllers\Api\v1
 */
class ClienteController extends ApiController
{
    private $clienteTransformer;

    /**
     * ClienteController constructor.
     * @param ClienteTransformer $clienteTransformer
     */
    public function __construct(ClienteTransformer $clienteTransformer)
    {
        $this->clienteTransformer =  $clienteTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clientes = Cliente::whereNombre($request->get('nombre'))
            ->whereCuil($request->get('cuil'))
            ->whereCuit($request->get('cuit'))
            ->whereEmpresa($request->get('empresa'))
            ->pagina(15);

        return $this->respondCollection($clientes, $this->clienteTransformer);
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
            'nombre'     => 'required|max:150',
            'cuil'       => 'required_without:cuit',
            'cuit'       => 'required_without:cuil',
            'empresa_id' => 'required|exists:empresa:id'
        ]);

        if ($validations->fails()) {
            return $this->respondValidationFail($validations->errors());
        }

        $cliente = Cliente::create([
            'nombre'        => $request->get('nombre'),
            'cuit'          => str_replace('-', '', $request->get('cuit')),
            'cuil'          => str_replace('-', '', $request->get('cuil')),
            'empresa_id'    => $request->get('empresa_id'),
        ]);

        return $this->respondItem($cliente, $this->clienteTransformer);
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
            $cliente = Cliente::with(['empresa','facturas'])->findOrFail($id);
            return $this->respondItem($cliente, $this->clienteTransformer);
        } catch (ModelNotFoundException $exception) {
            return $this->respondNotFound('No se encontro el cliente');
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
            $cliente = Cliente::findOrFail($id);
            $cliente->update([
                'nombre'        => $request->get('nombre'),
            ]);
            return $this->respondItem($cliente, $this->clienteTransformer);
        } catch (ModelNotFoundException $exception) {
            return $this->respondNotFound('No se encontro el cliente');
        } catch (QueryException $queryException) {
            Log::info('Error con el cliente '.$queryException->getMessage());
            return $this->respondInternalError('Intente nuevamente más tarde');
        }
    }

}
