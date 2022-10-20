<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

function GetInterval($idTask){

    $mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');
    
    $selectInterval = " SELECT 
                            `intervals`.`ID`, 
                            `intervals`.`TIME_START`, 
                            `intervals`.`TIME_END`,
                            TIMESTAMPDIFF(
                                minute,
                                `intervals`.`TIME_START`,
                                `intervals`.`TIME_END`
                            )  as 'DIFF' 
                FROM 
                    `intervals`
                WHERE
                    `intervals`.`TASK_ID` = ".$idTask." ";


    $result = $mysql -> query( $selectInterval );

    $arrInterval = array();

    while( $row = $result -> fetch_assoc () ) {

        $arrInterval[$row['ID']]['ID'] = $row['ID'];
        $arrInterval[$row['ID']]['TIME_START'] = $row['TIME_START'];
        $arrInterval[$row['ID']]['TIME_END'] = $row['TIME_END'];
        $arrInterval[$row['ID']]['DIFF'] = $row['DIFF'];

    }

    if( ! $arrInterval ){

        return NULL;
    
    }

    return $arrInterval;
    
}

$selectCard = " SELECT
                    `day`.`DAY`, 
                    `task`.`TITLE`,
                    `task`.`DESCRIPTION`, 
                    `task`.`APPLICANT`, 
                    `task`.`TYPE`, 
                    `task`.`ID`
                FROM
                    `day` INNER JOIN
                    `task` ON `task`.`DAY_ID` = `day`.`ID` LEFT JOIN
                    `intervals` ON `task`.`ID` = `intervals`.`TASK_ID`
                WHERE
                    `day`.`DAY` = '".$_POST['date']."' ";

$result = $mysql -> query( $selectCard );

$arrCard = array();

while( $row = $result -> fetch_assoc () ) {

    $arrCard[$row['ID']]['ID'] = $row['ID'];
    $arrCard[$row['ID']]['TITLE'] = $row['TITLE'];
    $arrCard[$row['ID']]['DESCRIPTION'] = $row['DESCRIPTION'];
    $arrCard[$row['ID']]['APPLICANT'] = $row['APPLICANT'];
    $arrCard[$row['ID']]['TYPE'] = $row['TYPE'];
    $arrCard[$row['ID']]['ID'] = $row['ID'];

}

if ( $arrCard ) {

    foreach ($arrCard as $key => $value) {

       $msg = ' 
            <div class="d-flex flex-row">
                <div class="card" style="width: 50% !important;">
                    <div class="card-body" data-id="'.$value['ID'].'">
                        <h3 class="card-title"  >'.$value['TITLE'].'</h3>
                        <p class="card-text">'.$value['DESCRIPTION'].'</p>  
                    <div class="card-body">
                        <label for="exampleInputEmail1" class="form-label card-text">Titulo</label>
                        <input type="text" class="form-control card-text" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="card-body">
                        <label for="exampleFormControlTextarea1" class="form-label card-text">Descripcion</label>
                        <textarea class="form-control card-text" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>  
                    </div>
                </div>
        ';


        $intervals = GetInterval($value['ID']);

        
        
        if( $intervals ){
            foreach ($intervals as $key_intervals => $value_intervals) {

               
                $msg .= '
                    <div class="card pl-2" style="width: 20% !important;">
                        <div class="card-body text-center">
                            <br><br>
                            <h4 class="card-title"> INICIO </h4> 
                            <h5 class="card-title"> '.$value_intervals['TIME_START'].' </h5> 
                            <h4 class="card-title"> TERMINO </h4> 
                            <h5 class="card-title"> '.$value_intervals['TIME_END'].' </h5>
                            <br><br>
                            <h4 class="card-title"> INTERVALO </h4> 
                            <h3 class="card-title"> '.$value_intervals['DIFF'].' Min </h3>
                            <button type="button" onClick="deleteInterval(`'.$value_intervals['ID'].'`)" class="btn btn-outline-success"> - </button> 
                        </div>
                    </div>
                ';
                
            }    
        }
        
        $msg .= '
                <div class="card pl-2" style="width: 30% !important;">
                    <br>
                    <h5 class="px-2 text-center">Hora Inicio</h5>
                    <div class="d-flex justify-content-center">
                        <input type="text" class="form-control card-text w-25" id="hstart-'.$value['ID'].'" aria-describedby="emailHelp" value="00">
                        <h3 class="px-2">:</h3>
                        <input type="text" class="form-control card-text w-25" id="mstart-'.$value['ID'].'" aria-describedby="emailHelp" value="00">
                    </div>
                    <br>
                    <h5 class="px-2 text-center">Hora Termino</h5>
                    <div class="d-flex justify-content-center">
                        <input type="text" class="form-control card-text w-25" id="hend-'.$value['ID'].'" aria-describedby="emailHelp" value="00">
                        <h3 class="px-2">:</h3>
                        <input type="text" class="form-control card-text w-25" id="mend-'.$value['ID'].'" aria-describedby="emailHelp" value="00">
                    </div>
                    <br>
                    <div class="card-body text-center">
                        <button type="button" onClick="addInterval(`'.$value['ID'].'`);" class="btn btn-outline-success"> + </button> 
                    </div>
                </div>
            ';
            

            $msg .= '
            </div>
            ';
        
    }

    echo $msg; 
    
} else {

    echo '<h1>NA</h1>';

}




?>