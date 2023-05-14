<?php
include("./../configuracion.php");

//Antes que nada, me gustaria verificar la integridad de las carpetas VS la BD, eliminar las carpetas que no tengan un libro en la BD
//Creare 1 array de cada y comparare, las carpetas sin libro iran en un 3er array y le hare un borrado masivo con array_map()




if (isset($_FILES["file"])) { //Parte positiva es solo para recibir y mostrar la imagen subida para el libro
    $img = $_FILES["file"];
    // $nombre_img = $img["name"]; no lo voy a utilizar, no sabre luego el nombre del libro para buscarlo, pondre el mismo codigo!.
    $ruta_img = $img["tmp_name"];

$buscar_ult_libro=new CRUD("libros","cod_lib, tit_lib","WHERE cod_lib=(SELECT MAX(cod_lib) as MAXIMO from libros)");
$reg=$buscar_ult_libro->buscarFetchAssoc();
$ult_libro= $reg["cod_lib"];
$siguiente_libro= $ult_libro+1;

$con=conexion();
$nuevo_auto_increment="ALTER TABLE libros auto_increment = $siguiente_libro"; //si se borra el ult libro de la tabla, es necesario actualizar el contador ID de la tabla
$con->query($nuevo_auto_increment);

    $ruta_directorio = "./../../image/libros/$siguiente_libro/";

    if (!file_exists($ruta_directorio)) //Puede darse el caso que se borre el libro de la BD pero no la carpeta, en ese caso, no mostraba la imagen subida

    {
    mkdir($ruta_directorio, 0777);
    }
    else {
        //En caso de que existe la carpeta, la dejamos vacia
        //Glob devuelve un array de los archivos en esa ruta
        //array_map aplica una funcion a un array y devuelve el nuevo array, en este caso aplicare unlink(), es decir, eliminar cada archivo del array glob(ruta_directorio)
        array_map('unlink', glob("$ruta_directorio/*.*")); 
    }

    $ruta_completa_img = $ruta_directorio . $siguiente_libro.".jpg"; //aqui preparamos la ruta nueva o existente pero vacia
    if (move_uploaded_file($ruta_img, $ruta_completa_img)) 
    {
        echo $ruta_completa_img;
    }
    else
    {
        echo "Error al guardar la imagen";
    }
}
else {
    if ($_POST["titulo"]) //Aqui viene del formulario para grabar el libro
    {
        $titulo=$_POST["titulo"];
        $autor=$_POST["autor"];
        $editorial=$_POST["editorial"];
        $ano=$_POST["ano"];
        $isbn=$_POST["isbn"];
        $paginas=$_POST["paginas"];
        $resumen=$_POST["resumen"];

    $grabar_nvo_libro=new CRUD("libros","tit_lib,aut_lib,edi_lib,fpu_lib,dis_lib","'$titulo','$autor','$editorial','$ano',0");


    if ($grabar_nvo_libro->Crear())
    {
        alerta("Libro registrado correctamente", "./altas_libros.php");
    }
    else
    {
        alerta("Ocurrió un error", "./altas_libros.php");
    }
    }
else {
    echo "error, no grabó libro";
}
}
?>
