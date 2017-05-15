<?php

class Association_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->database();
    }
    
    public function getAssociation() {
        
    }
    
    public function tokenValid($token) {
        $q = $this->db
                ->select('token')
                ->from('users')
                ->where('id', $this->session->userdata('user')->id)
                ->get();
                       
        $t = $q->result()[0]->token;
        
        return $t === $token;
    }
    
    public function addEditRequest($data) {
        $this->db->insert('temp_asso', $data);
    }
    
    public function requestExists($id){
        
        $q = "SELECT COUNT(*) AS c FROM temp_asso WHERE association_id = " . $id;
        
        $query = $this->db->query($q);
        
        return (int) $query->result()[0]->c > 0;
    }
    
    public function getAllAssociations() {       
        $q = "SELECT `a`.*, `l`.`name`, `l`.`postal_code`,(
                SELECT COUNT(*)
            FROM refund_requests_bxl b
            WHERE b.association_id = a.id
            AND YEAR(date) = ". date('Y') ."
        ) + 
        (
                SELECT COUNT(*)
            FROM refund_requests_wallonie w
            WHERE w.association_id = a.id
            AND YEAR(date) = ". date('Y') ."
        ) stmCount
        FROM `associations` `a` 
        JOIN `localities` `l` ON `l`.`id` = `a`.`locality`";

        
        $query = $this->db->query($q);
        
        return $query->result();
    }
    public function getBxlAssociations() {       
        $q = "SELECT `a`.*, `l`.`name`, `l`.`postal_code`,(
                SELECT COUNT(*)
            FROM refund_requests_bxl b
            WHERE b.association_id = a.id
            AND YEAR(date) = ". date('Y') ."
        ) + 
        (
                SELECT COUNT(*)
            FROM refund_requests_wallonie w
            WHERE w.association_id = a.id
            AND YEAR(date) = ". date('Y') ."
        ) stmCount
        FROM `associations` `a` 
        JOIN `localities` `l` ON `l`.`id` = `a`.`locality`"
        ."WHERE l.postal_code < 1300";

        
        $query = $this->db->query($q);
        
        return $query->result();
    }

    public function getWalAssociations() {       
        $q = "SELECT `a`.*, `l`.`name`, `l`.`postal_code`,(
                SELECT COUNT(*)
            FROM refund_requests_bxl b
            WHERE b.association_id = a.id
            AND YEAR(date) = ". date('Y') ."
        ) + 
        (
                SELECT COUNT(*)
            FROM refund_requests_wallonie w
            WHERE w.association_id = a.id
            AND YEAR(date) = ". date('Y') ."
        ) stmCount
        FROM `associations` `a` 
        JOIN `localities` `l` ON `l`.`id` = `a`.`locality`"
        ."WHERE l.postal_code >= 1300";

        
        $query = $this->db->query($q);
        
        return $query->result();
    }    
}