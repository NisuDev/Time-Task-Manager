<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'accountmaganer');

$delete = "DELETE FROM tipo_cuenta WHERE ID = ".$_POST['idTipoCuenta']."";

if ( $mysql -> query ( $delete ) === TRUE ) {

    $mysql->close();

    echo 'OK';

} else {

    echo "Error al eliminar el tipo cuenta: " . $delete . "<br>" . $mysql->error;

}

?>