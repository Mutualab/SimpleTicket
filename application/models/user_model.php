<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function getAll()
	{
		return ($this->ion_auth->get_users());
	}
	
	function getDetail($user_id)
    {
		return $this->ion_auth->get_user($user_id);
    }
    
	function getDetailByRfid($user_rfid)
    {

		$users_list=$this->ion_auth->get_users();
		foreach($users_list as $usr){
			if($usr->rfid == $user_rfid) return $usr;
		}
		return false;
		
    }    
    
	
	function getCommandes($user_id)
	{	
		$this->db->order_by('commandes.date','desc',FALSE);
		$this->db->where('commandes.pack_id','pack.id',FALSE);
		$this->db->where('commandes.periode_id','periode.id',FALSE);
		$this->db->where('commandes.user_id',$user_id,FALSE);
		$this->db->from('pack, periode,commandes',FALSE);
		$this->db->select('pack.libelle AS pack_libelle, periode.libelle AS periode_libelle, commandes.*'); 
		$query= $this->db->get();
		
		$commandes=array();
		
		foreach($query->result() as $row)
		{
			$commande=new stdClass;
			
			$commande->id=$row->id;
			$commande->adherent_id=$row->user_id;
			$commande->pack_id=$row->pack_id;
			$commande->pack_libelle=$row->pack_libelle;
			$commande->periode_id=$row->periode_id;
			$commande->periode_libelle=$row->periode_libelle;;
			$commande->date_achat=$row->date;
			$commande->nb_ticket=$this->getMaxPackTicket($row->pack_id);
			$commande->nb_ticket_utilise=($this->getUsedTicket($row->id)==null)?0:$this->getUsedTicket($row->id);
			$commande->solde_ticket=$this->getSolde($row->id);			
			$commande->historique=$this->getCommandeHistory($row->id);
			$commande->start_date=$row->start_date;
			$commande->end_date=$row->end_date;
			$commandes[]=$commande;
		}
		
		return $commandes;
	
	}
	
	function addCommande($user_id,$pack_type_id,$periode_id)
	{
		if($pack_type_id == MENSUAL_TICKET)
			$end_date = "2020-12-31 23:59:59";
		else
			$end_date=date("y-m-d");
		
		$start_date = date("y-m-d");
		
		$data = array(
                'user_id' => $user_id,
                'pack_id' => $pack_type_id ,
                'periode_id' => $periode_id,
                'start_date' => $start_date,
				'end_date' => $end_date);

        $this->db->insert('commandes', $data);
		
		return;	
	}

	function getCommandeDetail($commande_id)
	{	
		$this->db->where('pack_log.pack_id','pack.id',FALSE);
		$this->db->where('pack_log.periode_id','periode.id',FALSE);
		$this->db->where('pack_log.id',$commande_id,FALSE);
		$this->db->from('pack, periode,pack_log',FALSE);
		$this->db->select('pack.libelle AS pack_libelle, periode.libelle AS periode_libelle, pack_log .*'); 
		$query= $this->db->get();
		return $query->row();
	}
	
	
	function useTicket($commande_id,$nb_ticket)
	{
		$data=array(
			'commande_id'=>$commande_id,
			'nb_ticket'=>$nb_ticket
		);
		$this->db->insert('ticket_log', $data);
		return;	
	}
	
	function UpdateEndDate($commande_id,$end_date)
	{
		list($year, $month) = explode("-", $end_date);
		$nb_days = date('t',mktime(0, 0, 0, $month, 1, $year)); 
		$full_end_date =  $end_date.'-'.$nb_days.' 23:59:59';
		$this->db->where('id', $commande_id);
		$this->db->set('end_date', $full_end_date);
		$this->db->update('commandes');
		return;	
	}
	
	function UpdateStartDate($commande_id,$start_date)
	{
		$full_start_date =  $start_date.' 00:00:00';
		$this->db->where('id', $commande_id);
		$this->db->set('start_date', $full_start_date);
		$this->db->update('commandes');
		return;	
	}

	function getUsedTicket($commande_id){
		$this->db->where('commande_id',$commande_id);
		$this->db->from('ticket_log');
		$this->db->select('SUM(nb_ticket) AS total_ticket'); 
		$query= $this->db->get();
		return $query->row()->total_ticket;
			
	}
	
	function getMaxPackTicket($pack_id)
	{
		$this->db->where('id',$pack_id);
		$this->db->from('pack');
		$this->db->select('nb_ticket'); 
		$query= $this->db->get();

		return $query->row()->nb_ticket;
	}
	
	function getSolde($commande_id){

		$this->db->where('commandes.pack_id','pack.id', FALSE);
		$this->db->where('commandes.id',$commande_id, FALSE);
		$this->db->from('pack, commandes', FALSE);
		$this->db->select('pack.nb_ticket AS ticketMaxPack'); 
		$query= $this->db->get();

		return $query->row()->ticketMaxPack - $this->getUsedTicket($commande_id);
					
	}
	
	function getCommandeHistory($commande_id)
	{
		$this->db->where('commande_id',$commande_id);
		$this->db->order_by('date','desc');
		$query = $this->db->get('ticket_log');
		
		return $query->result();
		
	}

	function getUserByCommande($commande_id)
	{	

		$this->db->where('commandes.id',$commande_id, FALSE);
		$this->db->where('users.id','commandes.user_id', FALSE);
		$this->db->from('users, commandes');
		$query = $this->db->get();

		return $query->result();
	}


	function get_today_log() {
		$d= date('Y-m-d');
		$this->db->where("date LIKE '".$d."%'");
		$this->db->from('ticket_log');
		$this->db->select('*'); 		
		$query = $this->db->get();
		
		return $query->result();
	}
	
}
