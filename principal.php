<h2>Digitalización de Documentos</h2>
<?php  
include ('include/rutinas.php');
// Array en el que obtendremos los resultados
  echo "<h2> Procesando... </h2>";
  $res = array();
  $xmax = 800;
  $ymax = 600;

// carpeta  donde se copiaran las imagenes redimensionadas
  $directorio_imagenes=$_GET['folder']."/";
  // Agregamos la barra invertida al final en caso de que no exista
  if(substr($directorio_imagenes, -1) != "/") $directorio_imagenes .= "/";

  // Creamos un puntero al directorio y obtenemos el listado de archivos
  $dir = @dir($directorio_imagenes)
   or die("getFileList: Error abriendo el directorio_imagenes $directorio_imagenes para leerlo");
  $i=0;  // Contador de archivos

  $ftp_server = "127.0.0.1";    
  $ftp_user   = "william";
  $ftp_pass   = "1234";

  $conn_id = ftp_connect($ftp_server) or die("No se pudo conectar a $ftp_server"); 

  // iniciar sesión con nombre de usuario y contraseña
  $login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);

  // intentar iniciar sesión
  if ($login_result) {
      echo "Conectado como $ftp_user@$ftp_server\n";
  } else {
      echo "No se pudo conectar como $ftp_user\n";
      exit;
  }

  while(($archivo = $dir->read()) !== false) {
      // Obviamos los archivos ocultos
      if($archivo[0] == ".") continue;
      if(is_dir($directorio_imagenes . $archivo)) {
          $res[] = array(
            "Nombre" => $directorio_imagenes . $archivo . "/",
            "Tamaño" => 0,
            "Modificado" => filemtime($directorio_imagenes . $archivo)
          );
      } else if (is_readable($directorio_imagenes . $archivo)) {
      	  $i++;

        $imagefile=$archivo;
        $remote_file= $archivo;
        $file       = $directorio_imagenes . $archivo;
        $rutaimg=$directorio_imagenes.$imagefile; 
        echo "<br>Ruta Img  =>    ".$rutaimg.'<br>'; 
        echo "Archivo $i  =>    ".$archivo.'<br>'; 
        subir_archivo($conn_id,$remote_file, $file);

      }
  }
  ftp_close($conn_id);
  $dir->close();
  echo "<h3>Total archivos copiados: $i</h3>";

?>