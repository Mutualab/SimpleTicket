<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adherent_model extends CI_Model{
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function save($nom,$prenom,$email,$id=0)
	{
		return (isset($id) and $id > 0) ? $this->update($id,$nom,$prenom,$email) : $this->create($nom,$prenom,$email);
	}
	
	
	function create($user_data,$additional_data){
		return $this->ion_auth->register($user_data['username'], $user_data['password'], $user_data['email'], $additional_data);
	}
	
	function update($id,$data){
		return $this->ion_auth->update_user($id, $data);
	}
	
    function getList()
    {
		$this->db->order_by("nom", "asc"); 
		$query = $this->db->get('adherent');
       	return $query->result();
    }
	
	function getDetail($num_adherent)
    {
		$query = $this->db->get_where('adherent',array('num_adherent'=>$num_adherent));
       	return $query->row();
    }
	
	
	function addCommande($adherent_id,$pack_type_id,$periode_id)
	{
		$data=array(
			'adherent_id'=>$adherent_id,
			'pack_id'=>$pack_type_id,
			'periode_id'=>$periode_id
		);
		$this->db->insert('pack_log', $data);
		return;	
	}
	
	function getCommandes($adherent_id)
	{	
		$this->db->order_by('pack_log.date','desc',FALSE);
		$this->db->where('pack_log.pack_id','pack.id',FALSE);
		$this->db->where('pack_log.periode_id','periode.id',FALSE);
		$this->db->where('pack_log.adherent_id',$adherent_id,FALSE);
		$this->db->from('pack, periode,pack_log',FALSE);
		$this->db->select('pack.libelle AS pack_libelle, periode.libelle AS periode_libelle, pack_log .*'); 
		$query= $this->db->get();
		
		$commandes=array();
		
		foreach($query->result() as $row)
		{
			$commande=new stdClass;
			
			$commande->id=$row->id;
			$commande->adherent_id=$row->adherent_id;
			$commande->pack_id=$row->pack_id;
			$commande->pack_libelle=$row->pack_libelle;
			$commande->periode_id=$row->periode_id;
			$commande->periode_libelle=$row->periode_libelle;;
			$commande->date_achat=$row->date;
			$commande->nb_ticket=$this->getMaxPackTicket($row->pack_id);
			$commande->nb_ticket_utilise=($this->getUsedTicket($row->id)==null)?0:$this->getUsedTicket($row->id);
			$commande->solde_ticket=$this->getSolde($row->id);			
			$commande->historique=$this->getCommandeHistory($row->id);
			$commandes[]=$commande;
		}
		
		
		return $commandes;
		
		
		
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
			'pack_log_id'=>$commande_id,
			'nb_ticket'=>$nb_ticket
		);
		$this->db->insert('ticket_log', $data);
		return;	
	}

	function getUsedTicket($commande_id){
		$this->db->where('pack_log_id',$commande_id);
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

		$this->db->where('pack_log.pack_id','pack.id', FALSE);
		$this->db->where('pack_log.id',$commande_id, FALSE);
		$this->db->from('pack, pack_log', FALSE);
		$this->db->select('pack.nb_ticket AS ticketMaxPack'); 
		$query= $this->db->get();

		return $query->row()->ticketMaxPack - $this->getUsedTicket($commande_id);
					
	}
	

	
}
