<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <link href="<?php URLHelper::renderUrl('assets/css/base.css')?>" rel="stylesheet">
    

	<title>MT ADMIN</title>
  <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script-->
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          <a class="navbar-brand" href="<?php URLHelper::renderURL('adminHome'); ?>"><img src="<?php URLHelper::renderURL('assets/images/mtlogo_b_inv.png') ?>" alt="MyTrainer Logo" /></a>
        </div>
        <div id="top-navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="<?php echo site_url() ?>" class=" pull-right">Blog</a></li>
              <li><a href="<?php URLHelper::renderUrl('app/generateworkout'); ?>" class="pull-right">Generator</a></li>
              <li><a href="/blog/wp-admin" class="pull-right">Blog Admin</a></li>
              <li><a href="<?php echo wp_logout_url(); ?>" class="pull-right">Log Out</a></li>
            </ul>
        </div>
      </div>
    </nav>
    <div id="side-navbar" class="sidebar">
      <?php if($viewModel->menuItems) : ?>
        <?php ViewHelper::renderPartial("shared/menu", $viewModel);?>
      <?php endif; ?>
    </div>
    
    <div class="main-content container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <?php require($viewFile) ?>
        </div>
      </div>
    </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php URLHelper::renderURL('assets/scripts/bundle.js'); ?>"></script>
    <?php Logger::consoleLog(); ?>
</body>
</html>	
 