<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'accountmaganer');

$insert = "INSERT INTO cuentas (ID_TIPO_CUENTA,CORREO,CONTRASENIA) VALUES (".$_POST['tipoCuentaNuevaCuenta'].",'".$_POST['correoCuenta']."','".$_POST['contraseniaCuenta']."')";

if ( $mysql -> query ( $insert ) === TRUE ) {

    $mysql->close();

    echo 'OK';

} else {

    echo "Error al insertar la cuenta: " . $insert . "<br>" . $mysql->error;

}

?>