<?php

$user_options = array(0  => 'Choisir un membre');
		
if (count($users) >0){
	foreach($users as $row){
		$user_options[$row->id]=$row->last_name." ".$row->first_name.' ('.$row->id.')';
	}
}

$user_js = 'onChange="user_select(this.value);"';	

if (!isset($selected_user)) {
	$selected_user=0;
}else{
	$pack_options=array();
	if (count($packs) >0){
		foreach($packs as $row){
			$pack_options[$row->id]=$row->libelle;
		}
	}
	
	$periode_options=array();
	if (count($periodes) >0){
		foreach($periodes as $row){
			$periode_options[$row->id]=$row->libelle;
		}
	}
}

?>
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script>
		function user_select(val){
			window.location.href = "<?php echo base_url();?>home/profile/"+val;
		}
	</script>

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
    
		<div id="left" class="grid_8 alpha">

			<!-- Choix d'un adhérent -->
            <div id="choix_adherent">
                <h1>Gestion des adhérents</h1>
                <?php
                    echo form_open('');	
                    echo form_dropdown('user', $user_options,$selected_user,$user_js);
                    echo form_close();
                ?>
            </div>
            <!-- Choix d'un adhérent // END -->  
            
            <!-- Détail de l'adhérent -->
			<?php if ($selected_user>0){ ?>
            	
                <!-- Détail des information de l'adhérent sélectionné -->
                <div id="detail_adherent">
                    <h2>Informations</h2>
                    <div id="detail">
                        <p><span class="label_form">N° adhérent : </span><span class="label_value"><?php echo $user->id; ?></span></p>
                        <p><span class="label_form">Né le : </span><span class="label_value"><?php echo $user->date_naissance; ?></span></p>
                        <p><span class="label_form">Profession : </span><span class="label_value"><?php echo $user->profession; ?></span></p>
                        <p><span class="label_form">Statut : </span><span class="label_value"><?php echo $user->statut; ?></span></p>
                    </div>
                    
                    <div id="contact">
                        <p><span class="label_form">Tél : </span><span class="label_value"><?php echo $user->phone; ?></span></p>
                        <p><span class="label_form">Email : </span><span class="label_value"><a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a></span></p>
                        <p><span class="label_form">Web : </span><span class="label_value"><a href="<?php echo $user->site_web; ?>"><?php echo $user->site_web; ?></a></span></p>
                    </div>     
                </div>
				<!-- Détail des information de l'adhérent sélectionné // END -->   
                
                <!-- Gesstion des commandes -->   
                <div id="gestion_commande">
                    <h2>Commandes</h2>

                    <!-- Ajout d'une commande -->
                    <div id="add">       
                        <h3> Ajouter une commande </h3>
                        <?php
                            echo form_open('home/commande/'.$user->id);	
                            echo form_dropdown('pack_type', $pack_options);
                            echo form_dropdown('periode', $periode_options);
                            echo form_submit('submit', 'Valider');
                            echo form_close();
                        ?>
                    </div>
                    <!-- div id="add" //END -->                    
                    
                    <div class="separateur"></div>
				    <div class="clear"></div>
                    
					<!-- Détail d'une commande -->
                
					<div id="detail_commande">
						<h3>Détail des commandes</h3>
						<?php 
						if (count($commandes)==0){
							echo 'Aucune commande en cours';
						}else{
						
							foreach ($commandes as $commande)
							{ 
								if($commande->solde_ticket>0) { 	
									echo '<p class="pack_valide">'; 
								}else{
									echo '<p class="pack_non_valide">'; 
								}
							?>						
								<span class="pack_libelle"><?php echo $commande->pack_libelle; ?></span><br/>
                                <span class="periode_libelle"><?php echo $commande->periode_libelle; ?></span><br/>
                                
								<span class="label_form">Acheté le : </span><?php echo $commande->date_achat?><br/>
								<span class="label_form">Ticket(s) restant : </span><?php echo $commande->solde_ticket?><br/>
                                
								<?php 
								$ticket_options=array();
								if ($commande->solde_ticket > 0){
									for ($i=0.5;$i<=$commande->solde_ticket;$i=$i+0.5){
										$ticket_options[(string)$i]=$i;
									}
	
									echo form_open('home/debit/'.$user->id);	
									echo form_hidden('commande_id',$commande->id);
									echo "Débiter : ";
									echo form_dropdown('nb_ticket', $ticket_options);
									echo form_submit('submit', 'Valider');
									echo form_close();
	
								}
								?>        	
								</p>
						<?php
							}
						}
						?>
					</div>
                	<!-- Détail d'une commande // END -->                    
                    
                </div>
                <!-- div id="gestion_commande" //END -->   
                   
            <?php } ?>
            <!-- Si un utilisateur est sélectionné //END -->   
		</div>        

        <div id="right" class="grid_8 omega">    

			 <!-- Formulaire de création d'un nouvel adhérent -->
        
            <div id="create_form" >
                <h1>Créer un nouvel adhérent</h1>
                
                <?php echo form_open("home/new_user",array('class'=>'cssform')); ?>
                
                <p> <label for="last_name" class="inline">Nom</label><?php echo form_input(array('name'=>'last_name','id'=>'last_name'));?></p>
                <p> <label for="first_name" class="inline">Prénom</label> <?php echo form_input(array('name'=>'first_name','id'=>'first_name'));?></p>
                <p> <label for="email" class="inline">Email</label> <?php echo form_input(array('name'=>'email','id'=>'email'));?></p>
                <p> <label for="password" class="inline">Password</label> <?php echo form_input(array('name'=>'password','id'=>'password'));?></p>
                <p> <label for="phone" class="inline">Téléphone</label> <?php echo form_input(array('name'=>'phone','id'=>'phone'));?></p>                    
                <p> <label for="date_naissance" class="inline">Date de naissance</label> <?php echo form_input(array('name'=>'date_naissance','id'=>'date_naissance'));?></p>                    
                <p> <label for="profession" class="inline">Profession</label> <?php echo form_input(array('name'=>'profession','id'=>'profession'));?></p>                    
                <p> <label for="statut" class="inline">Statut</label> <?php echo form_input(array('name'=>'statut','id'=>'statut'));?></p>                    
                <p> <label for="site_web" class="inline">Site web</label><?php echo form_input(array('name'=>'site_web','id'=>'site_web'));?></p>       
                <p><?php echo form_submit('submit', 'Valider');?></p>             
    
                <?php echo form_close();?>     
            </div>
            
            <!-- Formulaire de création d'un nouvel adhérent // END -->

        </div>
        <!-- div id="right" //END -->
            
    </div>
    <!-- div id="content" //END -->

	<!-- PAGE FOOTER -->        
    <div id="footer">
        <p style="text-align:center"><a href="http://www.coworkinglille.com/">Coworkinglille.com</a></p>
        <p>&nbsp;</p>
    </div>
	<!-- END FOOTER -->
        
</div>
<!-- div id="wrapper" class="container_16" //END -->
    
</body>
</html>                    