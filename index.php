<?php  
  
  include_once '_rmApp.php';

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
  //Dependencias
    require_once '_src/vendor/autoload.php';

  // Inicializo variables.
    // $urlOri  = '';
    // $lstCOMs = '';

    $dirDst = '';
    // $dirDst = '/home/rmonla/Descargas/dticClases/';
    $logEST = False;
    $dirLog = '/tmp/';
    $strSEP = ' | ';

    $aCMDs  = [];

  // Instacio la class Formr
    $form = new Formr\Formr('bootstrap');
    $form->open();
    $form->text('urlOri','URL');

    
    // $form->text('urlori','URL ORI');
    // $form->submit_button('Submit Form');

  // check if the form has been submitted
  if( $form->submitted() ) {
    // Inicializo variables.
      $urlOri  = $form->post('urlOri');

    // Obtengo el HTML de la URL y genero el objeto DOM.
      $srtHTML = file_get_contents($urlOri);
      $dom     = phpQuery::newDocumentHTML($srtHTML);

    // Proceso el HTML.
      $dom = $dom['.player-header'];

      $strTit = $dom['#r_meeting_topic']->val();
      // <input type="hidden" id="r_meeting_topic" value="PI21IntCA | Pre-Ingreso2021 Intensivo [Comisión A] | UTNLaRioja" />
      //--> PI21IntCA | Pre-Ingreso2021 Intensivo [Comisión A] | UTNLaRioja
      
      $strData = $dom['#r_meeting_start_time']->val(); 
      // <input type="hidden" id="r_meeting_start_time" value="Feb 18, 2021 8:28 PM Buenos Aires, Georgetown" />
      //--> Feb 18, 2021 8:28 PM Buenos Aires, Georgetown
      
      $strPeso = trim($dom['.ipad-hide']->html()); //--> Download (798 MB)

    // Proceso el título.
      if (!$strTit) exit ('Error: No se pudo obtener los datos de la URL');

      $strTit = utf8_decode($strTit);

    // Proceso la fecha.
      $strD = explode(' ', $strData);

      $strF = '';
      for ($i=0; $i < 5; $i++) $strF .= $strD[$i].' ';     //--> Feb 18, 2021 8:28 PM

      $codF = date_format(date_create($strF), 'd.M.H:i.'); //--> 18.Feb.14:00

    // Proceso el nombre del archivo.
      $fNOM = trim($codF).trim($strTit);
      
    // Proceso el commado a ejecutar.
      $fDST = $dirDst.$fNOM;
      // $fLOG = $dirLog.$fNOM.'.log';

      $fLOG = ($logEST) ? ' > '.$dirLog.$fNOM.'.log': '' ;
      
      $cmdActual = "zoomdl -u $urlOri -f '$fDST'$fLOG";
  
    // Armo la lista de Comandos.

      if ( $cmdHist = $form->post('cmdHist') ) $aCMDs = explode("©", $cmdHist);

      $aCMDs[] = $cmdActual;

      $form->hidden('cmdHist',implode("©", $aCMDs));

  }
  $form->submit_button();
  $form->close();
  
  $lst = implode("\n", $aCMDs)."\n\n"; 
  
  $form->textarea('lst', 'LISTA', $lst);
  

  //echo "<br>".implode("<br>", $aCMDs)."<br><br>®";


?>
      
    </div>

    <script src="_src/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
</html>





