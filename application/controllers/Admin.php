<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
   
    public function __construct() {
        parent::__construct();

        $this->load->model('association_model');
        $this->load->library('mailer');

        $user = $this->session->userdata('user');

        if($user === null || $user->type !== 'admin') 
        {
            redirect('/home');
        }

    }

    public function index()
    {
        $this->load->model('admin_model');
        $data['title'] = "Toutes les d&eacute;clarations";
        $data['user'] = $this->session->userdata('user');
        

        $data['zone'] = ($data['user']->login === "Yann") ? "wallonie" : "bxl";
        
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('id', 'Id', 'required');

        if ($this->form_validation->run() !== FALSE) { 
            $id = $this->input->post('id');
            $z = $data['zone'];
            $d = $this->input->post('date');
            $this->admin_model->makePaid($id, $z, $d);
        }
        
        $this->load->view('header', $data);
        $this->load->view('all_statements');
        $this->load->view('footer');
    }

    public function stats()
    {
            $this->load->helper('url');

            $viewData['title'] = 'Statistiques';
            $data['user'] = $this->session->userdata('user');
            $data['asso'] = $this->session->userdata('association');

            $this->load->view('header', $viewData);
            $this->load->view('stats');
            $this->load->view('footer');
    }

    public function associations($zone = null) {
        
 
        $data['user'] = $this->session->userdata('user');

        if($zone === "bxl"){
            $data['title'] = "Associations bruxelloises";
            $this->load->view('header', $data);
            $this->load->view('zone');
            $this->load->view('bxl_associations', $data);             
        } else if ($zone === "wallonie") {
            $data['title'] = "Associations wallones";
            $this->load->view('header', $data);
            $this->load->view('zone');
            $this->load->view('wal_associations', $data);             
        } else {
            $data['title'] = "Toutes les associations";
            $this->load->view('header', $data);
            $this->load->view('zone');
            $this->load->view('all_associations', $data);            
        }
        
        $this->load->view('footer');            
    } 
}

