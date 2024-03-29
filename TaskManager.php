
<!DOCTYPE html>
<html lang="es">

<?php

    session_start();

?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task manager</title>
    <link rel="icon" type="image/jpg" href="https://cdn-icons-png.flaticon.com/512/1055/1055645.png"/>
     <!-- JQuery -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>    
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
    <!--BOOSTRAP -->
    <!-- CSS only -->
    <script src="https://kit.fontawesome.com/08114b5986.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <style>
        i{
            cursor:pointer;
        }
    </style>
    <script type="text/javascript">

        function modifyCard( idCard ){

            if(document.getElementById("modificar-card-"+idCard).style.display == "block"){
                
                $("#modificar-card-"+idCard).css("display", "none");
            
                $("#datos-card-"+idCard).css("display", "block");

            }else{

                $("#modificar-card-"+idCard).css("display", "block");
            
                $("#datos-card-"+idCard).css("display", "none");

            }
        
        }

        function newTask( type , newDay ){

            var tipo = type;

            data = $("#dateInput").val()
        
            var params = {
        
                "tipo" : tipo,
                "data" : data,
                "tipoIngreso" : newDay

            };

            
        
            $.ajax({
                data:  params,
                url:   'src/newTask.php',
                type:  'post',
                success:  function (response) {
                    if ( response == 'OK') {
                        getDate();
                    } else {
                       alert(response);
                    }
                }
            }); 
        
        }

        function saveModifyCard(id){

            var title = $('#title-'+id).val();
           
            //const desc = document.getElementById('text-area-'+id).value;
           
            var desc = $.trim($('#text-area-'+id).val());

            var params = {
        
                "id" : id,
                "title" : title,
                "desc" : desc

            };
        
            $.ajax({
                    data:  params,
                url:   'src/saveModifyTask.php',
                type:  'post',
                success:  function (response) {
                    if ( response == 'OK') {
                        getDate();
                    } else {
                       alert(response);
                    }
                }
            }); 
        
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
                        getTime()
                    }
                });
                
            }else{
            
                alert('Ingrese una fecha')

            }
        }

        function getTime(){

            if ($("#dateInput").val() != '') {

                localStorage.setItem('date', $('#dateInput').val());

                var params = {
                
                    "date" : $("#dateInput").val()
                
                };
                
                $.ajax({
                    data:  params,
                    url:   'src/getTime.php',
                    type:  'post',
                    success:  function (response) {

                        $('#time-display').html(response);
                       
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
                        getDate();
                    } else {
                       alert(response);
                    }
                }
            });
        
        }
        
        function joinedTask(id){
        
            var params = {
        
                "id" : id
        
            };
        
            $.ajax({
                data:  params,
                url:   'src/joinTask.php',
                type:  'post',
                success:  function (response) {
                    if ( response == 'OK') {
                        getDate();
                    } else {
                        alert(response);
                    }
                }
            });
        
        }
        
        function deleteTask(id){

            $.confirm({
                title: 'Tas seguro?',
                content: 'Tas seguro??????',
                buttons: {
                    confirm: function () {
                        var params = {
        
                        "id" : id

                        };

                        $.ajax({
                            data:  params,
                            url:   'src/deleteTask.php',
                            type:  'post',
                            success:  function (response) {
                                if ( response == 'OK') {
                                    getDate();
                                } else {
                                alert(response);
                                }
                            }
                        });
                    },
                    cancel: function () {
                        $.alert('tabn');
                    }
                }
            });
        
            
        
        }

        function cerrarSesion(id){
        
            $.ajax({
                url:   'src/cerrarSession.php',
                type:  'post',
                success:  function (response) {
                  
                    window.open('index.php','_self');
                    
                }
            });
            
        
        }
        

        function addInterval(id){

            ////VALIDAR HORAS

            if ( parseInt( $( '#hstart-'+id ).val() ) <= 0 || parseInt( $( '#hend-'+id ).val() ) <= 0 ) {
                alert('Debe ingresar una hora mayor o igual a 0');
                return 0;
            }

            if ( parseInt( $( '#hstart-'+id ).val() ) > 23 || parseInt( $( '#hend-'+id ).val() ) > 23 ) {
                alert('Debe ingresar una hora menor a 23');
                return 0;
            }

            if($( '#hstart-'+id ).val().length >= 3 || $( '#hend-'+id ).val().length >= 3){
                alert('Debe ingresar una hora de dos digitos');
                return 0;
            }

            ////VALIDAR MINUTOS

            if ( parseInt( $( '#mstart-'+id ).val() ) < 0 || parseInt( $( '#mend-'+id ).val() ) < 0 ) {
                alert('Debe ingresar minimo 0 minutos');
                return 0;
            }

            if ( parseInt( $( '#mstart-'+id ).val() ) > 60 || parseInt( $( '#mend-'+id ).val() ) > 60 ) {
                alert('Debe ingresar minutos menores a 60');
                return 0;
            }

            if($( '#mstart-'+id ).val().length >= 3 || $( '#mend-'+id ).val().length >= 3){
                alert('Debe ingresar una minutos de dos digitos');
                return 0;
            }
            
            var hstart = $('#hstart-'+id).val()+':'+$('#mstart-'+id).val();
            var hend = $('#hend-'+id).val()+':'+$('#mend-'+id).val();


        
            var params = {
        
                "id" : id,
                "timeStart" : hstart,
                "timeEnd" : hend
        
            };
        
            $.ajax({
                data:  params,
                url:   'src/newInterval.php',
                type:  'post',
                success:  function (response) {
                    if ( response == 'OK') {
                        getDate();
                    } else {
                    alert(response);
                    }
                }
            });
        
        }

        window.onload = function() {
            $("body").animate({ scrollTop: $(document).height()}, 1000);    
            var date = localStorage.getItem('date');

            if (date !== null) {

                $('#dateInput').val(date); 

                $("#start").click();
            
            }
        
        }

    </script>

    

</head>
    <body>
        <div class="container pt-5 w-75 text-center">
            <button type="button" onClick="cerrarSesion()" title="Logeado como <?php echo $_SESSION['USER_NAME']; ?>"class="btn btn-warning">Cerrar Sesion</button>
        </div>
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
        <div class="pt-5 d-flex justify-content-center">
            <div id="time-display">
        </div>
        <input type="hidden" id="scroll" runat="server" />

        <div class="pt-5 d-flex justify-content-center w-100">
            <div id="card-display">
        </div>
    </body>
</html>