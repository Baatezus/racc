<?php

class Admin_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->database();
    }
    
    public function getZone($id) {
        $q = $this->db->where('user_id', $id)->get('admins_zones');
        return $q->result()[0]->zone;
    }
    
    public function getAssoEmail($id){
        $q = $this->db->where('id', $id)->get('associations');
        
        return $q->result()[0]->email;
    }

    public function makePaid($id, $z, $d){
        $q = "UPDATE refund_requests_". $z ." SET paid = 1, date = '$d' WHERE id = ". $id;
        
        $this->db->query($q);
    }    
}