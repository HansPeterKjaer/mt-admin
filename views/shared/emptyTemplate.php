<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="error page">
    <meta name="author" content="mytrainer">
    <link rel="icon" href="../../favicon.ico">
    <link href="<?php URLHelper::renderUrl('/assets/css/base.css')?>" rel="stylesheet">

	<title>MT ADMIN</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>

    <div class="container-fluid">
      <div class="row">
  		  <div class="col">
            <?php require($viewFile) ?>
        </div>
      </div>
    </div>
    <!-- Include all compiled plugins (below), or include individual files as needed
    <script src="/mt/js/bootstrap.min.js"></script>-->
</body>
</html>	
 