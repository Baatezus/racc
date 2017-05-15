<?php

class Formats_model extends CI_Model {
    
    public function getAllFormats() {
        
        $this->load->database();
             
        $query = $this->db->get('formats');
        
        return $query->result();
    }
}