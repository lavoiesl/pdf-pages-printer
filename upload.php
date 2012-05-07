<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
  <pre style="width: 400px; overflow-x: hidden">
<?php
set_time_limit(240);
ini_set('memory_limit', '128M');

function rrmdir($path) {
  return is_file($path)
    ? unlink($path)
    : array_map('rrmdir',glob($path.'/*')) == rmdir($path);
}


function text_log($msg) {
  static $pad = false;
  if ($pad === false) $pad = str_repeat(' ', 4096);
  echo "$msg$pad\n"; 
  flush();
}
foreach ($_FILES as $file) {
  $basename = basename($file['name'], '.pdf');
  text_log("Saving {$file['name']}...");
  
  $dir = __DIR__ . '/workdir/' . $basename;
  if (is_dir($dir)) {
    rrmdir($dir);
  }
  $pdf = "$dir/input.pdf";
  $images_dir = "$dir/images";
  mkdir($dir);
  mkdir($images_dir);
  move_uploaded_file($file['tmp_name'], $pdf);
  
  $image = new Imagick;
  $resolution = 200;
  if (isset($_GET['resolution']))
    $resolution = $_GET['resolution'];
    
  $image->setResolution($resolution, $resolution);
  $start = microtime(true);
  $format = 'png';
  text_log("Converting PDF as $format using resolution {$resolution}x{$resolution}...");
  
  for ($i=0; $i < 30; $i++) {
    try {
      $image->readImage("{$pdf}[{$i}]");
    } catch (Exception $e) {
      break;
    }
    $image->setImageFormat($format);
    $id = str_pad($i, "3", "0", STR_PAD_LEFT);
    text_log("Saving page $id as $format...");
    $image->writeImage("$images_dir/output-$id.$format");
    $image->clear();
  }
  text_log("Conversion done in " . round(microtime(true) - $start, 1) . "s.");
  $image->destroy();
}
?>
  </pre>
  <p><a href="view.php?file=<?php echo $basename; ?>">View it!</a></p>
</body>
</html>