<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="lib/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="css/theme.css" type="text/css">
  
  <script src="js/jquery-3.2.1.js"></script>
  <script src="lib/cryptojs-aes-php/example/aes.js"></script>
  <script src="lib/cryptojs-aes-php/aes-json-format.js"></script>

  <script src="lib/bootstrap-4.0.0_lite/js/popper.min.js"></script>
  <script src="lib/bootstrap-4.0.0_lite/js/bootstrap.min.js"></script>
</head>

<body>
  <div align="center">
    <br>
    <h2 style='color:blue;'>ACCESO AJAX/MYSQL <br> <b style='color:red;'>JS "ENCRYPT" && PHP "DECRYPT" / AUTO KEY GENERATION</b></h2>
    <u>Cuentas de Prueba:</u>
    <br> 
    Correo: admin@gmail.com / psw:1234
    <br>
    Correo: asistente@gmail.com / psw:123456
  </div>
  
  <div class="py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6">
          <div class="card text-dark p-3 bg-warning">
            <div class="card-body">
              <h3 class="mb-4"><b>Acceso de Usuario</b></h3>
              <!-- Formulario para de acceso -->
              <span>
                <div class="form-group"> <label>Correo</label>
                  <input type="email" id="email" class="form-control" placeholder="Enter email"> </div>
                <div class="form-group"> <label>Contraseña</label>
                  <input type="password" id="password" class="form-control" placeholder="Password" onkeyup="if(event.keyCode == 13) logear();"> </div>
                <button type="button" class="btn btn-secondary" onclick="logear()">Ingresar</button>
                <!-- Message del servidor -->
                <center>
                  <h4 id="message"></h4>
                </center>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function logear(){
      //Generando clave para encriptar/desencriptar
      var d = new Date();
      var mykey = d.getTime().toString();
      timeMilli = parseInt(mykey[9]);
      newKeySync = parseInt(mykey.substring(0,9));
      if(timeMilli>=5)
        newKeySync+=1;
      
      //Encriptamiento de la contraseña
      passwordEncryp = CryptoJS.AES.encrypt( $("#password").val(), newKeySync.toString(), {format: CryptoJSAesJson} );

      console.log( "email: "+$("#email").val() );
      console.log( "password: "+ passwordEncryp.toString() );
      console.log( "(change 10 seg) key Encrypt/Decrypt: "+ newKeySync.toString() );

      //Enviando paquete de datos del formulario
      $.post("validate.php",{
        email: $("#email").val()
        ,password: passwordEncryp.toString() 
      },function(res){ //Recibiendo respuesta del servidor
        console.log(res);
        $("#message").html(res.message);

        if(res.success)//solo si fue correcto se reenviara a la pagina establecida para esta cuenta
          window.location.href=res.link;

      },"json");
    }

  </script>
</body>
</html>