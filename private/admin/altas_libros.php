<?php
include("./../configuracion.php");
encabezado_menu("Administrador");
?>

<!DOCTYPE html>
<html>

<head>
	<title>Formulario para dar de alta libros</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<style>
		textarea {
			float: left;
			width: 100%;
			margin-top: 10px;
			margin-bottom: 10px;
		}

		input[type=text],
		label {
			float: left;
			width: 100%;
			margin-bottom: 5px;
		}

		.submit {
			text-align: center;
		}

		.izquierda {
			float: left;
			width: 50%;
			margin-top: 10px;
			margin-bottom: 10px;
		}

		.img {
			float: left;
		}

		img,
		input[type=file] {
			float: left;
			width: 50%;
			margin-left: 30%;
			margin-right: 30%;
		}

		input[type=button] {
			width: 50%;
			margin-left: 30%;


		}

		.derecha {
			display: none;
			float: left;
			width: 50%;
			margin-top: 10px;
			margin-bottom: 10px;
			max-height: 200px;
		}
	</style>
</head>

<body>
	<div class="container" style="margin-top: 60px">
		<div class="row">
			<div class="offset-1 col izquierda">
				<div class="img">
					<!-- <div><a style="display: none; border-radius: 50%;" id="recarga" href="./altas_libros.php"><i class="fa-solid fa-arrow-rotate-left"></i></a></div>	 -->
					<a href="./altas_libros.php" style="display: inline-block; display: none; padding: 10px; background-color: #008080; color: #fff; border-radius: 50%;"><i class="fa-solid fa-arrow-rotate-left"></i></a>

					<img src="./../../image/200x200.png" alt="" id="imagen">
					<input id="elige_imagen" onclick="elige_imagen()" type="button" value="SUBIR PORTADA">
					<p style="text-align: center; margin-left: 10%;">(Solo archivos JPG)</p>
					<input onchange="enviar()" type="file" name="input_file" id="input_file" hidden>
				</div>
			</div>
			<div class="col derecha" id="derecha">
				<form action="./graba_libros.php" method="post">
					<label for="">Título</label><input type="text" name="titulo" required>
					<label for="">Autor(es)</label><input type="text" name="autor" required>
					<label for="">Editorial</label><input type="text" name="editorial" required>
					<label for="">Año de publicación</label><input type="text" name="ano" required>
					<label for="">ISBN</label><input type="text" name="isbn">
					<label for="">Número de páginas</label><input type="text" name="paginas">
					<label for="">Género literario</label><input type="text" name="genero">
					<label for="">Resumen</label><textarea style="height: 110px;" name="resumen"></textarea>
					<div class="submit">
						<input type="submit" value="GUARDAR">
					</div>
				</form>
			</div>
		</div>
	</div>
	<script>
		function elige_imagen() {
			$("#input_file").click();
		}
		function enviar() {
			imagen = $('#input_file')[0].files[0]; // Obtiene el archivo del input
			if (imagen) {
				metadatos = new FormData(); // Creo un objeto
				metadatos.append('file', imagen); // Agrego el archivo al objeto
				$.ajax({
					url: "./graba_libros.php", // Ruta del script PHP que procesará los datos
					type: 'POST',
					data: metadatos,
					contentType: false,
					processData: false,
					success: function(echoPHP) {
						// alert(echoPHP);
						$("#imagen").attr("src", echoPHP);
						$("#derecha").show();
						$("#imagen").css("margin-left", "0%");
						$("#imagen").css("width", "70%");
						$("input[type=button]").css("margin-left", "0%");
						$("input[type=button]").css("width", "70%");
						$("#input_file").hide();
						$("#elige_imagen").hide();
						$("p").hide();
						$("a").show();
						$("#recarga").show();
					}
				});
			} else {
				alert('Por favor, seleccione un archivo para enviar.');
			}
		};

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
	</script>
</body>

</html>