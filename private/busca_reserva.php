<?php
session_start();
$cod_alu = $_SESSION["usuario"][0]; // Aquí debes obtener el código del estudiante que está iniciando sesión
$codlib=$_POST["codigo"];
$reserva=$_POST["reserva"];
echo "CodLib $codlib - EstadoRes $reserva";
include("./configuracion.php");
$conexion = conexion();
$sql = "SELECT cod_lib, tit_lib, aut_lib, edi_lib, fpu_lib FROM libros WHERE cod_lib = '$codlib'";
$ejecucion = $conexion->query($sql);
// Mostrar los libros en la tabla
$registro = $ejecucion->fetch_assoc();
$codlibro = $registro["cod_lib"];
$titulo = $registro["tit_lib"];
$autor = $registro["aut_lib"];
$editorial = $registro["edi_lib"];
$fechaPublicacion = fecha($registro["fpu_lib"]);

echo "<img src='./../image/libros/$codlibro/$codlibro.jpg'class='mx-auto d-block img-fluid m-2' style='width: 50%';>";
$resumenLibro = "<p><strong>Título:</strong> " . $titulo . "</p>";
$resumenLibro .= "<p><strong>Autor:</strong> " . $autor . "</p>";
$resumenLibro .= "<p><strong>Editorial:</strong> " . $editorial . "</p>";
$resumenLibro .= "<p><strong>Fecha de publicación:</strong> " . $fechaPublicacion . "</p>";
echo "<div class='m-3'>$resumenLibro</div>";


$sql = "SELECT reservas.cod_rva, reservas.cod_rva, reservas.lib_rva, reservas.alu_rva
FROM reservas
INNER JOIN alumnos
ON reservas.alu_rva=alumnos.cod_alu
WHERE reservas.lib_rva=$codlib ORDER BY cod_rva DESC";
$ejecucion = $conexion->query($sql);

$sqlalumno="SELECT reserva, espera FROM alumnos WHERE cod_alu=$cod_alu";
    $ejecucionAlumno = $conexion->query($sqlalumno);
    $registroAlumno = $ejecucionAlumno->fetch_assoc();
    $estadoReservaAlumno = $registroAlumno["reserva"];
    $estadoEsperaAlumno = $registroAlumno["espera"];
    


if ($registro = $ejecucion->fetch_assoc())
{

$codreserva = $registro["cod_rva"];
$alureserva = $registro["alu_rva"];




echo " codRva $codreserva - EstadoRva $reserva - Alumno $cod_alu - AlumnoRva $alureserva";
if ($reserva== 0|| $reserva== 1) //Libro en reserva o entregado?
    {
        if ($cod_alu==$alureserva) //He sido yo?
        {
            //si
            echo "<br><div class='alert alert-danger text-center'><span>Ya lo has reservado. 0-1 yo</span></div>";
        }
        else
        {
            //Otro alumno reservó
            echo "<br><div class='alert alert-danger text-center'><span>Reservado por otro Alumno. 0-1 otros</span></div>";
            //SE PUEDE PONER EN LISTA DE ESPERA,EL ALUMNO LOGEADO SINO TIENE OTRA RESERVA
            if  ($estadoReservaAlumno==1)
            {
                // tengo reserva?

                echo "<br><div class='alert alert-danger text-center'><span>Ya tienes una reserva</span></div>";
                if ($estadoEsperaAlumno==1) //tengo libro en espera?
                {
                    //si
                    echo "<br><div class='alert alert-danger text-center'><span>Ya tienes un libro en Lista de Espera</span></div>";
                }
            
                else
                {
                    //no
                    echo "<button onclick=\"grabacion('espera','".$cod_alu."','".$codlib."')\">LISTA DE ESPERA (DIFERIDO)</button>";
                }
            }
            else
            {
                //no tengo otra reserva
                if ($estadoEsperaAlumno==1) //tengo libro en espera?
                {
                    //si
                    echo "<br><div class='alert alert-danger text-center'><span>Ya tienes un libro en Lista de Espera</span></div>";
                }
            
                else
                {
                    //no
                    echo "<button onclick=\"grabacion('espera','".$cod_alu."','".$codlib."')\">LISTA DE ESPERA</button>";
                }
            }
        }
    }
    else //2-3 libro disponible porque se anulo reserva o se ya se ha devuelto
    {
        if  ($estadoReservaAlumno==1)
        {
        echo "<br><div class='alert alert-danger text-center'><span>Ya tienes una reserva. 2-3 CON</span></div>";
        }
        else
        {
            echo "<button onclick=\"grabacion('reserva','" . $cod_alu . "', '" . $codlib . "')\">RESERVAR.  2-3 SIN</button>";
        }
    }
}
else
{
    if  ($estadoReservaAlumno==1)
    {
    echo "<br><div class='alert alert-danger text-center'><span>Ya tienes una reserva. vacio CON</span></div>";
    }
    else
    {
        echo "<button onclick=\"grabacion('reserva','" . $cod_alu . "', '" . $codlib . "')\">RESERVAR. vacio SIN</button>";
    }
}
// Cerrar la conexión a la base de datos
$conexion->close();
?>