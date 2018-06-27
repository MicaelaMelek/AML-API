<?php

namespace App\Http\Controllers\Api\v1;

use App\Empresa;
use App\Transformers\EmpresaTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Factory;

/**
 * Class EmpresaController
 * @package App\Http\Controllers\Api\v1
 */
class EmpresaController extends ApiController
{
    private $empresaTransformer;

    /**
     * EmpresaController constructor.
     * @param EmpresaTransformer $empresaTransformer
     */
    public function __construct(EmpresaTransformer $empresaTransformer)
    {
        $this->empresaTransformer = $empresaTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $empresa = Empresa::whereNombre($request->get('nombre'))
            ->whereRazonSocial($request->get('razon_social'))
            ->whereCuit($request->get('cuit'))
            ->paginate(15);

        return $this->respondCollection($empresa, $this->empresaTransformer);
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
            'nombre' => 'required|max:150',
            'razon_social' => 'required|max:150',
            'cuit' => 'required|unique:empresas,cuit',
        ]);

        if ($validations->fails()) {
            return $this->respondValidationFail($validations->errors());
        }

        $empresa = Empresa::create([
            'nombre'        => $request->get('nombre'),
            'razon_social'  => $request->get('razon_social'),
            'cuit'          => str_replace('-', '', $request->get('cuit')),
        ]);

        return $this->respondItem($empresa, $this->empresaTransformer);
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
            $empresa = Empresa::with(['clientes','facturas'])->findOrFail($id);
            return $this->respondItem($empresa, $this->empresaTransformer);
        } catch (ModelNotFoundException $exception) {
            return $this->respondNotFound('No se encontro la empresa');
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
            $empresa = Empresa::findOrFail($id);
            $empresa->update([
                'nombre'        => $request->get('nombre'),
            ]);
            return $this->respondItem($empresa, $this->empresaTransformer);
        } catch (ModelNotFoundException $exception) {
            return $this->respondNotFound('No se encontro la empresa');
        } catch (QueryException $queryException) {
            Log::info('Error con la empresa '.$queryException->getMessage());
            return $this->respondInternalError('Intente nuevamente más tarde');
        }
    }

}
