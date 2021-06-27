<?php  
  
  /// include_once '_rmApp.php';

?>


<!doctype html>
<html lang="es-AR">
  <head>
    <!-- Bootstrap core CSS -->
      <link href="_src/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
    <div class="container">

<?php  
  /*
    Procesar un código HTML en sus partes DOM y extraer la lista de clases para publicar.
   */

  /* Cargar el HTML a procesar. */
    //Dependencias
      require_once '_src/vendor/autoload.php';
    // Inicializo variables.
       
       $archOrigen  = 'splitORI.html';
    
    // Obtengo el HTML de la URL y genero el objeto DOM.
      $srtHTML = file_get_contents($archOrigen);
      $dom     = phpQuery::newDocumentHTML($srtHTML);
  
  /* Dividir en secciones. */
    $domSECs = $dom['ytcp-video-row'];

  /* Procesar los datos. */
    $lst = [];
    foreach ($domSECs as $v) {
      $yid = pq($v)->find("#video-title")->attr("href"); //-->/video/PvMACXupL8E/edit 
      $yid = explode("/", $yid)[2];
      $tit = pq($v)->find('#video-title')->html();
      $ctit = strlen($tit);
      $des = pq($v)->find('.description')->html();
      if (strlen($tit)==32) {
        $lst[] = "<tr><td>". implode("</td><td>", [$yid, $tit, $des]) ."</td></tr>";
      }
    }
  
  /* Mostrar la lista */
  echo "<br>Archivo procesado --> $archOrigen";
  echo "<br>Cantidad de videos encontrados --> " . count($lst);
  echo "<br>";
  echo "<br>";
  
  echo "<table class='table'><thead><tr><th scope='col'>ID</th><th scope='col'>Z_DATA</th><th scope='col'>Z_TIT</th></tr></thead><tbody>";
  foreach ($lst as $v) echo $v;
  echo "</tbody></table>";

?>



      
    </div>

    <script src="_src/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
</html>





