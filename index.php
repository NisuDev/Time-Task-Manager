<?php


function existe_tipo_cuenta($idTipoCuenta){

    $conn = new mysqli('127.0.0.1', 'root', '', 'accountmaganer');

    $sql = "SELECT ID_TIPO_CUENTA FROM cuentas WHERE ID_TIPO_CUENTA = ".$idTipoCuenta."";

    $result = $conn -> query($sql);

    $i=0;

    while($row = $result->fetch_assoc()){
        $array[$i]['ID_TIPO_CUENTA'] = $row['ID_TIPO_CUENTA'];
        $i++;
    }
        
    if ( $i > 0 ) {
    
        return $array; 
    
    } else {

        return null;
    
    }

}


function trae_tipo_cuentas($id = null){
    $conn = new mysqli('127.0.0.1', 'root', '', 'accountmaganer');

    $sql = "SELECT ID,NOMBRE_TIPO_CUENTA FROM tipo_cuenta";

    if($id){
        $sql.= " WHERE ID = ".$id." ";
    }

    $result = $conn -> query($sql);
    $i=0;
    $array=array();
    while($row = $result->fetch_assoc()){
        $array[$i]['ID'] = $row['ID'];
        $array[$i]['NOMBRE_TIPO_CUENTA'] = $row['NOMBRE_TIPO_CUENTA'];
        $i++;
    }
        
    if ( $i > 0 ) {
        return $array; 

    } else {

        return null;

    }


    
}

function trae_cuentas($tipoCuenta = null , $id = null){
    
    $conn = new mysqli('127.0.0.1', 'root', '', 'accountmaganer');

    $sql = "SELECT
        `tipo_cuenta`.`NOMBRE_TIPO_CUENTA`, 
        `cuentas`.`CORREO`,
        `cuentas`.`CONTRASENIA`, 
        `cuentas`.`ID_TIPO_CUENTA`, 
        `cuentas`.`ID`
    FROM
        `cuentas` INNER JOIN
        `tipo_cuenta` ON `tipo_cuenta`.`ID` = `cuentas`.`ID_TIPO_CUENTA`";

    if($tipoCuenta || $id){

        $sql.= " WHERE ";
    
    }

    if ( $tipoCuenta ) {

        $sql.= " `cuentas`.`ID_TIPO_CUENTA` = ".$tipoCuenta." ";

        if ( $id ) {

            $sql.= " AND ";
        
        }
    
    }
    
    if ( $id ) {

        $sql.= " `cuentas`.`ID` = ".$id." ";
    
    }

    $result = $conn -> query( $sql );

  
    $array=array();
    $i = 0 ;
    while($row = $result->fetch_assoc()){
        $array[$i]['ID'] = $row['ID'];
        $array[$i]['ID_TIPO_CUENTA'] = $row['ID_TIPO_CUENTA'];
        $array[$i]['NOMBRE_TIPO_CUENTA'] = $row['NOMBRE_TIPO_CUENTA'];
        $array[$i]['CORREO'] = $row['CORREO'];
        $array[$i]['CONTRASENIA'] = $row['CONTRASENIA'];
        $i++;
    }
        
       
    if ( $i > 0 ) {

        return $array; 

    } else {

        return null;
        
    }
   
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accounts manager</title>
    <link rel="icon" type="image/jpg" href="https://cdn-icons-png.flaticon.com/512/1055/1055645.png"/>
     <!-- JQuery -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
    <!--BOOSTRAP -->
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <script type="text/javascript">

    function traerTipoCuenta(idTipoCuenta){

        var params = {
            "idTipoCuenta" : idTipoCuenta
        };
                                            
        $.ajax({
            data:  params,
            url:   'src/account_type_data.php',
            type:  'post',
            success : function ( response ) {

                if ( response != '' ) {

                    var data = response.split(',');
                    
                    $( '#nombreTipoCuentaModificar' ).val( data[0] );

                    $( '#idTipoNombreModificar' ).val( data[1] );

                } else {

                    alert ( 'error' );
                
                }
            }
        });

	}
    function guardarTipoCuentaModificado(){
        
        var idTipoNombreModificar = document.getElementById('idTipoNombreModificar').value;

        var nombreTipoCuentaModificar = document.getElementById('nombreTipoCuentaModificar').value;
        
        if ( nombreTipoCuentaModificar != '') {

            var params = {
                "nombreTipoCuenta" : nombreTipoCuentaModificar,
                "id" : idTipoNombreModificar
            };
                                            
            $.ajax({
                data:  params,
                url:   'src/update_account_type.php',
                type:  'post',
                success:  function (response) {
                    if(response=='OK'){
                        location.reload();
                    }else{
                        alert(response);
                    }
                }
            });

        } else {

            alert('Debe ingresar el nombre del tipo cuenta');

        }

	}
    function guardarTipoCuenta(){
        
        var nombreTipoCuenta = document.getElementById('nombreTipoCuenta').value;

        if ( nombreTipoCuenta != '') {

            var params = {
                "nombreTipoCuenta" : nombreTipoCuenta
            };
                                            
            $.ajax({
                data:  params,
                url:   'src/new_account_type.php',
                type:  'post',
                success:  function (response) {
                    if(response=='OK'){
                        location.reload();
                    }else{
                        alert('error');
                    }
                }
            });

        } else {

            alert('Debe ingresar el nombre del tipo cuenta');

        }

	}

    function guardarCuenta(){
        
        var correoCuenta = document.getElementById('correoCuenta').value; 
        
        var contraseniaCuenta = document.getElementById('contraseniaCuenta').value; 

        var tipoCuentaNuevaCuenta = $('#tipoCuentaNuevaCuenta').find(":selected").val();

        if ( correoCuenta != '' && contraseniaCuenta != '' && tipoCuentaNuevaCuenta != '' ) {

            if ( /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test ( correoCuenta ) ) {

                var params = {
                    "correoCuenta" : correoCuenta,
                    "contraseniaCuenta" : contraseniaCuenta,
                    "tipoCuentaNuevaCuenta" : tipoCuentaNuevaCuenta
                };
                                                
                $.ajax({
                    data:  params,
                    url:   'src/new_account.php',
                    type:  'post',
                    success:  function (response) {
                        if( response=='OK' ) {

                            location.reload();
                        
                        } else {
                            
                            alert('error');

                        }
                    }
                });
                
            }else{

                alert('Debe ingresar correctamente el correo');
            
            }

        } else {

            alert('Debe ingresar todos los datos de la cuenta');
        
        }

	}
    
    function eliminarCuenta(idCuenta){

        if (confirm('Seguro que desea eliminar esta cuenta?')) {

            var params = {

                "idCuenta" : idCuenta

            };
                                        
            $.ajax({
            data:  params,
            url:   'src/delete_account.php',
            type:  'post',
            success:  function (response) {
                if(response=='OK'){
                    location.reload();
                }else{
                    alert('error');
                }
            }
            });
       
        }  
		
	}
    
  
    
    function eliminarTipoCuenta(idTipoCuenta){

        if ( confirm ( 'Seguro que desea eliminar este tipo cuenta?' ) ) {

            var params = {

                "idTipoCuenta" : idTipoCuenta

            };
                                        
            $.ajax({
            data:  params,
            url:   'src/delete_type_account.php',
            type:  'post',
            success:  function (response) {
                if(response=='OK'){
                    location.reload();
                }else{
                    alert('error');
                }
            }
            });
       
        }  
		
	}
    
    function mostrar(elemento) {
        div = document.getElementById(elemento);
        switch (div.style.display) {
            case "none":
                div.style.display = "";
                break;
            default:
                div.style.display = "none";
                break;
        }
    }
    
    </script>

</head>
    <body>
        <br>
        <div class="d-flex justify-content-center">
            <p class="title is-1 is-spaced">
                Account Manager
            </p>
           
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" class="button is-primary are-medium" data-bs-toggle="modal" data-bs-target="#nuevoTipoDeCuentaModal">
                Nuevo tipo de cuenta
            </button>
            &nbsp;&nbsp;&nbsp;
            <button type="button" class="button is-success are-medium" data-bs-toggle="modal" data-bs-target="#nuevaCuentaModal">
                Nueva cuenta
            </button>
        </div>
        <br>
        <div class="d-flex justify-content-center">
            <button onClick="mostrar('tipoCuenta')" class="button is-success is-light">Mostra/Ocultar Tipo Cuenta</button>
            &nbsp;&nbsp;&nbsp;
            <button onClick="mostrar('cuentas')" class="button is-success is-light">Mostra/Ocultar Cuentas</button>
        </div>
       
        <div class="d-flex justify-content-left">
            <table class="table table-striped col-md table-hover" id="cuentas">
            
            <thead>
            <tr>
                <td colspan="5" align="center"> <h3> Cuentas </h3>  </td>
               
            </tr>
                <tr>
                    <td> ID </td>
                    <td> Nombre tipo cuenta </td>
                    <td> Correo </td>
                    <td> Contrasenia </td>
                    <td> ELIMINAR </td>
                </tr>
            </thead>   
            <tbody>
                <?php

                    $cuentasArr = trae_cuentas();
                    if($cuentasArr){
                        foreach ($cuentasArr as $key => $value) {
                            echo '<tr >';
                                echo '<td>'.$value["ID"].'</td>';
                                echo '<td>'.$value["NOMBRE_TIPO_CUENTA"].'</td>';
                                echo '<td>'.$value["CORREO"].'</td>';
                                echo '<td>'.$value["CONTRASENIA"].'</td>';
                                echo '<td> <button onClick="eliminarCuenta('.$value["ID"].')" class="button is-danger are-small">D</button></td>';
                                echo '<td> <button onClick="asociarCuentaConUsuario('.$value["ID"].')" class="button is-warning are-small">A</button></td>';
                            echo '</tr>';
                        }
                    }else{
                        echo ' <tr>
                        <td colspan="5" align="center" ><h1>NO EXISTEN REGISTROS</h1></td>
                        </tr>'; 
                    }
                    
                ?>
            </tbody>
            </table>
            <table class="table table-striped col-md table-hover" id="tipoCuenta">
                <thead>
                <tr>
                    <td colspan="5" align="center"> 
                        <h3> Tipos cuenta </h3>  
                    </td>
                </tr>
                    <tr>
                        <td> ID </td>
                        <td> Nombre tipo cuenta </td>
                        <td> ELIMINAR </td>
                        <td> MODIFICAR </td>
                    </tr>
                </thead>
                <?php

                    $tipoCuentas = trae_tipo_cuentas();

                    if($tipoCuentas){
                        foreach ($tipoCuentas as $key => $value) {
                            echo '<tr>';
                            echo '<td>'.$value["ID"].'</td>';
                            echo '<td>'.$value["NOMBRE_TIPO_CUENTA"].'</td>';
                            $existeFK = existe_tipo_cuenta($value["ID"]);
                            if( ! $existeFK ) { 
                                echo '<td> <button onClick="eliminarTipoCuenta('.$value["ID"].')" class="button is-danger are-small">D</button></td>';
                                echo '<td> <button onClick="traerTipoCuenta('.$value["ID"].')" value="'.$value["ID"].'" class="button is-succes are-small" data-bs-toggle="modal" data-bs-target="#modificarTipoDeCuentaModal">M</button></td>';
                            }else{
                                echo '<td> <button title="No se puede eliminar este tipo cuenta por que tiene cuentas asociadas"class="button is-danger is-light">?</button></td>';
                                echo '<td> <button title="No se puede modificar este tipo cuenta por que tiene cuentas asociadas"class="button is-danger is-light">?</button></td>';
                            }
                            echo '</tr>';
                        }
                    }else{
                        echo ' <tr>
                        <td colspan="5" align="center" ><h1>NO EXISTEN REGISTROS</h1></td>
                        </tr>'; 
                    }
                ?>
            </table>
        </div>
    </body>



<!-- Modal nuevoTipoDeCuentaModal -->
<div class="modal fade" id="nuevoTipoDeCuentaModal" tabindex="-1" aria-labelledby="nuevoTipoDeCuentaModalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoTipoDeCuentaModallLabel"> Tipo cuenta </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="field">
                    <label class="label">Nombre Tipo de cuenta</label>
                    <div class="control">
                        <input name="nombreTipoCuenta" id="nombreTipoCuenta" class="input" type="text" placeholder="Nombre del tipo cuenta">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onClick="guardarTipoCuenta();"> Guardar </button>
            </div>
        </div>
    </div>
</div>
<!-- FINAL MODAL -->


<!-- Modal nuevaCuenta -->
<div class="modal fade" id="nuevaCuentaModal" tabindex="-1" aria-labelledby="nuevaCuentaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="nuevaCuentaModallLabel"> Nueva Cuenta </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="field">
                    <label class="label">Correo</label>
                    <div class="control">
                        <input class="input is-warning" name="correoCuenta" id="correoCuenta" type="email" placeholder="Correo cuenta" >
                    </div>
                </div>

                <div class="field">
                    <label class="label">Contraseña</label>
                    <div class="control">
                        <input name="contraseniaCuenta" id="contraseniaCuenta" class="input is-primary" type="text" placeholder="Contraseña">
                    </div>
                </div>
                <div>
                <label class="label">Tipo cuenta</label>
                    <div class="select is-rounded">
                        
                            <select id="tipoCuentaNuevaCuenta">
                                <option value="">Seleccione el tipo de cuenta&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                </div>
                                <?php
                                
                                    $tipoCuentas = trae_tipo_cuentas();

                                    foreach ($tipoCuentas as $key => $value) {

                                        echo   '<option value="'.$value['ID'].'">'.$value['NOMBRE_TIPO_CUENTA'].'</option>';

                                    }

                                ?>
                            </select>        
                    </div>                     
                </div>
            </div>   
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancelar </button>
                <button type="button" class="btn btn-primary" onClick="guardarCuenta();"> Guardar </button>
            </div>
        </div>
    </div>
</div>
<!-- FINAL MODAL -->

<!-- Modal modificar tipo cuenta -->

<div class="modal fade" id="modificarTipoDeCuentaModal" tabindex="-1" aria-labelledby="modificarTipoDeCuentaModalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modificarTipoDeCuentaModallLabel"> Modificar Tipo cuenta </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="field">
                    <label class="label">Nombre Tipo de cuenta</label>
                    <label class="label" id="idTipoCuentaModificarLabel" value=""></label>
                    <div class="control">
                        <input name="nombreTipoCuentaModificar" id="nombreTipoCuentaModificar" value="" class="input" type="text" placeholder="Nombre del tipo cuenta">
                        <input name="idTipoNombreModificar" id="idTipoNombreModificar" value="" class="input" type="hidden">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onClick="guardarTipoCuentaModificado();"> Guardar </button>
            </div>
        </div>
    </div>
</div>
<!-- FINAL MODAL -->

<!-- Modal asociar usuario con cuenta y crear usuario -->

<div class="modal fade" id="asociarUsuario" tabindex="-1" aria-labelledby="asociarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asociarUsuariolLabel"> Modificar Tipo cuenta </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="field">
                    <label class="label">Nombre Tipo de cuenta</label>
                    <label class="label" id="idTipoCuentaModificarLabel" value=""></label>
                    <div class="control">
                        <input name="nombreTipoCuentaModificar" id="nombreTipoCuentaModificar" value="" class="input" type="text" placeholder="Nombre del tipo cuenta">
                        <input name="idTipoNombreModificar" id="idTipoNombreModificar" value="" class="input" type="hidden">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onClick="guardarTipoCuentaModificado();"> Guardar </button>
            </div>
        </div>
    </div>
</div>
<!-- FINAL MODAL -->



</html>