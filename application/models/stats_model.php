<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats_model extends CI_Model{
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function getStatistiques()
	{	
		$this->db->order_by('id','asc',FALSE);
		$this->db->from('statistiques',FALSE);
		$this->db->select('id,label,query,description'); 
		$query= $this->db->get();
		
		$statistique=array();
		
		foreach($query->result() as $row)
		{
			$statistique=new stdClass;
			
			$statistique->id=$row->id;
			$statistique->label=$row->label;
			$statistique->query=$row->query;
			$statistique->description=$row->description;
			$statistiques[]=$statistique;
		}
		
		return $statistiques;
	
	}
	
	function InsertQuery($label,$query,$columns,$description)
	{

		$data = array(
                'label' => $label,
                'query' => $query ,
                'description' => $description,
                'column_name' => $columns);

        $this->db->insert('statistiques', $data);

		return;	
	}

	function executeQuery($stat_id)
	{
		$this->db->where('statistiques.id',$stat_id,FALSE);
		$this->db->from('statistiques',FALSE);
		$this->db->select('query'); 
		$sql= $this->db->get();
		
		//$query = $this->db->query($sql->result()->query);
		$execute_query=array();
		$row = $sql->row(0);
		$query = $this->db->query($row->query);
		
		foreach($query->result_array() as $row)
		{
			$execute_query=new stdClass;
			$execute_query=$row;
			$execute_querys[]=$execute_query;
		}
		
		return $execute_querys;
	}
	
	function getColumnName($stat_id)
	{
		$this->db->where('statistiques.id',$stat_id,FALSE);
		$this->db->from('statistiques',FALSE);
		$this->db->select('column_name'); 
		$sql= $this->db->get();
		
		$execute_query=array();
		$row = $sql->row(0);
		
		return $row->column_name;
	}
	
	function getName($stat_id)
	{
		$this->db->where('statistiques.id',$stat_id,FALSE);
		$this->db->from('statistiques',FALSE);
		$this->db->select('label'); 
		$sql= $this->db->get();
		
		$execute_query=array();
		$row = $sql->row(0);
		
		return $row->label;
	}
	
	function DeleteQuery($stat_id)
	{
		$this->db->where('id', $stat_id);
        $this->db->delete('statistiques');
		return;	
	}
}
