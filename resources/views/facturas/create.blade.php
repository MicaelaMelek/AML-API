<form method="POST" v-on:submit.prevent="createFactura">
<div class="modal fade" id="create">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<h4>Nueva Factura</h4>
			</div>
			<div class="modal-body">
                <div class="form-group">
                    <label>Numero:</label>
                    <input class="form-control" v-model="newFactura.numero" type="text">
                </div>

                <div class="form-group">
                    <label>Subtotal:</label>
                    <input class="form-control input-sm " v-model="newFactura.subtotal" type="number">
                </div>

                <div class="form-group">
                    <label>Empresa:</label>
                    <select v-model="newFactura.empresa_id">
                        <option disabled value="">Seleccionar</option>
                        <option v-for="empresa in empresas" v-bind:value="empresa.id">
                            @{{ empresa.nombre }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Cliente:</label>
                    <select v-model="newFactura.cliente_id">
                        <option disabled value="">Seleccionar</option>
                        <option v-for="cliente in clientes" v-bind:value="cliente.id">
                            @{{ cliente.nombre }}
                        </option>
                    </select>
                </div>

				<span v-for="error in errors" class="text-danger">@{{ error }}</span>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn btn-primary" value="Generar">
			</div>
		</div>
	</div>
</div>
</form>