<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<style>
  div {
    width: 100%;
    position: relative;
    margin: 10px 0;
  }
  img {
    width: 50%;
    border: 2px solid #aaa;
  }
  span {
    position: absolute;
    top: 20px;
    bottom: 20px;
    right: 30px;
    left: 55%;
    overflow: hidden;
  }
  hr {
    margin-top: 20px;
  }
</style>
<body>
<?php
$folder = 'workdir/' . $_GET['file'];
$images = glob("$folder/images/*");

$lines = str_repeat("<hr>", 40);

foreach ($images as $image) : ?>
  <div>
    <img src="<?php echo $image; ?>" alt="" />
    <span><?php echo $lines; ?><span>
  </div>
<?php endforeach; ?>
</body>
</html>
