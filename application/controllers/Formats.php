<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Formats extends CI_Controller {

	public function index()
	{
                $this->load->model('formats_model');
                
                $data = $this->formats_model->getAllFormats();
                
                echo json_encode($data);
	}
}
