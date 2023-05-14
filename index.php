<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css">
    <title>LOGIN</title>
</head>

<body>
    <div class="wrapper">

        <div class="text-center mt-4 name">
            INICIAR SESION
        </div>
        <form class="p-3 mt-3" action="" method="POST">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="email" placeholder="Email">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" placeholder="Password">
            </div>
            <input class="btn mt-3" type="submit" value="ENTRAR">
        </form>
        <div class="text-center fs-6">
            <a href="./altas.php">REGISTRARSE</a>
        </div>
        <?php
        session_start();
        include("./private/configuracion.php");
        if (!isset($_POST["email"]) == "")
        {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $busqueda = new CRUD("alumnos","*","WHERE ema_alu='$email'");;
            $ejecucion = $busqueda->buscar();
            if ($registro = $ejecucion->fetch_array())
            {

                $hash = $registro["pas_alu"];
                if (password_verify($password, $hash)) {

                    $arrayUsuario=array();
                    array_push($arrayUsuario,$registro["cod_alu"]);
                    array_push($arrayUsuario,$registro["nom_alu"]);
                    array_push($arrayUsuario,$registro["fec_alu"]);
                    array_push($arrayUsuario,$registro["tipo"]);
                    $_SESSION["usuario"] = $arrayUsuario;
                    if ($registro["tipo"]==1)
                    {    
                        alerta("Hola, ".$_SESSION["usuario"][1], "./private/admin/index.php");
                    } else {
                        $_SESSION["usuario"] = $arrayUsuario;
                        alerta("Hola, ".$_SESSION["usuario"][1], "./private/index.php");
                    }
                    
                    

                } else {
                    echo "<br><p style='text-align:center; color:red'>Email/Password<br>incorrectos</p>";
                }
            }
            else {
                echo "<br><p style='text-align:center; color:red'>Email/Password<br>incorrectos</p>";
            }
        }
        else {
            // echo "<br><p style='text-align:center; color:red'>Email/Password<br>incorrectos</p>";
        }
        ?>
    </div>

    <script src="./css/all.css"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/all.js"></script>
    <script src="./js/jquery.min.js"></script>
</body>

</div>

</div>
</div>

</html>