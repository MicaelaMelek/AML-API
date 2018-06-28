<form method="POST" v-on:submit.prevent="updateFactura(fillFactura.id)">
<div class="modal fade" id="edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<h4>Actualizar Factura</h4>
			</div>
			<div class="modal-body">

				<div class="form-group">
					<label>Subtotal:</label>
					<input class="form-control input-sm " v-model="fillFactura.subtotal" type="number">
				</div>

				<span v-for="error in errors" class="text-danger">@{{ error }}</span>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn btn-primary" value="Actualizar">
			</div>
		</div>
	</div>
</div>
</form>