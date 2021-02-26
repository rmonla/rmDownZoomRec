<?php  

	define('APPVER', '1.21.2');
	define('APPNOM', 'rmDZoomRec');

	define('APPDET', '
		
		## Generador de comando de descarga zoomdl. ## 
		El objetivo principal es el de generar un comando de descarga que se utiliza en un servidor linux que como parámetro se necesita una URL de una grabación Zoom que no esté protegida con contraseña.

		');

	define('APPAUT', 'Ricardo MONLA <rmonla@gmail.com>');
	define('APPLNKDEV', 'https://github.com/rmonla/rmDZoomRec');
	
	define('APPREQ', '
		_src/composer require somesh/php-query
		_src/composer require formr/formr

		');



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
    $urlOri = '';
    $dirDst = '/home/rmonla/Descargas/dticClases/';
    $logEST = False;
    $dirLog = '/tmp/';
    $strSEP = ' | ';

    $form = new Formr\Formr('bootstrap');

  // check if the form has been submitted
  if( $form->submitted() ){
     // $urlOri = 'https://utn.zoom.us/rec/share/0EXhZfZpcsLf0nEoWrHyU9XdlrYP2N4BnFJJelMr5n9F83OrhsniHrRNUsoh-GKd.mOcTfpb755WvRZT1';

    // Inicializo variables.
      $urlOri = $form->post('urlOri');

    // Obtengo el HTML de la URL y genero el objeto DOM.
      $srtHTML = file_get_contents($urlOri);
      $dom = phpQuery::newDocumentHTML($srtHTML);

    // Proceso el HTML.
      $dom = $dom['.player-header'];

      $strTit = $dom['#r_meeting_topic']->val();
      // <input type="hidden" id="r_meeting_topic" value="PI21IntCA | Pre-Ingreso2021 Intensivo [Comisión A] | UTNLaRioja" />
      //--> PI21IntCA | Pre-Ingreso2021 Intensivo [Comisión A] | UTNLaRioja
      
      $strData = $dom['#r_meeting_start_time']->val(); 
      // <input type="hidden" id="r_meeting_start_time" value="Feb 18, 2021 8:28 PM Buenos Aires, Georgetown" />
      //--> Feb 18, 2021 8:28 PM Buenos Aires, Georgetown
      
      $strPeso = trim($dom['.ipad-hide']->html());
      //--> Download (798 MB)

    // Proceso el título.

      if (!$strTit) exit ('Error: No se pudo obtener los datos de la URL');

      $strTit = utf8_decode($strTit);

    // Proceso la fecha.

      $strD = explode(' ', $strData);

      $strF = '';
      for ($i=0; $i < 5; $i++) $strF .= $strD[$i].' ';
      //--> Feb 18, 2021 8:28 PM

      $codF = date_format(date_create($strF), '-dMy-Hi');
      //--> 18Feb21_20228

    // Proceso el nombre del archivo.
      $arrTit = explode($strSEP, $strTit);
      //--> ['PI21IntCA', 'Pre-Ingreso2021 Intensivo [Comisión A]', 'UTNLaRioja']

      $arrTit[0] = trim($arrTit[0]).trim($codF);
      //--> PI21IntCA_18Feb21_20228
      
      $fNOM = implode(' ║ ', $arrTit);
      
      $fNOM = str_replace(" ", "_", trim($fNOM));

      //$fNOM = utf8_encode($fNOM);

    // Proceso el commado a ejecutar.
      
      $fDST = $dirDst.$fNOM;
      // $fLOG = $dirLog.$fNOM.'.log';

      $fLOG = ($logEST) ? ' > '.$dirLog.$fNOM.'.log': '' ;
      
      $strCOD = "zoomdl -u $urlOri -f '$fDST'$fLOG";

      echo "<p>$strTit<br>$strData<br>$strPeso</p>";
      
      echo "<p>$strCOD</p>";
  }
  $arrForm = [
    'url'   => "urlOri, URL:, $urlOri",
  ];
  $form->fastform($arrForm);
?>
      
    </div>

    <script src="_src/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
</html>





