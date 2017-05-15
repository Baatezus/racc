<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Subventions extends CI_Controller {

	public function index()
	{
                $this->load->helper('url');
                $this->load->helper('html');
                
                $viewData['title'] = 'Subventions';
                
                $this->load->view('header', $viewData);
		$this->load->view('subventions');
                $this->load->view('footer');   
                
	}
}
