<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Portafolio</title>
    <link rel="stylesheet" href="css/vendor/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <script src="//gitcdn.link/repo/DoclerLabs/Protip/master/protip.min.js"></script>
    <link rel="stylesheet" href="//gitcdn.link/repo/DoclerLabs/Protip/master/protip.min.css">

    <!-- aqui pondremos el contenido html -->
</head>
<body>
    <section class="lateral">
        <div class="perfil">
            <figure class="perfil__circulo">
                <img src="img/perfil.png" alt="" class="perfil__foto">
            </figure>
            <h1 class="perfil__nombres">SISDECI</h1><br>
            <a class="botonera" href="verdeseco.html">Ver Desarrollo Economico</a><br>
            <a class="botonera" href="verdefcivil.html">Ver Defensa Civil</a><br>
            <a class="botonera" href="reporteador_defensa_civil_web.php">Reporte Web Defensa Civil</a><br>
            <a class="botonera" href="reporteador_defensa_civil_completo.php">Reporte Defensa Civil Completo</a><br>
            <a class="botonera" href="reporteador_licemp_para_web.php">Reporte Web Desarrollo Econ&oacute;mico</a><br>
            <a class="botonera" href="reporteador_licemp_completo.php">Reporte Desarrollo Econ&oacute;mico Completo</a><br>
        </div>
    </section>
    <div class="registro">
    <section class="proyectos">
          <header class="proyecto__titulo">
           <h2>Bienvenido al Reporteador de Licencias de Funcionamientos</h2>
          </header>
            <h2>Listado de Licencias de Funcionamientos Emitidos para su Control Interno</h2>
        
            <form action="reporte_licemp_web_completo.php" >
                <div style="width: 250px; ">
                    Fecha de inicio:
                    <input type="date" name="iday">
                </div>
                <div style="width: 250px; ">
                    Fecha de fin   :<input type="date" name="fday">    
                </div></br>
                    <input type="submit">
            </form>
    </section>
    </div>
</body>
</html>