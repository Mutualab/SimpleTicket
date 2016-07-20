<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {
	
	public function index()
	{
		$this->load->model('user_model','user');
		$data['users']=$this->user->getAll();

		$daily_stats = array();

		$logs = $this->user->get_today_log();
		foreach ($logs as $log) {
			$user_id = $this->user->getUserByCommande($log->commande_id);
			$usr_data = array_shift($user_id) ;
			if($usr_data) {
				$usr = $this->user->getDetail($usr_data->user_id);
				$usr_stats = new stdClass();
				$usr_stats->first_name = $usr->first_name;
				$usr_stats->last_name = $usr->last_name;
				$usr_stats->nb_ticket = $log->nb_ticket;

				array_push($daily_stats, $usr_stats);
			}
			

		}
			
		$data['daily_stats'] = $daily_stats;

		$this->load->view('account_view',$data);
	}

	public function status($user_id,$order_id=null){
		$this->load->model('user_model','user');
		$this->load->model('pack_model','pack');
		
		$data['user']=$this->user->getDetail($user_id);
		$data['packs']=$this->pack->getList();
		$data['orders']=$this->user->getCommandes($user_id);	
		if($order_id) {
			foreach($data['orders'] as $order) {
				if($order->id==$order_id)
					$data['order_detail'] = $order;
			}
			
		}
		$data['order_id'] = $order_id;

		$this->load->view('account_status_view',$data);
	}

	public function useticket($user_id) {

		$order_id = $this->input->post('order_id');

		$this->load->model('user_model','user');
		$this->load->model('pack_model','pack');

		$data['user']=$this->user->getDetail($user_id);
	    $data['commandes']=$this->user->getCommandes($user_id);

		$this->user->useTicket($order_id,$this->input->post('use-ticket-value'));		
		redirect('account/status/'.$user_id.'/'.$order_id, 'refresh');
	}

	public function today(){
		$this->load->model('user_model','user');
		
		$logs = $this->user->get_today_log();
		foreach ($logs as $log) {
			$user_id = $this->user->getUserByCommande($log->commande_id);
			$usr = $this->user->getDetail($user_id[0]->user_id);
			echo $usr->last_name.' '.$usr->first_name.' : '.$log->nb_ticket."<br/>";
		}
	
	}

}
