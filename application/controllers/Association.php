<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Association extends CI_Controller {
   
        public function __construct() {
            parent::__construct();
            
            $this->load->model('association_model');
            $this->load->library('mailer');
        }
        
        public function index()
	{
            redirect('/home');
	}
        
        public function all()
	{
            $user = $this->session->userdata('user');
                       
            if($user === null || $user->type !== 'admin') 
            {
                redirect('/home');
            }
            
            $data = $this->association_model->getAllAssociations();

            echo json_encode($data); 
	}
        
        public function bxl()
	{
            $user = $this->session->userdata('user');
                       
            if($user === null || $user->type !== 'admin') 
            {
                redirect('/home');
            }
            
            $data = $this->association_model->getBxlAssociations();

            echo json_encode($data); 
	}
        
        public function wal()
	{
            $user = $this->session->userdata('user');
                       
            if($user === null || $user->type !== 'admin') 
            {
                redirect('/home');
            }
            
            $data = $this->association_model->getWalAssociations();

            echo json_encode($data); 
	}        
	public function edit($token = NULL)
	{
            if($this
                    ->association_model
                    ->requestExists($this->session->userdata('association')->id)
                ) {
                redirect('association/noedit');
            }
            
            if(NULL !== $this->input->post('token'))
                $token = $this->input->post('token');
            
            if(!$this->association_model->tokenValid($token))
                redirect('/home');

            $data['title'] = "Modifier les informations de l'association";
            $data['asso'] = $this->session->userdata('association');
            $data['token'] = $token;
            $data['message'] = '';
            
            $this->form_validation->set_rules('token', 'Token', 'required');
                    
            if ($this->form_validation->run() !== FALSE)
            {
                
                $association = $this->input->post();
               
                $this->nbParse($association);
                
                unset($association['token']); 
                
                foreach ($association as $key => $value) {
                    if(strlen($value) < 3)
                        unset($association[$key]); 
                }
                
                if(strlen($association['account_nb']) < 7)
                    unset($association['account_nb']); 

                if(count($association) > 0) {
                    $association['association_id'] = $this
                            ->session
                            ->userdata('association')
                            ->id;
                    
                    $this->association_model->addEditRequest($association);

                    $mailer = new Mailer();

                    redirect('/association/done');
                } else {
                    $data['message'] = "Vous n'avez rempli aucun champ...";
                }
            }
            
            $this->load->view('header', $data);
            $this->load->view('edit_asso_form');
            $this->load->view('footer');       
        }
        
                
        public function noedit() {
            $data['title'] = "Demande dÃ©jÃ  effectuÃ©e...";
            
            $this->load->view('header', $data);
            $this->load->view('noedit');
            $this->load->view('footer');  
        }
        
        public function done() {
            $data['title'] = "Demande envoyÃ©e";
            
            $this->load->view('header', $data);
            $this->load->view('editdone');
            $this->load->view('footer');  
        }
        
        public function get($id) {
            $data = $this->association_model->get($id);
            
            echo json_encode($data);
        }
        
        public function nbParse(&$userData) {
            $national_nb = $userData['national_nb1'] .
                '-' . $userData['national_nb2'] .
                '.' . $userData['national_nb3'];

            unset($userData['national_nb1']);
            unset($userData['national_nb2']);
            unset($userData['national_nb3']);

            $userData['national_nb'] = $national_nb;

            $business_nb = $userData['business_nb1'] .
                '.' . $userData['business_nb2'] .
                '.' . $userData['business_nb3'];

            unset($userData['business_nb1']);
            unset($userData['business_nb2']);
            unset($userData['business_nb3']);

            $userData['business_nb'] = $business_nb;

            $account_nb = 'BE ' . $userData['account_nb1'] .
                ' ' . $userData['account_nb2'] .
                ' ' . $userData['account_nb3'] .
                ' ' . $userData['account_nb4'];

            unset($userData['account_nb1']);
            unset($userData['account_nb2']);
            unset($userData['account_nb3']);
            unset($userData['account_nb4']);

            $userData['account_nb'] = $account_nb;
        }

}

