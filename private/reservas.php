<?php
include("./configuracion.php");
encabezado_menu("Inicio");
?>
<?php
// Conectarse a la base de datos
$conexion = conexion();
// Obtener la información del estudiante
$cod_alu = $_SESSION["usuario"][0]; // Aquí debes obtener el código del estudiante que está iniciando sesión

?>
    <!-- esta seccion es del popup BOOTSTRAP: -->

    <body>
        <div class="modal fade show" id="popup" tabindex="-1" role="dialog" aria-labelledby="popupLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                </div>
            </div>
        </div>
        <!-- esta seccion es del popup BOOTSTRAP: -->

        <!-- Obtener la lista de libros disponibles -->
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="offset-1 col-10">
                    <h1 style="margin-top: 3%;">Libros disponibles</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Editorial</th>
                                <th>Observaciones</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT cod_lib, tit_lib, aut_lib, edi_lib, fpu_lib FROM libros";
                            $ejecucion = $conexion->query($sql);
                            // Mostrar los libros en la tabla
                            if ($ejecucion->num_rows > 0)
                            {
                                foreach ($ejecucion as $registro) 
                                {
                                
                                    $codlibro = $registro["cod_lib"];
                                    echo "<tr>";
                                    echo "<td>" . $registro["tit_lib"] . "</td>";
                                    echo "<td>" . $registro["aut_lib"] . "</td>";
                                    echo "<td>" . $registro["edi_lib"] . "</td>";
                                    echo "<td>Reservado o No disponible hasta (Y-m-d)</td>";

                                    //Busca el libro en la tabla reserva para ver su estado actual
                                    $sqlreserva = "SELECT est_res FROM reservas WHERE lib_rva=$codlibro ORDER BY cod_rva DESC";
                                    $ejecucion = $conexion->query($sqlreserva);

                                    if($registro=$ejecucion->fetch_assoc())
                                    {
                                        $reserva = $registro["est_res"];
                                    }
                                    else
                                    {
                                        $reserva="sin_reserva";
                                    }
                                    
                            ?>

                                    <td>
                                        <span id="<?php echo $codlibro ?>" onclick="mostrarResumen('<?php echo $codlibro ?>', '<?php echo $reserva ?>')" onmouseover="cambiar(this.id)" onmouseout="volver(this.id)">

                                            <i class="bi bi-book"></i>
                                        </span>
                                    </td>
                        <?php
                                    echo "</tr>";
                                }
                            }
                        else {
                            echo "<tr><td colspan='5'>No hay libros</td></tr>";
                        }
                        // Cerrar la conexión a la base de datos
                        $conexion->close();
                        ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <script>
    function recargarPaginaYMostrarResumen(codigo, reserva) {
        location.reload();
        setTimeout(function() {
            mostrarResumen(codigo, reserva);
        }, 100);
        //La idea es, recargar la pantalla antes de mostrar el POPUP en la funcion muestraResumen(),
        //Necesitamos retrasar el POPUP para que le de tiempo de recargar y no de conflicto.
        //para eso es la funcion setTimeout()
    }
    
    function mostrarResumen(codigo, reserva) {
        $.post("busca_reserva.php", {
                reserva: reserva,
                codigo: codigo
            },
            function(busquedaphp) {
                $("#popup .modal-content").html(busquedaphp);
                $("#popup").modal("show");
            }
        )
    };

            function grabacion(accion,codalu, codlib) {

                //alert(codalu, codlib);
                $.post(
                    "./graba_reservas.php", {
                        accion: accion,
                        cod_alu: codalu,
                        cod_lib: codlib,
                    },
                    function(reservas) {
                        if (reservas == "Sin Session") {
                            alert("No has iniciado Session.");
                            window.location.href = "./../index.php";
                        } else {
                            alert(reservas);
                            // Si la actualización fue exitosa, recargar la página para mostrar los cambios
                            window.location.href = "./index.php";
                        }
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
        </script>

    </body>

    </html>