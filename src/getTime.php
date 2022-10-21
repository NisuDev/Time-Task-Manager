<?php

$mysql = new mysqli('127.0.0.1', 'root', '', 'control_tiempo');

$selectInterval = " SELECT 
                        SUM(
                            TIMESTAMPDIFF(
                                minute,
                                `intervals`.`TIME_START`,
                                `intervals`.`TIME_END`
                            )
                        )  as 'DIFF' 
                    FROM 
                        `day` INNER JOIN
                        `task` ON `task`.`DAY_ID` = `day`.`ID` LEFT JOIN
                        `intervals` ON `task`.`ID` = `intervals`.`TASK_ID`
                    WHERE
                        `day`.`DAY` = '".date('Y-m-d', strtotime($_POST['date']))."' ";

$result = $mysql -> query( $selectInterval );

$arrInterval = array();

while( $row = $result -> fetch_assoc () ) {

    $dato = $row['DIFF'];

}

$msg = '';

if( $dato ){

    $resta = 540 - intval($dato);

    $msg .= ' 
            
            <div class="card text-center p-3" >
                <div class="card px-2" style="background-color:rgba(177,255,139,0.31222918855042014); ">
                    <h1>'.intval($dato).'<h1>
                </div>
                <div class="card px-2">
                    <h1 > - <h1>
                </div>
                <div class="card px-2" style="background-color:rgba(177,255,139,0.31222918855042014); ">
                    <h1>540<h1>
                </div>
                <div class="card px-2">
                    <h1> = <h1>
                </div>
                <div class="card px-2" style="background-color:rgba(177,255,139,0.31222918855042014); ">
                    <h1>'.$resta.'<h1>
                </div>
            </div>
        ';

    echo $msg; 
}

?>