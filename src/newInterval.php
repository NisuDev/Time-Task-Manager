<?php

session_start();

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

$insert = " INSERT INTO intervals (
                TASK_ID,
                TIME_START,
                TIME_END
            ) VALUES (
            ".$_POST['id'].",
            '".$_POST['timeStart']."',
            '".$_POST['timeEnd']."'
            )";

if ( $mysql -> query ( $insert ) === TRUE ) {

    $mysql->close();

    echo 'OK';

} else {

    echo "Error al insertar la cuenta: " . $insert . "<br>" . $mysql->error;

}

?>