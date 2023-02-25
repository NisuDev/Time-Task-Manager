<?php

session_start();

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

$delete = "DELETE FROM intervals WHERE ID = ".$_POST['id']."";

if ( $mysql -> query ( $delete ) === TRUE ) {

    $mysql->close();

    echo 'OK';

} else {

    echo "ERROR: " . $delete . "<br>" . $mysql->error;

}

?>