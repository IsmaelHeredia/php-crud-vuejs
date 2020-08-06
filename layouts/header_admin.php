<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administración</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/toastr.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" rel="stylesheet">
  <script src="js/jquery-3.5.1.min.js" charset="UTF-8"></script>
  <script src="js/bootstrap.min.js" charset="UTF-8"></script>
  <script src="js/vue.js" charset="UTF-8"></script>
  <script src="js/axios.min.js" charset="UTF-8"></script>
  <script src="js/toastr.min.js" charset="UTF-8"></script>
  <script src="js/highcharts.js" charset="UTF-8"></script>
  <script src="js/exporting.js" charset="UTF-8"></script>
  <script src="js/app/config.js" charset="UTF-8"></script>
  <style>
   .modal-mask {
     position: fixed;
     z-index: 9998;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     background-color: rgba(0, 0, 0, .5);
     display: table;
     transition: opacity .3s ease;
   }

   .modal-wrapper {
     display: table-cell;
     vertical-align: middle;
   }
  </style>
 </head>
 <body>
  <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">Administración</a>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
              <li class="nav-item active"><a class="nav-link" href="administracion.php" name="inicio"><i class="fa fa-home espacio-icono" aria-hidden="true"></i></span>Inicio<span class="sr-only">(current)</span></a></li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="gestionar"><i class="fa fa-tasks espacio-icono" aria-hidden="true"></i>Gestionar <span class="caret"></span></a>
                  <div class="dropdown-menu" aria-labelledby="gestionar">
                      <a class="dropdown-item" href="productos.php">Productos</a>
                      <a class="dropdown-item" href="proveedores.php">Proveedores</a>
                      <a class="dropdown-item" href="usuarios.php">Usuarios</a>
                  </div>
              </li>                 
              <li class="nav-item"><a class="nav-link" href="estadisticas.php" name="estadisticas"><i class="fa fa-bar-chart espacio-icono" aria-hidden="true"></i></span>Estadísticas</span></a></li>                
          </ul>
          <ul class="nav navbar-nav navbar-right">
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="cuenta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle espacio-icono" aria-hidden="true"></i><span id="nombreUsuario"></span> <span class="caret"></span></a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="cuenta">
                      <a class="dropdown-item" href="cambiar_usuario.php" name="cambiar_usuario">Cambiar Usuario</a>
                      <a class="dropdown-item" href="cambiar_clave.php" name="cambiar_clave">Cambiar Clave</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" id="cerrarSesion">Salir</a>
                  </div>
              </li>
          </ul>
      </div>
  </nav>