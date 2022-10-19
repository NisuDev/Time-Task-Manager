<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'accountmaganer');

$selectTipoCuentaQuery = "SELECT NOMBRE_TIPO_CUENTA FROM tipo_cuenta WHERE ID = ".$_POST['idTipoCuenta']."";

$result = $mysql -> query( $selectTipoCuentaQuery );

while( $row = $result -> fetch_assoc () ) {

    $dato = $row [ 'NOMBRE_TIPO_CUENTA' ];

}

if ( $dato ) {

    echo $dato.','.$_POST['idTipoCuenta'];

} else {

    echo '';

}




?>