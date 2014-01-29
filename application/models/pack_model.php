<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pack_model extends CI_Model{
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function getList()
    {
		$this->db->order_by("nb_ticket", "asc"); 
		$query = $this->db->get('pack');
       	return $query->result();
    }

	function getPackDetail($pack_id)
	{
		$this->db->where('id', $pack_id); 
		$query = $this->db->get('pack');
		return $query->row();
	}
	
	function getListPeriode()
	{
		$this->db->order_by("date_debut", "asc"); 
		$query = $this->db->get('periode');
       	return $query->result();
	}
	
	function getCurrentPeriode(){
		$today = date("Y-m-d"); 
		$this->db->where('date_debut <', $today); 
		$this->db->where('date_fin > ', $today); 
		$query = $this->db->get('periode');
		return $query->row();
	}	
	
}