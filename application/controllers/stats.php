<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats extends CI_Controller {
	
	public function index()
	{
		$this->load->model('stats_model','stat');
		$data['stats']=$this->stat->getStatistiques();
		$this->load->view('stats_view',$data);
	}
	
	public function execute_query($stat_id){
		$this->load->model('stats_model','stat');
		$column_name=$this->stat->getColumnName($stat_id);
		$data['columns']=explode(";",$column_name);
		$data['name'] = $this->stat->getName($stat_id);
		$data['sqlquery'] = $this->stat->executeQuery($stat_id);
		$this->load->view('stats_query_view',$data);
	}
	
	public function new_query()
	{
		$report_name = $this->input->post('report_name');
		$sql = $this->input->post('sql');
		$column_name = $this->input->post('column_name');
		$description =  $this->input->post('description');
		$this->load->model('stats_model','stat');
		$column_name=$this->stat->InsertQuery($report_name,$sql,$column_name,$description);
		
		redirect('stats/', 'refresh');
	}	
	
	public function delete_query($stat_id){
		$this->load->model('stats_model','stat');
		$this->stat->DeleteQuery($stat_id);
		redirect('stats/', 'refresh');
	}

}
