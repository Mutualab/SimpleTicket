<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
	
	public function index()
	{
		$this->load->model('user_model','user');
		$data['users']=$this->user->getAll();
		echo json_encode($data);
	}

	

}

