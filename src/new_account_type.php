<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');



$insert = "INSERT INTO task (NOMBRE_TIPO_CUENTA) VALUES ('".$_POST['tipo']."')";

if ( $mysql -> query ( $insert ) === TRUE ) {

    $mysql->close();

    echo 'OK';

} else {

    echo "Error al insertar un tipo de cuenta: " . $insert . "<br>" . $mysql->error;

}

?>