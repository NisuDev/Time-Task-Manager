<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'accountmaganer');

$updateTipoCuenta = "UPDATE tipo_cuenta SET NOMBRE_TIPO_CUENTA = '".$_POST['nombreTipoCuenta']."' WHERE ID = ".$_POST['id']." ";

if ( $mysql -> query ( $updateTipoCuenta ) === TRUE ) {

    $mysql -> close();

    echo 'OK';

} else {

    echo "Error al actualizar un tipo de cuenta: " . $updateTipoCuenta . "<br>" . $mysql->error;

}

?>