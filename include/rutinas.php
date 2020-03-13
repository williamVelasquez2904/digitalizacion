<?php

function redimensionar_imagen($nombreimg, $rutaimg, $xmax, $ymax){  
        $ext = explode(".", $nombreimg);  
        $ext = $ext[count($ext)-1];  
      
        if($ext == "jpg" || $ext == "jpeg")  
            $imagen = imagecreatefromjpeg($rutaimg);  
        elseif($ext == "png")  
            $imagen = imagecreatefrompng($rutaimg);  
        elseif($ext == "gif")  
            $imagen = imagecreatefromgif($rutaimg);  
          
        $x = imagesx($imagen);  
        $y = imagesy($imagen);  
          
        if($x <= $xmax && $y <= $ymax){
            echo "<center>Esta imagen ya esta optimizada para los maximos que deseas.<center>";
            return $imagen;  
        }
      
        if($x >= $y) {  
            $nuevax = $xmax;  
            $nuevay = $nuevax * $y / $x;  
        }  
        else {  
            $nuevay = $ymax;  
            $nuevax = $x / $y * $nuevay;  
        }  
          
        $img2 = imagecreatetruecolor($nuevax, $nuevay);  
        imagecopyresized($img2, $imagen, 0, 0, 0, 0, floor($nuevax), floor($nuevay), $x, $y);  
        echo "<center>La imagen se ha optimizado correctamente.</center>";
        return $img2;   
    }
    
 






//$imagefile = 'baterias.jpg';


function icreate($filename)
{
  $isize = getimagesize($filename);
  if ($isize['mime']=='image/jpeg')
    return imagecreatefromjpeg($filename);
  elseif ($isize['mime']=='image/png')
    return imagecreatefrompng($filename);
  /* Add as many formats as you can */
}

/**
 * Resize maintaining aspect ratio
 *
 * @param $image
 * @param $width
 */
function resizeAspectW($image, $width)
{
  $aspect = imagesx($image) / imagesy($image);
  $height = $width / $aspect;
  $new = imageCreateTrueColor($width, $height);

  imagecopyresampled($new, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
  return $new;
}

/**
 * Resize maintaining aspect ratio
 *
 * @param $image
 * @param $height
 */
function resizeAspectH($image, $height)
{
  $aspect = imagesx($image) / imagesy($image);
  $width = $height * $aspect;
  $new = imageCreateTrueColor($width, $height);

  imagecopyresampled($new, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
  return $new;
}

/*
$imgh = icreate($imagefile);
$imgr = resizeAspectH($imgh, 520);

header('Content-type: image/jpeg');
imagejpeg($imgr);

*/



