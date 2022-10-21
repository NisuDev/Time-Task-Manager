<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

if ( $_POST['tipoIngreso'] == 'new' ) {

    $maxId = "SELECT MAX(ID)+1 as 'maximo' FROM day ";

    $result = $mysql -> query( $maxId );

    $arrDay = array();

    while( $row = $result -> fetch_assoc () ) {

        $arrDay['maximo'] = $row['maximo'];
    
    } 

    $insertDay = "INSERT INTO DAY (DAY) VALUES ('".date('Y-m-d', strtotime($_POST['data']))."')";

    if ( $mysql -> query ( $insertDay ) === TRUE ) {
    
        $insert = "INSERT INTO task (DAY_ID,TITLE,DESCRIPTION,APPLICANT,TYPE) VALUES (".$arrDay['maximo'].",'NUEVA TAREA','DESC','APLICANT TEST','".$_POST['tipo']."')";

        if ( $mysql -> query ( $insert ) === TRUE ) {

            echo 'OK';

        }else{

            echo 'ERROR1';

        }
    
    } else {
    
        echo 'ERROR2';
    
    }

} else {

    $maxId = "SELECT ID AS 'maximo' FROM day WHERE DAY = '".$_POST['data']."'";

    $result = $mysql -> query( $maxId );

    $arrDay = array();

    while( $row = $result -> fetch_assoc () ) {

        $arrDay['ID'] = $row['maximo'];
    
    }

    $insert = "INSERT INTO task (DAY_ID,TITLE,DESCRIPTION,APPLICANT,TYPE) VALUES (".$arrDay['ID'].",'TITLE DESK DAY','DESC DAY','APPLICANT TEST','".$_POST['tipo']."')";

    if ( $mysql -> query ( $insert ) === TRUE ) {

        $mysql->close();
    
        echo 'OK';
    
    } else {
    
        echo "Error al insertar " . $insert . "<br>" . $mysql->error;
    
    }
    

}

?>