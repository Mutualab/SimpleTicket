<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Gestion des tickets" />
    <meta name="keywords" content="coworkinglille, coworking, lille" />
    <title>CoworkingLille Ticket</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/reset.css" media="screen" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/account.css" media="screen" />
    <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>js/nicescroll.min.js"></script>
    <script src="<?php echo base_url(); ?>js/canvasjs.min.js"></script>
</head>
<body>

<?php 
function round_to_five($value){
 $max=5;
 $floor_val = floor($value); // ici on récupère l'entier 
 $x = strlen($floor_val); // nombre de chiffres
 $y = substr($floor_val, -1, 1); // ici on récupère le dernier chiffre
 
 if($y < $max){ // si il est inférieur à $max
  $z = (int) (substr($floor_val, 0, ($x - 1)) . "0");  // on récupère tous les chiffres sauf le dernier qu'on remplace par un zéro
 }
 else{
  //sinon on récupères tous les chiffres sauf le dernier, on ajoute 1 puis on remplace toujours le dernier chiffre par zero  (on passe à la dizaine supérieure)
  $z = (int)((substr($floor_val, 0, ($x - 1)) + 1) . "0");
  }
 
 return $z;
}

?>

<div class="wrapper">
	<div class="nav">
		<!-- <div class="avatar"></div> -->
		<h1>bienvenu(e) </h1>
		<h2><?php echo $user->first_name; ?> <?php echo $user->last_name; ?></h2>
		<div class="quit"><a href="<?php echo site_url('account'); ?>">Quitter</a></div>
		<div class="pack-list">
			<h1>Vos commandes</h1>
			<ul>
			<?php 
			foreach($orders as $order) : 
				$selected ='';$empty='';
				if(isset($order_id) && $order->id==$order_id) $selected='selected';
				if($order->solde_ticket==0) $empty='empty-pack';
			?>
				<li class="empty-pack <?php echo $selected; ?>"><a href="<?php echo site_url('account/status/'.$user->id.'/'.$order->id); ?>"><?php echo $order->pack_libelle; ?> <span><?php echo date_format(new DateTime($order->date_achat), 'd-m-Y'); ?></span></a></li>
			<?php endforeach; ?>
			</ul>
		</div>

	</div>
	<div class="content">
		
	<?php if(isset($order_id)): ?>
		
		<?php if($order_detail->pack_libelle=="Forfait Mensuel") :?>
			<span style="width : 80%; display : block; text-align:center;font-weight:300;font-size : 3rem;margin : 5rem auto;">Ce mois-ci, venez quand vous voulez&nbsp;!</span>
		<?php else : ?>
			<div id="pie">
	    		
			</div>
			<script>

				CanvasJS.addColorSet("mutualab",
                		[//colorSet Array

                		"#f8d000",
                		"#eb3831"              
                		]);
				var chart = new CanvasJS.Chart("pie",
					{
						colorSet: "mutualab",
					      title:{
					        text: "Il vous reste <?php echo $order_detail->solde_ticket; ?> tickets sur ce pack.",  
					        fontFamily : "Open sans",
					        fontColor: "#666",
					        fontSize: 14,
					        padding: 10,
					        margin: 15,
					      },
						toolTip : { enabled : false } ,
						data: [
						{        
							type: "doughnut",
							startAngle: 270, 
							indexLabelLineColor: "white",                         
        					indexLabelLineThickness: 1, //1, 2, 4, 5, 6       
							showInLegend: false,
							dataPoints: [
								{  y: <?php echo $order_detail->nb_ticket_utilise; ?>},
								{  y: <?php echo $order_detail->solde_ticket; ?>}		

							]
						}
						]
					});

					chart.render();
				
			</script>

			<!-- <span style="width : 100%; display : block; text-align:center;font-weight:300;font-size : 1.2rem;"> Sur ce pack, il vous reste <?php echo $order_detail->solde_ticket;?> journées.</span> -->
		
			<?php if($order_detail->solde_ticket>0) : ?>
				<hr/>
				<span style="width : 100%; display : block; text-align:center;font-weight:300;font-size : 1.2rem;margin-top : 1rem;"> Et aujourd'hui, vous serez là ?</span>
				<!-- <span style="width : 100%; display : block; text-align:center;font-weight:300;font-size : 0.7rem;"> (Pour les forfaits mensuels, cela n'a qu'une valeur statistique... merci !)</span> -->
				<div class="use-ticket">
					<?php
						echo form_open('account/useticket/'.$user->id);	
						echo form_hidden('order_id',$order_id);
					?>
						<ul>
							<li class="minus">-</li>
							<li class="stepper"><input type="text" name="use-ticket-value" id="use-ticket-value" value="0.5"></li>
							<li class="plus">+</li>
						</ul>
					<?php 
						echo form_submit('submit', 'Valider');
						echo form_close();
					?>

				</div>
			<?php endif; ?>
		<?php endif; ?>
		<div class="order-history">
		<h1>Historique de ce pack</h1>
		<ul>
		<?php foreach ($order_detail->historique as $past_order) :?>

			<li><span class='use-date'><?php echo date_format(new DateTime($past_order->date), 'd-m-Y'); ?></span> <?php echo $past_order->nb_ticket; ?> j.</li>
		<?php endforeach; ?>
		</ul>
		</div>
	<?php endif; ?>
<?php

?>

	</div>
</div>

<script>
  	$(document).ready( function() {  

  		$(".order-history ul").hide();
    	$(".order-history ul").niceScroll();
    	
    	$(".order-history h1").on('click',function(e){
    		$(".order-history ul").toggle('slow');
    	});
    	$('.minus').on('click',function(e){
    		var val = parseFloat($('.stepper input').val());
    		if(val>=0.5)
    			$('.stepper input').val(val-0.5);
    	});
		$('.plus').on('click',function(e){
    		var val = parseFloat($('.stepper input').val());
    		$('.stepper input').val(val+0.5);
    	});    	
	});
</script>
</body>
</html>