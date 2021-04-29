<?php 
    // LOCAL http://localhost/www/dticUTNLR/aulavirtual/_v2/_src/rmDownZoomRec

    define('APPNOM', 'rmDownZoomRec');
    define('APPDET', '

      ## Formulario que retorna comando zoomdl. ## 
      
      El objetivo principal es el de generar, desde una url de zoom de una grabación, un commando de descarga para uno o varioas archivos y descargarlos en un servidor linux con un formato de fecha y nombre personalizado. Luego subir los archivos descargados a un canal de YouTube.

      ');

    define('APPAUT', 'Ricardo MONLA <rmonla@gmail.com>');
    define('APPDEV', 'https://github.com/rmonla/rmDownZoomRec');

    define('APPINSTALL', '
      _src/composer require somesh/php-query
      _src/composer require formr/formr

      ');

    $appVers = [
      '1.21.7' => 'codTit - Pone código de carrera al comienzo del título.',
      '1.21.7' => 'LISTA - Agrega una lista que se incrementa con comandos zoomdl.',
      '1.21.6' => 'rmApp - Agrrega Detalles del código',
      '1.21.0' => 'Inicia codificación'
    ];
    
    $vers = array_keys($appVers);
    
    define('APPVER', $vers[0]);

 ?>
