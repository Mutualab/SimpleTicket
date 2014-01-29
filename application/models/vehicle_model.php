<?php

class Vehicle_model extends CI_Model {
	
	var $table = 'vehicle';
	
	function Vehicle_model()
	{
		//parent::Model();
		parent::__construct();
	}
	
	function get($vid)
	{
		$vehicle = FALSE;
		if (is_numeric($vid))
		{
			$this->db->where('vid', $vid);
			$query = $this->db->get($this->table);
			if ($query->num_rows() > 0)
			{
				$vehicle = $query->row();
			}
		}
		return $vehicle;
	}
	
	function save($vehicle)
	{
		$vehicle = (object) $vehicle;
		
		// Prepare the object
		$vehicle->list_price = preg_replace('/[^0-9\.]+/', '', $vehicle->list_price);
		$vehicle->msrp = preg_replace('/[^0-9\.]+/', '', $vehicle->msrp);
		$vehicle->sale_price = preg_replace('/[^0-9\.]+/', '', $vehicle->sale_price);
		
		return (isset($vehicle->vid) and $vehicle->vid > 0) ? $this->_update($vehicle) : $result = $this->_create($vehicle);
	}
	
	function _create($vehicle)
	{
		$vehicle = (object) $vehicle;
		$vehicle->created = time();
		$vehicle->revised = $vehicle->created;
		return $this->db->insert($this->table, $vehicle);
	}
	
	function _update($vehicle)
	{
		$vehicle = (object) $vehicle;
		$vehicle->revised = time();
		$this->db->where('vid', $vehicle->vid);
		return $this->db->update($this->table, $vehicle);
	}
	
	function get_many($limit = 10, $offset = 0)
	{
		$vehicles = array();
		$this->db->limit($limit);
		$this->db->offset($offset);
		$this->db->order_by('created', 'desc');
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
			$vehicles = $query->result();
		}
		return $vehicles;
	}
	
	function count_all()
	{
		return $this->db->count_all($this->table);
	}
	
}
