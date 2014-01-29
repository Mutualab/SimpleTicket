<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {


	public function index()
	{
		
		$this->load->model('user_model','user');

		$data['page_title']="Simple Ticket";
		$data['users']=$this->user->getAll();

		$this->load->view('home_view',$data);
	}
	
	public function new_user()
	{
		$username =  $this->input->post('first_name').' '. $this->input->post('last_name');
		$password = $this->input->post('password');;
		$email = $this->input->post('email');
		$additional_data = array(
								'first_name' => $this->input->post('first_name'),
								'last_name' => $this->input->post('last_name'),
								'phone' => $this->input->post('phone'),
								'date_naissance' => $this->input->post('date_naissance'),
								'profession' => $this->input->post('profession'),
								'statut' => $this->input->post('statut'),								
								'site_web' => $this->input->post('site_web'),								
								);
		$group_name = 'members';
		$this->ion_auth->register($username, $password, $email, $additional_data, $group_name);
		
		$this->load->model('user_model','user');
		$this->load->model('pack_model','pack');	

		$new_user = $this->ion_auth->get_user_by_email($email);

		redirect('home/profile/'.$new_user->id, 'refresh');
		
	}
	
	function profile($user_id)
	{
		$data['page_title']="Simple Ticket";

		$this->load->model('user_model','user');
		$this->load->model('pack_model','pack');

		$data['user']=$this->user->getDetail($user_id);
    $to = $data['user']->email;
		$data['users']=$this->user->getAll();
		$data['packs']=$this->pack->getList();		
		$data['periodes']=$this->pack->getListPeriode();		
		$data['selected_user']=$user_id;
		$data['commandes']=$this->user->getCommandes($user_id);
		$this->load->view('home_view',$data);
	}

	function commande($user_id)
	{
		$this->load->model('user_model','user');

		$this->user->addCommande($user_id,$this->input->post('pack_type'),$this->input->post('periode'));

		redirect('home/profile/'.$user_id, 'refresh');

	}
	
	function debit($user_id)
	{
		$this->load->model('user_model','user');
		$this->load->model('pack_model','pack');

		$data['user']=$this->user->getDetail($user_id);
    $data['commandes']=$this->user->getCommandes($user_id);

		$this->user->useTicket($this->input->post('commande_id'),$this->input->post('nb_ticket'));		

    $to = $data['user']->email;
    $solde = $data['commandes'][0]->solde_ticket - $this->input->post('nb_ticket'); 
    $subject = 'Votre compte CoworkingLille';
    $header = 'From: webmaster@coworkinglille.com' . "\r\n" .
    'Content-type: text/html; charset=UTF-8'  . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    if ($solde == 0 ) {
      $remarque =  "<p><b>ATTENTION</b> : Votre compte est épuisé, pensez à le mettre à jour !</p>";
    } 
    else if ( $solde < 2 ) {
      $remarque =  "<p><b>INFO</b> : Votre compte est bientot épuisé, pensez à le mettre à jour !</p>";
    }
    else $remarque = "";

     $message = "
     <html>
      <head>
       <title>Votre nouveau solde de ticket CoworkingLille</title>
      </head>
      <body>
      <p>Bonjour!</p>
      <p>Vous venez d'être debité de " . $this->input->post('nb_ticket') . " ticket(s) journée(s).</p>
      <p>Pour rappel votre solde actuel est de " . $solde . " journée(s)</p>
      <br />
      <p>Merci!</p>
      <br /> 
      <p>" . $remarque . "</p>
      </body>
     </html>
     ";

    mail($to, $subject, $message, $header);

		redirect('home/profile/'.$user_id, 'refresh');
	}
	
	function cancel_ticket($user_id,$ticket_log_id)
	{
		$this->db->where('id',$ticket_log_id);
		$this->db->delete('ticket_log');
		redirect('home/profile/'.$user_id, 'refresh');
	}
	
	function cancel_pack($user_id,$commande_id)
	{
		$this->db->where('commande_id',$commande_id);
		$this->db->delete('ticket_log');
		
		$this->db->where('id',$commande_id);
		$this->db->delete('commandes');
		
		redirect('home/profile/'.$user_id, 'refresh');
	}	
	
	function stats(){
		$data['page_title']="Simple Ticket";

		$this->load->model('user_model','user');
		$this->load->model('pack_model','pack');

		$data['users']=$this->user->getAll();
		$data['packs']=$this->pack->getList();		
		$data['periodes']=$this->pack->getListPeriode();	
		
		foreach ($data['users'] as $user){
			$com=$this->user->getCommandes($user->id);
			$data['commandes'][]=$com;

		}
			

		$this->load->view('stat_view',$data);
	
	}
	
	function rfid_data($user_rfid){
	
		$data['page_title']="Simple Ticket";
		$this->load->model('user_model','user');
		$user=$this->user->getDetailByRfid($user_rfid);
		
		if ($user){
		
			$commandes=$this->user->getCommandes($user->id);
			$solde_ticket=0;
		
			foreach ($commandes as $com){
				$solde_ticket+=$com->solde_ticket;
			}
		
			$json_data="{'name':'".$user->first_name."','solde':".$solde_ticket."}";
		
//		$this->output->set_content_type('application/json');
//    	$this->set_output("aaa");
			print($json_data);
		}else{
			print("{'error':'No Rfid found'}");
		}

	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */

