<!doctype html>
<html lang="sv"> 
<head>
  <meta charset="utf-8">
  <title><?=$title?></title>
  <!-- <?=$stylesheet?> är kortmetod för <?php echo $stylesheet; ?> -->
  <link rel="stylesheet" href="<?=$stylesheet?>">
</head>
<body>
  <div id="header">
    <?=$header?>
  </div>
  <div id="main" role="main">
    <?=$main?>   
  </div>
  <div id="footer">
    <?=$footer?>
    <?=get_debug()?>
  </div>
</body>
</html>