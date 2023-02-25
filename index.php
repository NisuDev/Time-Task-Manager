
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


        function login() {

            var user = $("#user").val()

            var password = $("#password").val()

            if(!user || !password){

                alert('Debe ingresar usuario y contraseña');

                $("#user").val('');
                $("#password").val('');

                return 0;

            }

            var params = {
        
                "user" : user,
                "password" : password

            };


            $.ajax({
                data:  params,
                url:   'src/login.php',
                type:  'post',
                success:  function (response) {

                    switch (response) {
                        case 'pass-incorrecta':
                            alert('La contraseña es incorrecta');
                            $("#user").val('');
                            $("#password").val('');
                            break;
                        case 'user-incorrecto':
                            alert('El usuario no existe');
                            $("#user").val('');
                            $("#password").val('');
                            break;
                        case 'OK':
                            window.open('TaskManager.php','_self');
                            break;
                        default:
                            console.log(response);
                            alert('ERROR AL INICIAR SESION');
                            break;
                    }

                }
            }); 
           
        }
        
    </script>

</head>
    <body>
        <div class="container w-50 h-10 pt-5">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre de usuario</label>
                        <input type="text"
                        class="form-control" name="user" id="user" placeholder="Nombre de usuario">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="">
                    </div>
                    <div class="text-center">
                        <button type="button" onClick="login()" class="btn btn-primary btn-lg">Login </button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>