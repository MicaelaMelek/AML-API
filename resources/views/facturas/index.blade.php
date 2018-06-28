@extends('app')

@section('content')
    <div id="aml" class="row">
        <div class="col-xs-12">
            <h1 class="page-header">Facturas</h1>
        </div>
        <a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#create">
            Nueva Factura
        </a>
        <div class="col-sm-12">
            <div class="clear-fix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Número</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Empresa</th>
                        <th>Cliente</th>
                        <th>Fecha creación</th>
                        <th colspan="2">
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="factura in facturas">
                        <td width="10px">@{{ factura.numero }}</td>
                        <td>@{{ factura.subtotal }}</td>
                        <td>@{{ factura.iva }}</td>
                        <td>@{{ factura.total }}</td>
                        <td>@{{ factura.empresa.nombre }}</td>
                        <td>@{{ factura.cliente.nombre }}</td>
                        <td>@{{ factura.created_at.date }}</td>
                        <td width="10px">
                            <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editFactura(factura)">Editar</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination">
                    <li v-if="pagination.current_page > 1">
                        <a href="#" @click.prevent="changePage(pagination.current_page - 1)">
                            <span>Atras</span>
                        </a>
                    </li>

                    <li v-for="page in pagesNumber" v-bind:class="[ page == isActived ? 'active' : '']">
                        <a href="#" @click.prevent="changePage(page)">
                            @{{ page }}
                        </a>
                    </li>

                    <li v-if="pagination.current_page < pagination.total_pages">
                        <a href="#" @click.prevent="changePage(pagination.current_page + 1)">
                            <span>Siguiente</span>
                        </a>
                    </li>
                </ul>
            </nav>

            @include('facturas.create')
            @include('facturas.edit')
        </div>
    </div>

@endsection
