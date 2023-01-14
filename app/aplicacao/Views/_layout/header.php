<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo TITULO ?> || Home</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css" type="text/css">
    <?php
      foreach($GLOBALS['css'] as $arquivo) {
        echo '<link rel="stylesheet" href="public/css/'.$arquivo.'">';
        } 
    ?>
</head>
<body>
    
