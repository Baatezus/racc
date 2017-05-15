<?php
class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->database();
    }
    
    public function getUser($login) {
        $q = 'SELECT * FROM users WHERE login = "' . $login . '"';
        
        
        $query = $this->db->query($q);
        
        if ($query->result())
            return $query->result()[0];
        else 
            return false;
    }
    
    public function addUser($data) {
        $this->db->insert('users', $data);
    }
    
    public function addAssociation($data) {
        $this->db->insert('associations', $data);
        
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }
    
    public function getUserByEmail($email) {
        
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->join('associations a', 'a.id = u.association_id');
        $this->db->where('a.email', $email);
        $query = $this->db->get(); 
  
        if ($query->result())
            return $query->result()[0];
        else 
            return false;
    }
    
    public function isValid($user, $password) {
       return $user->password === sha1($password);
    }
    
    public function updatePwd($id, $pwd) {
        $this->db->set('password', sha1($pwd));
        $this->db->where('id', $id);
        $this->db->update('users');    
    }
    
    public function loginExists($login) {
        $q = 'SELECT COUNT(*) AS c FROM users WHERE login = "' . $login . '"';
        
        $query = $this->db->query($q);
        
        return (int) $query->result()[0]->c > 0;
    }
    
    public function emailExists($email) {
        $q = 'SELECT COUNT(*) AS c FROM associations WHERE email = "' . $email . '"';
        
        $query = $this->db->query($q);
        
        return (int) $query->result()[0]->c > 0;
    }
    
    public function getAssociation($id) {
        $this->db->select('a.*, l.name locality_name, l.postal_code');
        $this->db->from('associations a');
        $this->db->join('localities l', 'a.locality = l.id');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        
        if ($query->result())
            return $query->result()[0];
        else 
            return false;
    }
    
    public function getStatements($id){
        $q = $this->db->query('SELECT id FROM localities WHERE postal_code < 1300');
        
        $tabBxlPc = [];
        
        foreach ($q->result() as $row) {
            $tabBxlPc[] = $row->id;
        }
        
        if(in_array($this->session->userdata('association')->locality, $tabBxlPc)) {
            $zone = 'bxl';
        } else {
            $zone = 'wallonie';
        }  
        
        $q = $this->db->where('id', $id)->get('refund_requests_' . $zone);
        
        return $q->result();
    }
    
    public function addToken($data) {
        $this->db->insert('tokens', $data);
    }
    
    public function isTokenValid($user_id, $token) {
        $query = $this->db->get_where('tokens', ['user_id' => $user_id, 'token' => $token]);
        
        @$r = $query->result()[0];
        
        if(!$r || $r->expire_at <= time()) 
            return false;
        else 
            return true;   
        die();
    }
    
        
    public function getAdminNotifications() {
        $count =  $this->db->count_all_results('temp_asso');
        
        $this->db->from('associations');
        $this->db->where('is_valid_bxl', 0);
        $this->db->or_where('is_valid_bxl', 0);
        $count += $this->db->count_all_results();
        
        return $count;
    }
}

