<?php

class Localities_model extends CI_Model {
    
    public function getAllLocalities() {
        
        $this->load->database();
        
        $this->db->order_by('postal_code');
        $query = $this->db->get('localities');
        
        return $query->result();
    }
}