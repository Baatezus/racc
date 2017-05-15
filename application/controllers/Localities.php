<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Localities extends CI_Controller {

	public function index()
	{
                $this->load->model('localities_model');
                
                $data = $this->localities_model->getAllLocalities();
                
                echo json_encode($data);
	}
}
