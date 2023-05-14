<?php
include("./private/configuracion.php");

$password = $_POST["password"];
		$passwordRepe = $_POST["repe_password"];
		if ($password == $passwordRepe)
		{
			$password_encrip = password_hash($password, PASSWORD_DEFAULT);
			$nombre = $_POST["nombre"];
			$email = $_POST["email"];
			$fecha = date("Y-m-d");

			$consulta = new CRUD("alumnos", "*", "WHERE ema_alu='$email'");
			$ejecucion = $consulta->buscar();

			if (!$ejecucion->fetch_array())
			{
				$insertar = new CRUD("alumnos", "nom_alu,ema_alu,pas_alu,fec_alu,reserva,espera,tipo", "'$nombre','$email','$password_encrip','$fecha',0,0,0");
				if ($insertar->Crear())
				{
					alerta("Registrado", "./index.php");
				}
				else
				{
					echo "No grabado, ocurrió un error";
				}
			}
			else
			{
				alerta("Usuario ya existe", "./index.php");
			}
		}
		else
		{
			echo "Las contraseñas no coinciden!";
		}
?>
