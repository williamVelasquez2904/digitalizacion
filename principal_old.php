
<h2>Digitalización de Documentos</h2>
<?php  
include ('include/rutinas.php');


// Array en el que obtendremos los resultados
  echo "<h2> Procesando... </h2>";
  $res = array();
   // carpeta  donde se copiaran las imagenes redimensionadas
  $xmax = 800;
  $ymax = 600;

  $directorio_imagenes=$_GET['folder']."/";
//  var_dump($directorio_imagenes);

  //$directorio_imagenes="katty/"; 


  // Agregamos la barra invertida al final en caso de que no exista
  if(substr($directorio_imagenes, -1) != "/") $directorio_imagenes .= "/";

  // Creamos un puntero al directorio y obtenemos el listado de archivos
  $dir = @dir($directorio_imagenes) or die("getFileList: Error abriendo el directorio_imagenes $directorio_imagenes para leerlo");
  $i=0;  // Contador de archivos

  $ftp_server="127.0.0.1";    
  $ftp_user="william";
  $ftp_pass="1234";

  $conn_id = ftp_connect($ftp_server) or die("No se pudo conectar a $ftp_server"); 


// iniciar sesión con nombre de usuario y contraseña
$login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);



  // intentar iniciar sesión
  if ($login_result) {
      echo "Conectado como $ftp_user@$ftp_server\n";
  } else {
      echo "No se pudo conectar como $ftp_user\n";
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
// cargar un archivo
if (ftp_put($conn_id, $remote_file, $file)) {
  echo "se ha cargado $file con éxito\n";
 } else {
  echo "Hubo un problema durante la transferencia de $file\n";
 }


        /*
        $imgh = icreate($imagefile);
        $imgr = simpleresize($imgh, 520, 200);

        header('Content-type: image/jpeg');
        imagejpeg($imgr);*/
        //$imagen_optimizada = redimensionar_imagen('imagen.jpg','images/imagen.jpg',700,700);


        /*
        $imagen_optimizada = redimensionar_imagen($archivo, $rutaimg, $xmax, $ymax);
        $nuevo_nombre ="nuevos/".$archivo;
        imagejpeg($imagen_optimizada, $nuevo_nombre);
          $res[] = array(
            "Nombre" => $directorio_imagenes . $archivo,
            "Tamaño" => filesize($directorio_imagenes . $archivo),
            "Modificado" => filemtime($directorio_imagenes . $archivo)
          );
          */

// establecer una conexión o finalizarla



        //var_dump($conn_id);exit;
        
                //var_dump($login_result);

        /*    

        if(ftp_put($login_result,$archivo,$archivo)){
          echo "Archivo copiado: ".$archivo."<br>";

        }else{
          echo "Archivo NO copiado: ".$archivo."<br>";
        }
        */

      }
  }

  ftp_close($conn_id);
  $dir->close();


?>