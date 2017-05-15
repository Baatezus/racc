<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Debt_statement extends CI_Controller {
   
        public function __construct() {
            parent::__construct();
            $this->load->library('fpdf');
            $this->load->library('pdfgenerator');
            $this->load->library('mailer'); 
            $this->load->model('debt_statement_model');
            
            $user = $this->session->userdata('user');
            
            if($user->type !== 'admin') {
                $asso = $this->session->userdata('association');               
            }
        }
        
        public function index()
	{
            redirect('/home');
	}
    
	public function add()
	{
            $data['user'] = $this->session->userdata('user');
            $data['asso'] = $this->session->userdata('association');
            $data['title'] = 'Déclaration de créances';
            $data['formats'] = $this->debt_statement_model->getFormats();
            $data['message'] = '';
            
            $this->form_validation->set_rules('title', 'Title', 'callback_film_check');
            $this->form_validation->set_rules('type', 'Type', 'callback_type_check');
            $this->form_validation->set_rules('format', 'Format', 'callback_format_check');
            $this->form_validation->set_rules('locality', 'Locality', 'callback_locality_check');
            
            if ($this->form_validation->run() !== FALSE) {  
                $gen = new Pdfgenerator();
                $mailer = new Mailer(); 
                $debtStatement = $this->input->post();
                
                if($this->debt_statement_model->exists($debtStatement)) {
                    $data['message'] = "Cette déclaration à déjà été entrée...";
                } else {
                    $debtStatement['refund_amount'] = $this->calculateAmount($this->input->post());
                    
                    $id = $this->debt_statement_model->add($debtStatement);

                    $this->debt_statement_model->addLocalityData($debtStatement);

                    $gen->generateRaccPdf($debtStatement, $id, $data['asso']);
                 
                    //$mailer->send($data['user'], $id);

                    //unlink('pdf/'. $id .'.pdf');
                    //redirect('/user/mypage');
                }
            } 
            
            $this->load->view('header', $data);
            $this->load->view('debt_statement_form');
            $this->load->view('footer');   
	}
        
        public function all() {
            $login = $this->session->userdata('user')->login;
            
            $zone = ($login === "Yann") ? 'wallonie' : 'bxl';
            
            $data = $this->debt_statement_model->getAllStatements($zone);

            echo json_encode($data);            
        }
        
        public function asso() {
            $asso_id = $this->session->userdata('association')->id;
            
            $data = $this->debt_statement_model->getAssoStatements($asso_id);
            
            echo json_encode($data);
        }
        
        public function get($id) {
            $this->load->library('fpdf');
            $this->load->library('pdfgenerator');
             
            $gen = new PdfGenerator();
            
            $data = $this->refundRequest_model->getRequests($id);
            
            $gen->ReGenerateRaccPdf($data, $id);          
        }
        
        public function edit($id = null) {
            $user = $this->session->userdata('user');
          
            if($user === null || $user->type !== 'admin') 
            {
                redirect('/home');
            }
            
            $data['title'] = "Modifier une déclaration";
            $statement = $this->debt_statement_model->getStatement($id);
          
            $data['s'] = $statement[0];
            
            if ($this->form_validation->run() !== FALSE) {

            } 
            
            $this->load->view('header', $data);
            $this->load->view('debt_statement_edit_form');
            $this->load->view('footer'); 

        }
        
        public function pay($id = NULL){ 
            $user = $this->session->userdata('user');
            
            if($user->type !== 'admin') 
                    redirect('/home');

            $z = ($user->login === 'Yann') ? "wallonie" : "bxl";
            
            echo $this->debt_statement_model->makePaid($id, $z);
            
        }
        
        public function film_check()
        {      
            if ($this->input->post('title') === '')
            {
                $this->form_validation->set_message('film_check', 
                        "Aucun film n'a Ã©tÃ© choisi."
                    );
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
        
        public function type_check()
        {         
            if ($this->input->post('type') !== 'scolaire' && $this->input->post('type') !== 'publique')
            {
                $this->form_validation->set_message('type_check', 
                        "Aucun type de projection choisi."
                    );
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
        
        public function format_check()
        {      
            $t = ["1", "2", "3", "4", "5", "6"];
            if (!in_array($this->input->post('format'), $t))
            {
                $this->form_validation->set_message('format_check', 
                        "Aucun format de projection choisi."
                    );
                return FALSE;
            }
            else
            {
                return TRUE;
            }

        }
        
        public function locality_check()
        {      
            if ($this->input->post('locality') === "" )
            {
                $this->form_validation->set_message('locality_check', 
                        "Aucune commune selectionnÃ©e."
                    );
                return FALSE;
            }
            else
            {
                return TRUE;
            }

        }
        
        public function reprint($zone, $sId, $token) {
            if(!$this->debt_statement_model->tokenValid($token))
                redirect('/home');
            
            $asso = $this->session->userdata('association');
            $gen = new Pdfgenerator();
            $data = $this->debt_statement_model->getStatement($sId, $zone);
  
            $debtStatement = [];
            
            foreach ($data[0] as $key => $value) {
                $debtStatement[$key] = $value;
            }
            
            $this->debt_statement_model->addLocalityData($debtStatement);
             
            $gen->generateRaccPdf($debtStatement, $sId, $asso);

            unlink('pdf/'. $id .'.pdf');
        }
        
        public function reprintByAdmin($zone, $sId, $token,$aId) {
            if(!$this->debt_statement_model->tokenValid($token))
                redirect('/home');
            
            $asso = $this->debt_statement_model->getAsso($aId);
            $gen = new Pdfgenerator();
            $data = $this->debt_statement_model->getStatement($sId, $zone);
  
            $debtStatement = [];
            
            foreach ($data[0] as $key => $value) {
                $debtStatement[$key] = $value;
            }
            
            $this->debt_statement_model->addLocalityData($debtStatement);
             
            $gen->generateRaccPdf($debtStatement, $sId, $asso);

            unlink('pdf/'. $id .'.pdf');
        }
        
        public function calculateAmount($d) {
                $ceil = 0;
               
                $refund_amount = ($d['helped_by_cfwb'] === "1")? $d['rental_cost'] : $d['rental_cost'] / 2;

                if( (int) $d['duration'] < 40)
                        $ceil = 25;
                else 
                    if($d['format'] === '1' || $d['format'] === '6')
                        if($d['helped_by_cfwb'] === "1")
                            $ceil = ((int) $d['duration'] > 59)? 150 : 60;
                        else
                            $ceil = ((int) $d['duration'] > 59)? 100 : 50;
                    else
                        if($d['helped_by_cfwb'] === "1")
                            $ceil = ((int) $d['duration'] > 59)? 100 : 60;
                        else
                            $ceil = ((int) $d['duration'] > 59)? 50 : 40;

                if($refund_amount > $ceil) $refund_amount = $ceil;   
                
                return $refund_amount;
        }
}

