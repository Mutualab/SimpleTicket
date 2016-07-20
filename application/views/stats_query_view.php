<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Gestion des tickets" />
    <meta name="keywords" content="coworkinglille, coworking, lille" />
    <title>CoworkingLille Ticket</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/reset.css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/960.css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" media="screen" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
</head>
<body>
<div id="wrapper" class="container_16">

	<!-- PAGE HEADER -->
	<div id="header" class="grid_16">
    	<img src="<?php echo base_url(); ?>css/img/header.png" alt="Coworking Lille - Communauté et espace de travail pour indépendants et télétravailleurs" width="348" height="149" />
    </div>
    <!-- END HEADER -->
    
    <div class="clear"></div>
    <div class="separateur"></div>
    <div class="clear"></div>
	
	<div id="content" class="grid_16">
		<h1><?php echo $name?></h1>
		<div>
			<table class="bordered">
			<tr class="bordered">
			<?php foreach($columns as $col): ?>
					<th class="bordered">
					<b><?php echo $col; ?></b>
					</th>	
			<?php endforeach; ?>
			</tr>
			<?php foreach($sqlquery as $sq) : ?>
				<tr class="bordered">
				<?php foreach($sq as $key=>$val): ?>
					<td class="bordered">
					<?php echo $val; ?>
					</td>
				<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
</html>
</body>