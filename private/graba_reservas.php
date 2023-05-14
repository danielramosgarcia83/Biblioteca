<?php
session_start();
include("./configuracion.php");
if (isset($_SESSION["usuario"])) {

        // Conexión a la base de datos
        $conexion = conexion();

        // Obtener los datos del formulario
        $alumno = $_POST["cod_alu"];
        $libro = $_POST["cod_lib"];
        $accion = $_POST["accion"];
        $ahora = date('Y-m-d');
        //CALCULO DE DIAS LABORALES:
        //retirada:
        $fecha_recogida = date('Y-m-d');
        $dias_laborales_a_sumar = 3;
        $dias_sumados = 0;

        while ($dias_sumados < $dias_laborales_a_sumar) {
                $dia_de_la_semana = date('N', strtotime($fecha_recogida)) . " <br>";
                if ($dia_de_la_semana < 6) {
                        $dias_sumados++;
                }
                $fecha_recogida = date('Y-m-d', strtotime($fecha_recogida . '+1 day'));
        }

        //Devolucion:
        $fecha_devolucion = date('Y-m-d');
        $dias_laborales_a_sumar = 15;
        $dias_sumados = 0;

        while ($dias_sumados < $dias_laborales_a_sumar) {
                $dia_de_la_semana = date('N', strtotime($fecha_devolucion)) . " <br>";
                if ($dia_de_la_semana < 6) {
                        $dias_sumados++;
                }
                $fecha_devolucion = date('Y-m-d', strtotime($fecha_devolucion . '+1 day'));
        }

        //grabamos

        if ($accion == "reserva") {
                //grabacion reserva
                $sql = "INSERT INTO reservas (alu_rva, lib_rva, fec_rva, fec_rec, fec_dev) VALUES ('$alumno', '$libro', '$ahora', '$fecha_recogida', '$fecha_devolucion')";
                $ejecucion = $conexion->query($sql);
                $sql = "UPDATE libros SET dis_lib = 1 WHERE cod_lib = '$libro'";
                $ejecucion = $conexion->query($sql);

                //actualizamos estado alumno para que no pueda reservar un 2do libro:

                $sql = "UPDATE alumnos SET reserva = 1 WHERE cod_alu = '$alumno'";
                $ejecucion = $conexion->query($sql);

                echo "El libro ha sido reservado correctamente";
                $conexion->close();
        } else {
                //No necesito verificar en este punto si ya tiene un libro en "ESPERA" porque ya lo hice en
                //busca_reserva.php con la variable estadoEsperaAlumno.

                $sql = "INSERT INTO lista_espera (alu_esp,lib_esp,fec_esp,est_esp) VALUES ('$alumno', '$libro', '$ahora',0)";
                $conexion->query($sql);

                //actualizamos estado alumno para que no pueda reservar un 2do libro:

                $sql = "UPDATE alumnos SET espera = 1 WHERE cod_alu = '$alumno'";
                $ejecucion = $conexion->query($sql);
                echo "El libro en lista de espera correctamente";
        }
} else {
        echo "Sin Session";
}
