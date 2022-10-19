<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'accountmaganer');

$delete = "DELETE FROM cuentas WHERE ID = ".$_POST['idCuenta']."";

if ( $mysql -> query ( $delete ) === TRUE ) {

    $mysql->close();

    echo 'OK';

} else {

    echo "Error al eliminar la cuenta: " . $delete . "<br>" . $mysql->error;

}

?>