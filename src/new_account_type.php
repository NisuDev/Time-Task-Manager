<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'accountmaganer');



$insert = "INSERT INTO tipo_cuenta (NOMBRE_TIPO_CUENTA) VALUES ('".$_POST['nombreTipoCuenta']."')";

if ( $mysql -> query ( $insert ) === TRUE ) {

    $mysql->close();

    echo 'OK';

} else {

    echo "Error al insertar un tipo de cuenta: " . $insert . "<br>" . $mysql->error;

}

?>