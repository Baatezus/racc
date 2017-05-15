<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{               
            if( is_null($this->session->userdata('user')))
                $this->session->sess_destroy();
                
            $viewData['title'] = 'Accueil';

            $this->load->view('header', $viewData);
            $this->load->view('home');
            $this->load->view('footer');                
	}
}
