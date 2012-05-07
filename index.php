<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
  <form action="upload.php" method="POST" enctype="multipart/form-data">
    <fieldset>
      <legend>Upload new PDF</legend>
      <input type="file" name="pdf" id="pdf">
      <input type="submit" value="Upload">
    </fieldset>
    <fieldset>
      <legend>View existing PDF</legend>
      <ul>
        <?php foreach (glob("workdir/*") as $folder) :?>
        <li><a href="view.php?file=<?php echo basename($folder); ?>"><?php echo basename($folder); ?>.pdf</a></li>
        <?php endforeach; ?>
      </ul>
    </fieldset>
  </form>
</body>
</html>