<?php
include("./configuracion.php");
encabezado_menu("Inicio");
//Obtenemos los datos del alumno a partir de la variable de sesión
$cod_alu = $_SESSION["usuario"][0];
// Conectamos a la base de datos
$conexion = conexion();

// Realizamos la consulta para obtener los datos del alumno
$sql = "SELECT * FROM alumnos WHERE cod_alu = '$cod_alu'";
$ejecucion = $conexion->query($sql);

// Comprobamos si se encontró algún resultado
if (mysqli_num_rows($ejecucion) > 0) {
    // Si se encontró algún resultado, mostramos los datos del alumno
    $registro = $ejecucion->fetch_assoc();
    echo "<h1>Bienvenido, " . $registro["nom_alu"] . "</h1>";
    echo "<p>Correo electrónico: " . $registro["ema_alu"] . "</p>";
    echo "<p>Fecha de registro: " . fecha($registro["fec_alu"]) . "</p>";
    // Aquí podríamos mostrar más información sobre el alumno si lo deseamos
} else {
    // Si no se encontró ningún resultado, mostramos un mensaje de error
    echo "<h1>Error: No se encontraron datos del alumno</h1>";
}
?>
<h3>Libro Reservado o En Lista de Espera:</h3>
    <table class='table'>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Editorial</th>
                <th>Fecha de Reserva</th>
                <th>Fecha Máx. Recogida</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
<div  style="display:grid; place-items:center;">

<?php
// Realizamos la consulta para obtener los libros reservados por el usuario
$sql = "SELECT libros.tit_lib, libros.aut_lib, libros.edi_lib, reservas.cod_rva, reservas.fec_rva,reservas.fec_rec,reservas.fec_dev,reservas.est_res
            FROM reservas INNER JOIN libros ON reservas.lib_rva = libros.cod_lib
            WHERE reservas.alu_rva = '$cod_alu' AND (reservas.est_res = 0 || reservas.est_res = 1)";
$ejecucion = $conexion->query($sql);

// Comprobamos si se encontró algún resultado
if (mysqli_num_rows($ejecucion) > 0) {
    // Si se encontró algún resultado, mostramos los libros reservados
?>
        <?php

        while ($registro = $ejecucion->fetch_assoc()) {
            echo "<tr style='vertical-align: middle'>
        <td>" . $registro["tit_lib"] . "</td>
        <td>" . $registro["aut_lib"] . "</td>
        <td>" . $registro["edi_lib"] . "</td>
        <td>" . fecha($registro["fec_rva"]) . "</td>
        <td>" . fecha($registro["fec_rec"]) . "</td>
                <td>";
?>
<?php
            if ($registro["est_res"] == 0) {
                // Verificar si el estudiante tiene un libro reservado, 0 es solo reserva, 1 es reserva y recogido
                echo "<i id='borrarReserva' onclick='cancelar(\"reserva\",3," . $registro['cod_rva'] . ")' onmouseover='cambiar(this.id)' onmouseout='volver(this.id)' class='bi bi-trash-fill text-danger d-inline-block fw-bold fs-2'></i>";
            } else {
                echo "<div class='alert alert-danger text-center m-0'><span>Devolver antes del " . fecha($registro['fec_dev']) . "</span></div>";
            }
            "</td>
            </tr>";
        }
    } else {
        // Si no se encontró ningún resultado, mostramos un mensaje de error
        echo "<td>No tienes ningún libro reservado.</td>
        </tr>";
    }

// Realizamos la consulta para obtener los libros en "lista de espera" por el usuario

    $sql = "SELECT *
FROM lista_espera INNER JOIN libros ON lista_espera.lib_esp = libros.cod_lib
WHERE lista_espera.alu_esp = '$cod_alu' AND lista_espera.est_esp = 0";
    $ejecucion = $conexion->query($sql);
    $registro = $ejecucion->fetch_assoc();


    // Comprobamos si se encontró algún resultado
    if (mysqli_num_rows($ejecucion) > 0) {
        // Si se encontró algún resultado, mostramos el libro en espera
        echo "<tr style='vertical-align: middle'>
        <td>" . $registro["tit_lib"] . "</td>
        <td>" . $registro["aut_lib"] . "</td>
        <td>" . $registro["edi_lib"] . "</td>
        <td>" . fecha($registro["fec_esp"]) . "</td>
        <td>(Lista de espera)</td>
        <td><i id='borrarEspera' onclick='cancelar(\"cancelaespera\",2," . $registro['cod_esp'] . ")' onmouseover='cambiar(this.id)' onmouseout='volver(this.id)' class='bi bi-trash-fill text-danger d-inline-block fw-bold fs-2'></i>
        </td></tr>";
    }
else {
    // Si no se encontró ningún resultado, mostramos un mensaje de error
    echo "<tr><td>No tienes ningún libro en Lista de Espera.</td></tr>";
}
?>
</div>
</tbody></table>
<?php
    // Cerramos la conexión a la base de datos
    $conexion->close();
        ?>
        </tbody>
        <script>
            function cerrar_session() {
                $.post(
                    "./configuracion.php", {
                        cerrar_session: ""
                    },
                    function(cerrarsesion) {
                        alert(cerrarsesion);
                        location.href = "./../index.php";
                    }
                );

            }

            function cancelar(nombre, accion, cod) {
                // alert(accion);
                // alert(cod);
                $.post(
                    "./devoluciones.php", {
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
                    cursor: "default",
                    boxShadow: "none"
                });
            }
        </script>
        </body>

        </html>