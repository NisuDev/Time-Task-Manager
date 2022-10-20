<?php

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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
    <!--BOOSTRAP -->
    <!-- CSS only -->
    <script src="https://kit.fontawesome.com/08114b5986.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <script type="text/javascript">
        function calculardiferencia(hora_desde,hora_hasta){
            var hora_inicio = hora_desde;
            var hora_final = $hora_hasta;
            
            // Expresión regular para comprobar formato
            var formatohora = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
            
            // Si algún valor no tiene formato correcto sale
            if (!(hora_inicio.match(formatohora)
                    && hora_final.match(formatohora))){
                return;
            }
            
            // Calcula los minutos de cada hora
            var minutos_inicio = hora_inicio.split(':')
                .reduce((p, c) => parseInt(p) * 60 + parseInt(c));
            var minutos_final = hora_final.split(':')
                .reduce((p, c) => parseInt(p) * 60 + parseInt(c));
            
            // Si la hora final es anterior a la hora inicial sale
            if (minutos_final < minutos_inicio) return;
            
            // Diferencia de minutos
            var diferencia = minutos_final - minutos_inicio;
            
            // Cálculo de horas y minutos de la diferencia
            var horas = Math.floor(diferencia / 60);
            var minutos = diferencia % 60;
            
            $('#horas_justificacion_real').val(horas + ':'
                + (minutos < 10 ? '0' : '') + minutos);  
        }

        function getDate(){

            if ($("#dateInput").val() != '') {

                localStorage.setItem('date', $('#dateInput').val());

                var params = {
                
                    "date" : $("#dateInput").val()
                
                };
                
                $.ajax({
                    data:  params,
                    url:   'src/getTasks.php',
                    type:  'post',
                    success:  function (response) {
                        $('#card-display').html(response);
                    }
                });
                
            }else{
            
                alert('Ingrese una fecha')

            }
        }

        
        
        function deleteInterval(id){
        
            var params = {
        
                "id" : id
        
            };
        
            $.ajax({
                data:  params,
                url:   'src/deleteInterval.php',
                type:  'post',
                success:  function (response) {
                    if ( response == 'OK') {
                        location.reload();
                    } else {
                       alert(response);
                    }
                }
            });
        
        }
        function addInterval(id){

           

            var hstart = $('#hstart-'+id).val()+':'+$('#mstart-'+id).val();
            var hend = $('#hend-'+id).val()+':'+$('#mend-'+id).val();

           /*  alert(hstart+' <- Hora inicio');
            alert(hend+' <- Hora termino'); */
            /* $('#hstart'+id).val()
            $('#hend'+id).val() */
            /* $('#mstart'+id).val();
            $('#mend'+id).val(); */
        
            var params = {
        
                "id" : id,
                "timeStart" : hstart,
                "timeEnd" : hend
        
            };
        
            $.ajax({
                data:  params,
                url:   'src/new_account.php',
                type:  'post',
                success:  function (response) {
                    if ( response == 'OK') {
                        location.reload();
                    } else {
                    alert(response);
                    }
                }
            });
        
        }
        

       

        window.onload = function() {

            var date = localStorage.getItem('date');

            if (date !== null) {

                $('#dateInput').val(date); 

                $("#start").click();
            
            }
        
        }

    </script>

</head>
    <body>
        <div class="pt-5 d-flex justify-content-center">
            <div>
                <input type="date" id="dateInput" />
            </div>
        </div>
        <div class="pt-5 d-flex justify-content-center">
            <div>
                <button type="button" onClick="getDate()" id="start" class="btn btn-outline-success"> START </button> 
            </div>
        </div>
        <div class="pt-5 d-flex justify-content-center w-100">
            <div id="card-display">
        </div>
    </body>
</html>