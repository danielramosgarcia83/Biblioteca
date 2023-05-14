<?php
include("./../configuracion.php");
encabezado_menu("Administrador");
?>
<div class="container" style="margin-top: 60px">
	<h1>Reservas y Entregas</h1>
	<table id="tablaReservas" class="table">
		<thead>

		</thead>
		<tbody>
			<?php
			// Código PHP para mostrar la tabla con los registros de la tabla reservas
			$conexion = conexion();
			$sql = "SELECT r.cod_rva, a.nom_alu, l.tit_lib, r.fec_rva, r.fec_dev, r.est_res
				FROM reservas r INNER JOIN alumnos a ON r.alu_rva = a.cod_alu
				INNER JOIN libros l ON r.lib_rva = l.cod_lib WHERE (r.est_res=0 || r.est_res=1) ORDER BY r.cod_rva DESC";
			$ejecucion = $conexion->query($sql);

			if ($ejecucion->fetch_array()) //SI SON IGUALES ES PORQUE TODO ESTA DEVUELTO
			{
			?>
				<tr>
					<th>Alumno</th>
					<th>Libro</th>
					<th>Estado</th>
					<!-- <th>Fecha de reserva</th>
					<th>Fecha de entrega</th>
					<th>Fecha de devolución</th>
					<th>Dias retrasado</th>
					<th>Acciones</th> -->
					<hr>
				</tr>
				<?php
				foreach ($ejecucion as $registro) {
				?>
					<?php
					echo "<tr style='vertical-align: middle'>";
					echo "<td>" . $registro['nom_alu'] . "</td>";
					echo "<td>" . $registro['tit_lib'] . "</td>";
					echo "<td>" . $registro['est_res'] . "</td>";
					// echo "<td>" . $registro['fec_rva'] . "</td>";
					// echo "<td>" . $registro['fec_dev'] . "</td>";
					echo "<td></td>";
					echo "<td></td>";
					?>
					<td>

						<?php
						if ($registro['est_res'] == 0) {
						?>
						
						<div style="display: flex;align-items: center;justify-content: space-evenly;">
							<input type="date" id="<?php echo $registro['cod_rva'] ?>" value="<?php echo $registro['fec_rva'] ?>" min="<?php echo $registro['fec_rva'] ?>">
								<button onclick="actualizar(<?php echo $registro['cod_rva'] ?>,'1')" class="btn btn-primary btn-devolver" id="Entregado">Entregado</button>
							<i id="borrarReserva" onclick="cancelar('reserva',3,'<?php echo $registro['cod_rva']; ?>')" onmouseover='cambiar(this.id)' onmouseout='volver(this.id)' class='bi bi-trash-fill text-danger d-inline-block fw-bold fs-2' style="float: right;"></i>
							</div>

							<?php
						} else {
							?>
								<input type="date" id="<?php echo $registro['cod_rva'] ?>" value="<?php echo $registro['fec_rva'] ?>" min="<?php echo $registro['fec_rva'] ?>">
								<button onclick="actualizar(<?php echo $registro['cod_rva'] ?>,'2')" class="btn btn-primary btn-devolver" id="Devuelto">Devuelto</button>
							<?php
						}


							?>

					</td>
					
			<?php
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan='5'><h1><hr>No hay reservas.</h1></td></tr>";
			}

			?>
		</tbody>
	</table>
</div>
<script>

	function actualizar(id, accion) {
		var fecha_dev = $("input#" + id).val();
		$.post(
			"./../devoluciones.php", {
				button: "admin",
				num_reserva: id,
				fecha: fecha_dev,
				accion: accion
			},
			function(actualizacionPHP) {
				if (actualizacionPHP == "Sin Session") {
					alert("No has iniciado Session.");
					window.location.href = "./../../index.php";
				} else {
					alert(actualizacionPHP);
					// Si la actualización fue exitosa, recargar la página para mostrar los cambios
					location.reload();
				}
			});
	}

	function cerrar_session() {
		$.post(
			"./../configuracion.php", {
				cerrar_session: ""
			},
			function(cerrarsesion) {
				alert(cerrarsesion);
				window.location.href = "./../../index.php";
			}
		);
	}

	function cancelar(nombre, accion, cod) {
		// alert(accion);
		// alert(cod);
		$.post(
			"./../devoluciones.php", {
				button: nombre,
				accion: accion,
				num_reserva: cod
			},
			function(devoluciones) {

				alert(devoluciones);
				// Si la actualización fue exitosa, recargar la página para mostrar los cambios
				location.reload();

			});
	}

	function cambiar(id) {
		$("#" + id).css({
			color: "red",
			cursor: "pointer",
			boxShadow: "0px 0px 10px #28a745"
		});
	}

	function volver(id) {
		$("#" + id).css({
			color: "black",
			cursor: "default",
			boxShadow: "none"
		});
	}
</script>
</body>

</html>