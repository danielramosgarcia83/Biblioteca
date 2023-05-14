		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="UTF-8">
			<title>Registrarse</title>
			<!-- Enlaces de Bootstrap -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
			<link rel="stylesheet" href="./css/style.css">
		</head>
		<style>
			.container {
				margin-top: 100px;
				box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
				background-color: #e3f2fd;
				padding: 30px;
				border-radius: 10px;
			}

			.btn-primary {
				background-color: #1976d2;
				border-color: #1976d2;
			}

			.btn-primary:hover {
				background-color: #0d47a1;
				border-color: #0d47a1;
			}

			.btn-secondary {
				background-color: #546e7a;
				border-color: #546e7a;
			}

			.btn-secondary:hover {
				background-color: #29434e;
				border-color: #29434e;
			}
		</style>
		<main class="offset-1 col-11">
			<div class="container col-6">
				<div style="text-align: right;">
				<a onclick="location.href='./index.php'" class="btn btn-primary"><i class="bi bi-arrow-left-circle"></i></a>
				</div>
				<h1 class="text-center mb-4">Registro de Usuario</h1>
				
				<form action="grabaaltas.php" method="post">
					<div class="form-group">
						<label for="nombre">Nombre</label>
						<input type="text" class="form-control" name="nombre" placeholder="Ingresa tu nombre" required>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" placeholder="Ingresa tu email" required>
					</div>
					<div class="form-group">
						<label for="password1">Contraseña</label>
						<input type="password" class="form-control" name="password" placeholder="Ingresa tu contraseña" required>
					</div>
					<div class="form-group">
						<label for="password2">Repetir Contraseña</label>
						<input type="password" class="form-control" name="repe_password" placeholder="Repite tu contraseña" required>
					</div>
					<input type="hidden" name="formulario" value="alta_usuario">
					<button type="submit" class="btn btn-primary mr-2 mt-2">Registrarse</button>
					<button type="reset" class="btn btn-secondary mt-2">Cancelar</button>
				</form>

			</div>


		</main>
		</body>

		</html>