<?php  
include ('include/rutinas.php');

//prueba.php

$imagefile = '3311495.jpeg';

$imgh = icreate($imagefile);
$imgr = resizeAspectH($imgh, 100);

header('Content-type: image/jpeg');
imagejpeg($imgr);

?>