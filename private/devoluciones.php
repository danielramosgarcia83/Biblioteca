<?php
session_start();
if (isset($_SESSION["usuario"]))
{
    // Conexión a la base de datos
    include("./configuracion.php");
    $conexion = conexion();
    // Recibir los datos por POST:
    //ADMINISTRADOR, accion 1 y 2 (Entrega o devolucion)
    //USUARIO CANCELA reserva, accion 3
    //USUARIO CANCELA libro en espera, accion "cancelaespera"

    if (($_POST["accion"] == 3) || ($_POST["button"] == "cancelaespera"))
    {
        //USUARIO CANCELA RESERVA
        $cod_recibido = $_POST["num_reserva"];
        $accion = $_POST["accion"];
        $setReserva="est_res='$accion'";
        $setEspera="est_esp=2"; //cancelacion libro en espera
    }
    else
    {
        //ACCIONES DEL ADMINISTRADOR
        $cod_recibido = $_POST["num_reserva"];
        $fecha_dev = $_POST["fecha"];
        $accion = $_POST["accion"];
        $setReserva="fec_ent='$fecha_dev',est_res='$accion'";
    }

    // Actualizar la tabla reservas ESTO siempre, 1, 2 o 3. o / lista de espera.

    if ( $_POST["button"] != "cancelaespera")
    {
        $sql = "UPDATE reservas SET $setReserva WHERE cod_rva=$cod_recibido";
    } else {
        # lista espera
        $sql = "UPDATE lista_espera SET $setEspera WHERE cod_esp=$cod_recibido";

    }
    



        if ($conexion->query($sql))
        {
            //AHORA VIENE ACTUALIZAR ALUMNO Y LIBRO, si es 3 (Reserva cancelada) ambos en CERO
            //Si es 2 (LIBRO DEVUELTO), ambos en CERO, como en el caso 3 (Cancelacion de Reserva)
            //Si es 1 (Entrega) nada, se mantienen en 1
            //Entonces solo tengo saber sino es 1, de resto 2 y 3 (else) misma accion.
            if ($_POST["accion"] != 1 || $_POST["button"] == "cancelaespera")
            
        {
            if ($_POST["button"] == "cancelaespera")
            {
                # LIBRO EN LISTA ESPERA CANCELADO (USUARIO)
                $setAlu="espera=0";
                $setLibro="dis_lib=0";
            }
            else
            {
                # LIBRO CANCELADO (USUARIO) O DEVUELTO (ADMINISTRADOR)
                $setAlu="reserva=0";
                $setLibro="dis_lib=0";
            }
            


            //LISTA DE ESPERA. SI HAY REGISTRO (EL MAS ANTIGUO) ESTADO 1 ALU SIN RESERVA, DEBE ASIGNAR RESERVA A ESE ALUMNO

        }    
            else
        {
            # LIBRO ENTREGADO (ADMINISTRADOR)
            $setAlu="reserva=1";
            $setLibro="dis_lib=1";

        }
        
            // Actualizar la tabla alumnos
            if ($_POST["button"] != "cancelaespera")
            {
                $alu_rva = "SELECT alu_rva FROM reservas WHERE cod_rva=$cod_recibido";
                $ejecucion = $conexion->query($alu_rva);
                $fila = $ejecucion->fetch_assoc();
                $cod_alu = $fila["alu_rva"];
                echo " *$setAlu";
            }
            else
            {
                $alu_esp = "SELECT alu_esp FROM lista_espera WHERE cod_esp=$cod_recibido";
                $ejecucion = $conexion->query($alu_esp);
                $fila = $ejecucion->fetch_assoc();
                $cod_alu = $fila["alu_esp"];
                echo "XX $setAlu";

            }

            $sql = "UPDATE alumnos SET $setAlu WHERE cod_alu=$cod_alu";
            echo "reserva=$setAlu";
        
            if ($conexion->query($sql))
            {
                // Actualizar la tabla libros
                if ($_POST["button"] != "cancelaespera")
                {
                
                
                $lib_rva = "SELECT lib_rva FROM reservas WHERE cod_rva=$cod_recibido";
                $ejecucion = $conexion->query($lib_rva);
                $fila = $ejecucion->fetch_assoc();
                $cod_lib = $fila["lib_rva"];
                $sql = "UPDATE libros SET $setLibro WHERE cod_lib=$cod_lib";
                } else {
                    # De momento nada, porque en libro no existe un campo para acciones por movimientos en la tabla de lista de espera
                }

                if ($conexion->query($sql)) {
                    echo "Los datos se actualizaron correctamente.";
                } else {
                    echo "Error actualizando la tabla libros: ";
                }
            }
            else
            {
                echo "Error actualizando la tabla alumnos: ";
            }
    }
    else
        {
            echo "Error actualizando la tabla reservas: ";
        }
        // Cerrar la conexión a la base de datos
        $conexion->close();
    }
    else
    {
    echo "Sin Session";
    }
?>