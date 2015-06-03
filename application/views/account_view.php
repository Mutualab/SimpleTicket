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
</head>
<body>

<div class="wrapper">
  
	<div class="nav">
		<!-- <div class="image"><img src="<?php echo base_url(); ?>images/work.jpg"></div> -->
		<h1>bienvenu(e) à </h1>
		<h1></h1>
		<div class="daily">
			<ul>
			<?php foreach ($daily_stats as $log) {
				echo "<li>".$log->first_name." ".$log->last_name." <i>(".$log->nb_ticket.")</i></li>";
			} ?>
			</ul>
		</div>
	</div>
	<div class="content">
		
		<div class="users">

			<div class="users-list">
				<ul>
				<?php 
					function cmp($a, $b){
				    		return strcmp($a->last_name, $b->last_name);
					}
					usort($users, "cmp");
				?>
				<?php foreach($users as $user) : ?>
					<?php
						$gravatar_hash =  md5( strtolower( trim($user->email ) ) );
						$gravatar = '<img src="http://www.gravatar.com/avatar/'.$gravatar_hash.'?s=40">';
					?>
					<li><a href="<?php echo site_url('/account/status/'.$user->id); ?>"><?php echo $gravatar; ?> <?php echo $user->last_name . ' ' .$user->first_name; ?></a></li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>

	</div>
</div>

<?php 
	/*foreach($orders as $order) :
		echo $order->pack_libelle;
		echo $order->date_achat;
		echo $order->nb_ticket;
		echo $order->nb_ticket_utilise;
		echo $order->solde_ticket;

	endforeach;*/


?>
<script>
  $(document).ready(
    function() {  
    	$(".users-list").css('height',$(window).height());	
    	$(".users-list").niceScroll();
    	$(window).on('resize',function(){
    		$(".users-list").css('height',$(window).height());	
    	})
    	
    }
  );
</script>
</body>
</html>
