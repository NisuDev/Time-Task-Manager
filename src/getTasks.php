<?php

session_start();

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

function GetMaxInterval(){

    $mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

    $selectInterval = " SELECT
                            MAX(`intervals`.`ID`) as `MAX_INTERVAL`
                        FROM
                            `task` INNER JOIN
                            `user` ON `user`.`ID` = `task`.`USER_ID` INNER JOIN
                            `intervals` ON `intervals`.`TASK_ID` = `task`.`ID` 
                        WHERE 
                             `task`.`USER_ID` = ".$_SESSION['ID_USER']." ; ";

    $result = $mysql -> query( $selectInterval );

    $arrInterval = array();

    while( $row = $result -> fetch_assoc () ) {

        $dato = $row['MAX_INTERVAL'];

    }

    if( ! $dato ){

        return NULL;
    
    }

    return $dato;
}

function GetIntervalSum($idTask){

    $mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');
    
    $selectInterval = " SELECT 
                            `intervals`.`ID`, 
                            `intervals`.`TIME_START`, 
                            `intervals`.`TIME_END`,
                            SUM(
                                TIMESTAMPDIFF(
                                    minute,
                                    `intervals`.`TIME_START`,
                                    `intervals`.`TIME_END`
                                )
                            )  as 'DIFF' 
                FROM 
                    `intervals`
                WHERE
                    `intervals`.`TASK_ID` = ".$idTask." ";

    $result = $mysql -> query( $selectInterval );

    $arrInterval = array();

    while( $row = $result -> fetch_assoc () ) {

        $dato = $row['DIFF'];

    }

    if( ! $dato ){

        return NULL;
    
    }

    return $dato;
    
}
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

    if ( ! $arrInterval ) {

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
                    `task`.`ID`,
                    `task`.`JOINED`
                FROM
                    `day` INNER JOIN
                    `task` ON `task`.`DAY_ID` = `day`.`ID` LEFT JOIN
                    `intervals` ON `task`.`ID` = `intervals`.`TASK_ID`
                WHERE
                    `day`.`DAY` = '".$_POST['date']."' AND USER_ID = ".$_SESSION['ID_USER']."";

$result = $mysql -> query( $selectCard );

$arrCard = array();

while( $row = $result -> fetch_assoc () ) {

    $arrCard[$row['ID']]['JOINED'] = $row['JOINED'];
    $arrCard[$row['ID']]['ID'] = $row['ID'];
    $arrCard[$row['ID']]['TITLE'] = $row['TITLE'];
    $arrCard[$row['ID']]['DESCRIPTION'] = $row['DESCRIPTION'];
    $arrCard[$row['ID']]['APPLICANT'] = $row['APPLICANT'];
    $arrCard[$row['ID']]['TYPE'] = $row['TYPE'];
   

}

$msg = '';

if ( $arrCard ) {

    foreach ($arrCard as $key => $value) {

       $msg .= ' 
            <div class="d-flex flex-row">

                <div class="card my-2" style="';

                if($value['TYPE'] == 'SOPORTE'){

                    if($value['JOINED'] == '1'){
                        $msg .= 'background: linear-gradient(0deg, rgba(236,97,255,1) 10%, rgba(241,139,255,0.47) 11%, rgba(241,139,255,1) 100%);';
                    }else{
                        $msg .= ' background-color:rgba(241,139,255,0.31222918855042014); ';
                    }
                }else{
                    $msg .= ' background-color:rgba(177,255,139,0.31222918855042014); ';
                    if($value['JOINED'] == '1'){
                        $msg .= 'background: linear-gradient(0deg, rgba(70,255,0,1) 10%, rgba(151,255,101,0.47) 11%, rgba(177,255,139,1) 100%); ';
                    }else{
                        $msg .= ' background-color:rgba(177,255,139,0.31222918855042014);  ';
                    }
                }

                if($value['JOINED'] == '1'){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                
                $msg .= '  width: 50% !important;">

                    <div class="p-2" onClick="modifyCard(`'.$value['ID'].'`)">
                        <i class="fa-solid fa-pencil"></i>
                    </div>
                    
                    <div class="card-body" data-id="'.$value['ID'].'">
                        <div id="datos-card-'.$value['ID'].'">
                            <p class="card-text">'.GetIntervalSum($value['ID']).' Minutos</p> 
                            <h3 class="card-title"  >'.$value['TITLE'].'</h3>
                            <p class="card-text">'.$value['DESCRIPTION'].'</p> 
                        </div>
                        <div id="modificar-card-'.$value['ID'].'" style="display:none;">
                        
                        <div class="p-2" >
                            <i onClick="deleteTask(`'.$value['ID'].'`)" class="fa-solid fa-trash-can"></i>
                        </div>
                        <div class="p-2" >
                            <i onClick="saveModifyCard(`'.$value['ID'].'`)" onClick class="fa-regular fa-floppy-disk"></i>
                        </div>
                        <div class="card-body" data-id="'.$value['ID'].'">
                            <label for="title-'.$value['ID'].'" class="form-label card-text">Titulo</label>
                            <div class="card-body" id="title-card">
                                <input type="text" class="form-control" value="'.$value['TITLE'].'" id="title-'.$value['ID'].'" aria-describedby="emailHelp">
                            </div>
                            <label class="form-label card-text">Descripcion</label>
                            <div class="card-body">
                                <textarea cols="33" name="text-area-'.$value['ID'].'" class="form-control card-text" id="text-area-'.$value['ID'].'" rows="3">'.$value['DESCRIPTION'].'</textarea>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="ml-5 mb-5 form-check">
                        <input class="form-check-input" onClick="joinedTask(`'.$value['ID'].'`)" type="checkbox"    id="flexCheckChecked" '.$checked.'>
                        <label class="form-check-label" for="flexCheckChecked">
                            Ingresado
                        </label>
                    </div>
                </div>
        ';


        $intervals = GetInterval($value['ID']);
        
        if( $intervals ){
            foreach ($intervals as $key_intervals => $value_intervals) {

                if(GetMaxInterval() == $value_intervals['ID']){
                    $bg_interval = 'background-color:rgba(177,255,139,0.31222918855042014);';  
                }else{
                    $bg_interval = "";
                }

                $msg .= '
                    <div class="card m-5" style="width: 20% !important; '.$bg_interval.'">
                        <div class="card-body text-center">
                            <br><br>
                            <h4 class="card-title"> INICIO </h4> 
                            <h5 class="card-title"> '.substr($value_intervals['TIME_START'], 0, 5).' </h5> 
                            <h4 class="card-title"> TERMINO </h4> 
                            <h5 class="card-title"> '.substr($value_intervals['TIME_END'], 0, 5).' </h5>
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
                <div class="card m-5" style="width: 30% !important;">
                    <br>
                    <h5 class="px-2 text-center">Hora Inicio</h5>
                    <div class="d-flex justify-content-center">
                        <input type="text" minlength="2" maxlength="2" class="form-control card-text w-25" id="hstart-'.$value['ID'].'" aria-describedby="emailHelp" value="00">
                        <h3 class="px-2">:</h3>
                        <input type="text" minlength="2" maxlength="2" class="form-control card-text w-25" id="mstart-'.$value['ID'].'" aria-describedby="emailHelp" value="00">
                    </div>
                    <br>
                    <h5 class="px-2 text-center">Hora Termino</h5>
                    <div class="d-flex justify-content-center">
                        <input type="text" minlength="2" maxlength="2" class="form-control card-text w-25" id="hend-'.$value['ID'].'" aria-describedby="emailHelp" value="00">
                        <h3 class="px-2">:</h3>
                        <input type="text" minlength="2" maxlength="2" class="form-control card-text w-25" id="mend-'.$value['ID'].'" aria-describedby="emailHelp" value="00">
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

    $msg .= ' 
            <div class="card d-flex mt-2 justify-content-center text-center" style="width: 50% !important;">
                <div  class="card-body" >
                    <h1 onClick="newTask(`TAREA`,'.$value['ID'].')" style="color:green;cursor:pointer;">+</h1> 
                    <h1 onClick="newTask(`SOPORTE`,'.$value['ID'].')" style="color:pink;cursor:pointer;">+</h1> 
                </div>  
            </div>
        ';

    

    
    
} else {

    $msg .= ' 
        <div class="card d-flex mt-2 justify-content-center text-center" style="width: 100% !important;"> 
            <div class="card-body"> 
                <h1 onClick="newTask(`TAREA`,`new`)" style="color:green;cursor:pointer;">+</h1> 
                <h1 onClick="newTask(`SOPORTE`,`new`)" style="color:pink;cursor:pointer;">+</h1> 
            </div>  
        </div> 
    ';

}

echo $msg; 


?>