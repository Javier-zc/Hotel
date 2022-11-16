<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hotel California</title>
</head>

<body>
    <?php

    $host = 'localhost';
    $usuario = 'root';
    $contraseña = '';
    $bd = 't3';

    $conexion = mysqli_connect($host, $usuario, $contraseña, $bd)
        or die('Problemas con la conexión');

    session_start();

    $hotelSize = 50;
    $counter = 1;

    /* while ($counter <= $hotelSize) {
        $insert = mysqli_query($conexion, "insert into Hotel(Numero,Estado)
    values ('$counter', 'libre')")
            or die('Problemas al insertar: ' . mysqli_error($conexion));
        $counter++;
    }

    if ($insert) {
        echo "Se han creado las habitaciones con éxito";
    } */

    echo "<form method=post>";
    echo "Selecciona la habitación<br>";
    echo "<input type=number name=room min=1 max=50 required><br>";
    echo "<input type=submit name=ok value=Enviar><br>";
    echo "</form>";

    if (isset($_REQUEST['ok'])) {
        $room = mysqli_query($conexion, "select * from Hotel where Numero='$_REQUEST[room]'");
        $_SESSION['room'] = $_REQUEST['room'];


        if ($row = mysqli_fetch_array($room)) {
            echo "La habitación está $row[Estado]<br>";
            $_SESSION['state'] = $row['Estado'];
            if ($row['Estado'] != 'libre') {
                echo " y su ocupante se llama $row[Huesped]<br>";
            }

            echo "Selecciona que quieres modificar de la habitación";
            echo "<form method=post>";
            echo "<input type=radio name=modify value=estado>Estado<br>";
            echo "<input type=radio name=modify value=huesped>Huesped<br>";
            echo "<input type=submit name=ok2 value=Enviar><br>";
            echo "</form>";
        }
    }

    if (isset($_REQUEST['ok2'])) {
        if ($_REQUEST['modify'] == 'estado') {
            echo "Estado en el que se va a quedar la habitación<br>";
            echo "<form method=post>";
            echo "<select name=roomState>";
            echo "<option value=libre>Libre</option><br>";
            echo "<option value=reservada>Reservada</option><br>";
            echo "<option value=ocupada>Ocupada</option><br>";
            echo "<input type=submit name=okEstado value=Enviar><br>";
            echo "</form>";
        } else {
            echo "Introduce el nombre del cliente.<br>";
            echo "<form method=post>";
            echo "<input type=text name=nombre><br>";
            echo "<input type=submit name=okHuesped value=Enviar><br>";
            echo "</form>";
        }
    }

    if (isset($_REQUEST['okEstado'])) {
        if ($_REQUEST['roomState']) {
            if ($_REQUEST['roomState'] == 'libre') {
                $updateClient = mysqli_query($conexion, "update hotel
                        set Huesped=Null where Numero = '$_SESSION[room]'")
                    or die('Problemas al seleccionar: ' . mysqli_error($conexion));

                $updateClient = mysqli_query($conexion, "update hotel
                        set Estado='$_REQUEST[roomState]' where Numero = '$_SESSION[room]'")
                    or die('Problemas al seleccionar: ' . mysqli_error($conexion));
            } else {
                echo "Introduce el nombre del cliente.<br>";
                echo "<form method=post>";
                echo "<input type=text name=nombre required><br>";
                echo "<input type=submit name=ok4 value=Enviar><br>";
                echo "</form>";


                $updateState = mysqli_query($conexion, "update Hotel
                    set Estado='$_REQUEST[roomState]' where Numero = '$_SESSION[room]'")
                    or die('Problemas al seleccionar: ' . mysqli_error($conexion));
            }
        }
    }

    if (isset($_REQUEST['okHuesped'])) {
        $updateClient = mysqli_query($conexion, "update Hotel
                    set Huesped='$_REQUEST[nombre]' where Numero = '$_SESSION[room]'")
            or die('Problemas al seleccionar: ' . mysqli_error($conexion));

        if ($_SESSION['state'] == 'libre') {
            echo "Estado en el que se va a quedar la habitación<br>";
            echo "<form method=post>";
            echo "<select name=roomState>";
            echo "<option value=reservada>Reservada</option><br>";
            echo "<option value=ocupada>Ocupada</option><br>";
            echo "<input type=submit name=okEstado2 value=Enviar><br>";
            echo "</form>";
        } else {
            echo "Estado en el que se va a quedar la habitación<br>";
            echo "<form method=post>";
            echo "<select name=roomState>";
            echo "<option value=reservada>Reservada</option><br>";
            echo "<option value=ocupada>Ocupada</option><br>";
            echo "<input type=submit name=okEstado2 value=Enviar><br>";
            echo "</form>";

        }
    }
    if (isset($_REQUEST['okEstado2'])) {
        $updateState = mysqli_query($conexion, "update Hotel
                    set Estado='$_REQUEST[roomState]' where Numero = '$_SESSION[room]'")
            or die('Problemas al seleccionar: ' . mysqli_error($conexion));
    }


    if (isset($_REQUEST['ok4'])) {

        $updateClient = mysqli_query($conexion, "update Hotel
                    set Huesped='$_REQUEST[nombre]' where Numero = '$_SESSION[room]'")
            or die('Problemas al seleccionar: ' . mysqli_error($conexion));
    }

    ?>

</body>

</html>