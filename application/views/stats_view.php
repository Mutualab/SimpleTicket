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
    
		<!-- Choix d'un report -->
        <div id="choix_report">
             <h1>Liste des reports</h1>

			<div id="detail">
			<?php foreach($stats as $stat) : ?>
							<p><span class="label_form">[<a href="<?php echo site_url('/stats/delete_query/'.$stat->id); ?>">x</a>] <a href="<?php echo site_url('/stats/execute_query/'.$stat->id); ?>"><?php echo $stat->label; ?></a></span><span class="label_value"><?php echo $stat->description; ?></span></p>
							</br>
			<?php endforeach; ?>
			</div>
			<!-- Liste des reports // END --> 
		</div>
        <!-- Choix d'un report // END -->  
		</br>
		<!-- Ajout d'un report -->
        <div id="ajout_report">
			<h1>Creer un nouveau report</h1>
			<?php echo form_open("stats/new_query",array('class'=>'cssform')); ?>
                
            <p> <label for="name" class="inline">Nom</label><?php echo form_input(array('name'=>'report_name','id'=>'report_name','style' => 'width:50%'));?></p>
            <p> <label for="description" class="inline">Description</label> <?php echo form_input(array('name'=>'description','id'=>'description','style' => 'width:50%'));?></p>
            <p> <label for="query" class="inline">SQL</label> <?php echo form_textarea(array('name'=>'sql','id'=>'sql','style' => 'width:50%'));?></p>
            <p> <label for="column_name" class="inline">Nom des colonnes</label> <?php echo form_input(array('name'=>'column_name','id'=>'column_name','style' => 'width:50%'));?></p>
			<p class="hint">Separer les colonnes par ';'</p>
            <p><?php echo form_submit('submit', 'Valider');?></p>             
            <?php echo form_close();?>     
            
        </div>
         <!-- Ajout d'un report // END -->  
		
	</div>
	<!-- div content // END -->  
</div>
</html>
</body>
