
<!DOCTYPE html>
<html lang="es">
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
    
    <script>
        
        function fnTexto(){

            var texto = $("#inputTextoEjemplo").val();

            var color = $("#color").val();
        
            var params = {
        
                "textoRecibido" : texto,
                "colorTexto" : color
        
            };
        
            $.ajax({
                data:  params,
                url:   'src/archivo.php',
                type:  'post',
                success:  function (response) {

                    $("#responseJquery").html(response);
                    
                }
            });
        
        }
        
        
    </script>

</head>

<div id="responseJquery"></div>

<input id="inputTextoEjemplo" type="text">

<input type="color" id="color" value="#ff0000">

<button onclick="fnTexto()">ejecutar</button>


</html>