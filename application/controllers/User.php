<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
        public function __construct() {
            parent::__construct();
            
            $this->load->library('mailer');
            $this->load->model('user_model');  
        }

	public function index()
	{
            redirect('/user/login');
	}
        
        public function login($args = FALSE) {
            $data['newLogin'] = $args;
            $data['title'] = 'Connexion';
            $data['message'] = '';
            if(count($this->input->post('password')) < 2) {
                
            }
                
            $this->form_validation->set_rules('login', 'Login', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() !== FALSE) {                     
                $user = $this->user_model->getUser($this->input->post('login'));

                if($user && $this->user_model->isValid(
                        $user, $this->input->post('password')
                    )
                ) {
                    $this->session->set_userdata('user', $user);
                    $this->session->set_userdata('association', $this
                            ->user_model
                            ->getAssociation($user->association_id));
  
                    if($user->type === 'association') {
                        redirect('/user/mypage');  
                    } else {         
                        redirect('/admin');
                    }
                    
                } else {
                    $data['message'] = "Mauvaise combinaison pseudo/mot de passe";
                }  
            }   
            $this->load->view('header', $data);
            $this->load->view('login_form');
            $this->load->view('footer');
        }
        
        public function logout() {
            $this->session->sess_destroy();
            redirect('/home');
        }
        
        public function forgot() {
            $data['title'] = 'Retrouver ses identifiants';
            $data['message'] = '';
            $data['email_sent'] = false;

            $this->form_validation->set_rules('email', 'E-mail', 'required');

            if ($this->form_validation->run() !== FALSE) {                
                $this->load->model('user_model');
                
                $user = $this->user_model->getUserByEmail($this->input->post('email'));
                
                if($user) {
                    $tokenData['expire_at'] = time() + 1800;
                    $tokenData['token'] =  md5(uniqid());
                    $tokenData['user_id'] = $user->id;
                    $this->user_model->addToken($tokenData);
                    
                    $url='http://www.yannlaru.com/index.php/user/new_password/' .
                            $tokenData['user_id'] . '/' .
                            $tokenData['token'];
                    
                    $mailer = new Mailer();
                    //$mailer->sendNewPwdRequest($user->email, $url);
                    $data['email_sent'] = true;
                    $data['email'] = $this->input->post('email');
                    
                } else {
                    $data['message'] = "Cet email ne correspond à aucun compte";
                }  
            } 
            
            $this->load->view('header', $data);
            $this->load->view('forgot_form');
            $this->load->view('footer');
        }
        
        public function register() {
            $data['title'] = 'Inscrire son association';
            $data['message'] = '';
            $this->form_validation->set_rules('login', 'Pseudo', 'callback_login_check');
            $this->form_validation->set_rules('email', 'Email', 'callback_email_check');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'callback_passconf_check');
            
            if ($this->form_validation->run() !== FALSE)
            {
                $user = array_slice($this->nbParse($this->input->post()), 0, 2); 
                $association = array_slice($this->nbParse($this->input->post()), 3);
                
                $user['association_id'] = $this->user_model->addAssociation($association);
                $user['token'] = md5(uniqid());
                $this->user_model->addUser($user);
                
                redirect('user/login/1');
            }
            
            $this->load->view('header', $data);
            $this->load->view('register_form');
            $this->load->view('footer');
        }
        
        public function new_password($user_id = null, $token = null) {
            $data['title'] = "Nouveau mot de passe";
            $data['token'] = $token; 
            $data['user_id'] = $user_id;
            
            $postData = $this->input->post();

            if(isset($postData['token']) && isset($postData['user_id'])) {
                $token = $postData['token'];
                $user_id = $postData['user_id'];
            }
 
            $isTokenValid = $this->user_model->isTokenValid($user_id, $token);
            if(!$isTokenValid)
                redirect('user/invalid_token');
  
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'callback_passconf_check');

            $frmValidation = $this->form_validation->run() !== FALSE;
            
            if ($frmValidation) {                     
                $this->user_model->updatePwd($user_id, $this->input->post('password'));
                
                redirect('user/password_updated');
            } 
            
            $this->load->view('header', $data);
            $this->load->view('new_pwd_form');
            $this->load->view('footer'); 
        }
       
        public function myPage() {
            if(!isset($this->session->userdata['user']))
                    redirect('/user/login');
            
            if($this->session->userdata('user')->type === 'admin')
                    redirect('/admin');
                        
            $data['title'] = "Page de l'association";
            $data['user'] = $this->session->userdata('user');
            $data['asso'] = $this->session->userdata('association');
            
            $this->load->view('header', $data);
            $this->load->view('mypage');
            $this->load->view('footer');    
        }
        
        public function change_password() {
            $data['title'] = 'Changer son mot de passe';
            $data['message'] = '';
            
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('new_password', 'New password', 'required');
            $this->form_validation->set_rules('passconf', 'Passconf', 'required');
            $this->form_validation->set_rules('passconf', '', 'callback_passconfn_check');
            
            if ($this->form_validation->run() !== FALSE)
            {
                if($this->user_model->isValid($this->session->userdata('user'), $this->input->post('password'))) {
                $this->user_model->updatePwd(
                        $this->session->userdata('user')->id,
                        $this->input->post('new_password')
                );
                
                redirect('user/password_updated');                    
                } else {
                    $data['message'] = "Vous n'avez pas entré le bon mot de passe.";
                }
            }
            
            $this->load->view('header', $data);
            $this->load->view('change_pwd');
            $this->load->view('footer');       
        }        
        
        //VALIDATION
        
        public function password_updated() {
            $data['title'] = "Mot de passe modifié";
            $this->load->view('header', $data);
            $this->load->view('pwd_updated');
            $this->load->view('footer');            
        }
        
        public function invalid_token() {
            $data['title'] = "Jeton expiré";
            $this->load->view('header', $data);
            $this->load->view('invalid_token');
            $this->load->view('footer');             
        }        
        
        //FORM VALIDATION
        
        public function login_check($login)
        {      
                if ($this->user_model->loginExists($login))
                {
                        $this->form_validation->set_message('login_check', 
                                'Ce pseudo est déjà pris.'
                            );
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
        
        public function email_check($email)
        {      
                if ($this->user_model->emailExists($email))
                {
                        $this->form_validation->set_message('email_check', 
                                'Cet adresse mail est déjà prise.'
                            );
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
        
        public function passconf_check($pwd)
        {      
                if ($this->input->post('password') !== $pwd)
                {
                        $this->form_validation->set_message('passconf_check', 
                                'Les mots de passe ne correspondent pas.'
                            );
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
        
        public function passconfn_check($pwd)
        {      
                if ($this->input->post('new_password') !== $pwd)
                {
                        $this->form_validation->set_message('passconfn_check', 
                                'Les mots de passe ne correspondent pas.'
                            );
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
                
        
        //PARSE METHOD
                
        public function nbParse($userData) {
                if(isset($userData['national_nb1'])) {
                    $national_nb = $userData['national_nb1'] .
                        '-' . $userData['national_nb2'] .
                        '.' . $userData['national_nb3'];

                    unset($userData['national_nb1']);
                    unset($userData['national_nb2']);
                    unset($userData['national_nb3']);
                  
                    $userData['national_nb'] = $national_nb;
                } else {

                    $business_nb = $userData['business_nb1'] .
                        '.' . $userData['business_nb2'] .
                        '.' . $userData['business_nb3'];

                    unset($userData['business_nb1']);
                    unset($userData['business_nb2']);
                    unset($userData['business_nb3']);
                    
                    $userData['business_nb'] = $business_nb;
                
                }
                
                $account_nb = 'BE ' . $userData['account_nb1'] .
                    ' ' . $userData['account_nb2'] .
                    ' ' . $userData['account_nb3'] .
                    ' ' . $userData['account_nb4'];
            
                unset($userData['account_nb1']);
                unset($userData['account_nb2']);
                unset($userData['account_nb3']);
                unset($userData['account_nb4']);
                
                $userData['account_nb'] = $account_nb;
                $userData['password'] = sha1($userData['password']);
                
                return $userData;
        }  
        
        public function notifications() {
            $user = $this->session->userdata('user');
                       
            if($user === null) 
            {
                redirect('/home');
            }
            
            if($user->type === "admin")
                $n = $this->user_model->getAdminNotifications();
            else
                $n = $this->user_model->getAssoNotifications();
            
            echo $n;
        }
}

