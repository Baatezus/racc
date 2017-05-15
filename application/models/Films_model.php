<?php

class Films_model extends CI_Model {
    
    public function getAllFilms() {
        
        $this->load->database();
             
        $query = $this->db->get('films');
        
        return $query->result();
    }
    
}