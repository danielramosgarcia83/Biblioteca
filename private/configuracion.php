<?php
if (isset($_POST["cerrar_session"])) {
    session_start();
    session_destroy();
    echo "Adios, " . $_SESSION['usuario'][1];
}
function conexion()
{
	/*
    $servidor = "sql301.epizy.com";
    $usuario = "epiz_34061090";
    $password = "bjdT3kXdcohgsH";
    $bd = "epiz_34061090_biblioteca";
	*/
     $servidor = "localhost";
     $usuario = "root";
     $password = "";
     $bd = "biblioteca";
    return new mysqli($servidor, $usuario, $password, $bd);
}
class CRUD
{
    public $campos, $tabla, $condicion, $conexion;
    function __construct($tab, $camp, $buscar_o_insertar)
    {
        $this->campos = $camp;
        $this->condicion = $buscar_o_insertar;
        $this->tabla = $tab;
        $this->conexion = conexion();
    }

    function Crear()
    {

        $sql = "INSERT INTO $this->tabla ($this->campos) VALUES ($this->condicion)";
        return $this->conexion->query($sql);
    }

    function buscar()
    {
        $sql = "SELECT $this->campos FROM $this->tabla $this->condicion";
        return $this->conexion->query($sql);
    }

    function buscarFetchAssoc()
    {
        return $this->conexion->query("SELECT $this->campos FROM $this->tabla $this->condicion")->fetch_assoc();
    }
}

function alerta($mensaje, $link)
{
    echo "
    <script>
            alert('$mensaje');
            window.location.href='$link';    
    </script>
    ";
}

function fecha($fecha)
{
    $fecha = strtotime($fecha);
    $dia   = date('d', $fecha);
    $mes = date('m', $fecha);
    $year  = date('Y', $fecha);
    $fecha_nueva = $dia;
    $fecha_nueva .= "-$mes-";
    $fecha_nueva .= $year;
    return $fecha_nueva;
}

function encabezado_menu($titulo)
{
    session_start();
    if (isset($_SESSION["usuario"])) {
        if ($_SESSION["usuario"][3] == "0") {

            // MENU USUARIOS
?>
            <!DOCTYPE html>
            <html>

            <head>
                <meta charset="UTF-8">
                <title><?php echo $titulo ?></title>
                <!-- Enlaces de Bootstrap -->
                <script src="https://kit.fontawesome.com/7b8eabe9ec.js" crossorigin="anonymous"></script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
                <link rel="stylesheet" href="./../css/style.css">
            </head>

            <body>
                <header>

                    <body class="col-12">
                        <aside class="col-1">

                        </aside>
                        <nav class="col-12 navbar navbar-dark bg-dark fixed-top">
                            <div class="container-fluid">
                                <a id="usuario_encabezado" class="navbar-brand" href="./login.php">Usuario: <?php echo $_SESSION['usuario'][1] ?>.</a>
                                <!--ESTA CLASE MUEVE LOS BOTONES A LA DERECHA -->
                                <div class="ms-auto mx-2">
                                    <a onclick="location.href='./index.php'" class="btn btn-primary"><i class="bi bi-house"></i></a>
                                    <!-- <a onclick="history.back()" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i></a> -->
                                    <!--HASTA AQUI -->
                                </div style="margin-lef">
                                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                                    <div class="offcanvas-header">
                                        <h5 class="offcanvascd-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">


                                            <li class="nav-item">
                                                <a class="nav-link" aria-current="page" href="./index.php"><i class="bi bi-house"></i> Inicio</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="reservas.php"><i class="bi bi-calendar"></i> Reservas</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" onclick="cerrar_session()"><i class="bi bi-box-arrow-right"></i> Salir</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Link</a>
                                            </li>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Dropdown
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-dark">
                                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <form class="d-flex mt-3" role="search">
                                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                            <button class="btn btn-success" type="submit">Search</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </nav>
                </header>

            <?php

        } else {
            //MENU ADMINISTRADORES

            ?>
                <!DOCTYPE html>
                <html>

                <head>
                    <meta charset="UTF-8">
                    <title><?php echo $titulo ?></title>
                    <!-- Enlaces de Bootstrap -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
                    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">

                    <!-- Agregar el icono de calendario -->

                    <script src="https://kit.fontawesome.com/7b8eabe9ec.js" crossorigin="anonymous"></script>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
                    <link rel="stylesheet" href="./../../css/style.css">
                </head>

                <body>
                    <header>

                        <body class="col-12">
                            <aside class="col-1">

                            </aside>
                            <nav class="col-12 navbar navbar-dark bg-dark fixed-top">
                                <div class="container-fluid">
                                    <a id="usuario_encabezado" class="navbar-brand" href="./login.php">Usuario: <?php echo $_SESSION['usuario'][1] ?>.</a>
                                    <!--ESTA CLASE MUEVE LOS BOTONES A LA DERECHA -->
                                    <div class="ms-auto mx-2">
                                        <a onclick="location.href='./index.php'" class="btn btn-primary"><i class="bi bi-house"></i></a>
                                        <a onclick="location.href='./reservas_admin.php'" class="btn btn-primary"> <i class="bi bi-book"></i>
                                        </a>

                                        <!-- <a onclick="history.back()" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i></a> -->
                                        <!--HASTA AQUI -->
                                    </div style="margin-lef">
                                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                                        <div class="offcanvas-header">
                                            <h5 class="offcanvascd-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <div class="offcanvas-body">
                                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">


                                                <li class="nav-item">
                                                    <a class="nav-link" aria-current="page" href="./index.php"><i class="bi bi-house"></i> Inicio</a>
                                                </li>
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-book"></i>
                                                        Libros
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-dark">
                                                    
                                                        <li><a class="dropdown-item" href="#">Catalogo</a></li>
                                                        <li><a class="dropdown-item" href="./altas_libros.php">Altas Libros</a></li>
                                                        <li><a class="dropdown-item" href="./reservas_admin.php">Reservas</a></li>
                                                        <li><a class="dropdown-item" href="#">Lista de Espera</a></li>
                                                        <!-- <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                                                    </ul>
                                                    <!-- <li class="nav-item">
                                            <a class="nav-link" href="#">Link</a>
                                        </li> -->
                                                </li>

                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-people"></i>
                                                        Usuarios
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-dark">
                                                        <li><a class="dropdown-item" href="#">Perfiles</a></li>
                                                        <li><a class="dropdown-item" href="#">Hacer administrador</a></li>
                                                    </ul>
                                                </li>

                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-receipt"></i>
                                                        Informes / Estadisticas
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-dark">
                                                        <li><a class="dropdown-item" href="#">Prestamos</a></li>
                                                        <li><a class="dropdown-item" href="#">+ Populares</a></li>
                                                        <li><a class="dropdown-item" href="#">+ Activos</a></li>
                                                        <li><a class="dropdown-item" href="#">Prestamos Vencidos</a></li>
                                                    </ul>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#" onclick="cerrar_session()"><i class="bi bi-box-arrow-right"></i> Salir</a>
                                                </li>
                                            </ul>
                                            <form class="d-flex mt-3" role="search">
                                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                                <button class="btn btn-success" type="submit">Search</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                    </header>

        <?php
        }
    } else {
        alerta("No has iniciado session.", "./../index.php");
    }
}
        ?>