<?php

class Debt_statement_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->database();
    }
    
    public function add($data) {
        
        $q = $this->db->query('SELECT id FROM localities WHERE postal_code < 1300');
        
        $tabBxlPc = [];
        
        foreach ($q->result() as $row) {
            $tabBxlPc[] = $row->id;
        }
        
        if(in_array($data['locality'], $tabBxlPc)) {
            $zone = 'bxl';
        } else {
            $zone = 'wallonie';
        }         
                  
        $this->db->insert('refund_requests_' . $zone, $data);
        
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }
    
    public function getAllStatements($zone) {
        $login = ($this->session->userdata('user')->login);
        $zone = ($login === "Yann") ? "wallonie" : "bxl";
        
        $this->db->select('r.*, f.format f, a.association_name, l.name, l.postal_code');
        $this->db->from('refund_requests_' . $zone . ' r');
        $this->db->join('associations a', 'a.id = r.association_id');
        $this->db->join('formats f', 'f.id = r.format');
        $this->db->join('localities l', 'l.id = r.locality');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function getAssoStatements($id) {
        $data=[];
        $this->db->select('r.*, f.format f, a.association_name, l.name, l.postal_code');
        $this->db->from('refund_requests_wallonie r');
        $this->db->join('associations a', 'a.id = r.association_id');
        $this->db->join('formats f', 'f.id = r.format');
        $this->db->join('localities l', 'l.id = r.locality');
        $this->db->where('association_id', $id);
        $this->db->order_by("id", "desc");
        $w = $this->db->get();
        
        $this->db->select('r.*, f.format f, a.association_name, l.name, l.postal_code');
        $this->db->from('refund_requests_bxl r');
        $this->db->join('associations a', 'a.id = r.association_id');
        $this->db->join('formats f', 'f.id = r.format');
        $this->db->join('localities l', 'l.id = r.locality');
        $this->db->where('association_id', $id);
        $this->db->order_by("id", "desc");
        $b = $this->db->get();
        
        $data['w'] = $w->result();
        $data['b'] = $b->result();
        
        return $data;
    }
    
    public function getStatement($id, $zone) {        
        $q = $this->db->where('id', $id)->get('refund_requests_' . $zone);
        
        return $q->result();
    }
    
    public function getAsso($id) {    
        $this->db->select('a.*, l.name locality_name, l.postal_code');
        $this->db->from('associations a');
        $this->db->join('localities l', 'a.locality = l.id');
        $this->db->where('a.id', $id);
        $q = $this->db->get();
        
        return $q->result()[0];
    }
    
    public function getFormats() {
        $q = $this->db->get('formats');
        
        return$q->result();
    }
    
    public function addLocalityData(&$data){
     
        $q = $this->db->query('SELECT l.name, l.postal_code , f.format '
                . 'FROM localities l , formats f'
                . ' WHERE l.id = ' . $data["locality"]
                . ' AND f.id = ' . $data["format"]);
        
        $r = $q->result()[0];
        
        $data['locality_name'] = $r->name;
        $data['locality_pc'] = $r->postal_code;
        $data['f_name'] = $r->format;
    }
    
    public function exists($s){
        
        $q = $this->db->query('SELECT id FROM localities WHERE postal_code < 1300');
        
        $tabBxlPc = [];
        
        foreach ($q->result() as $row) {
            $tabBxlPc[] = $row->id;
        }
        
        if(in_array($s['locality'], $tabBxlPc)) {
            $zone = 'bxl';
        } else {
            $zone = 'wallonie';
        } 
        
        $d = explode('T', $s['date'])[0];
        $h = explode('T', $s['date'])[1];
        $h .= ":00";
        
        $s['date'] = $d . ' ' . $h;
        
        
        foreach ($s as $key => $val) {
            $this->db->where($key, $val);
        }
        
        $this->db->from('refund_requests_' . $zone);
        $c =  $this->db->count_all_results();
        
        return $c;
    }
    
    public function tokenValid($token) {
        $q = $this->db
                ->select('token')
                ->from('users')
                ->where('id', $this->session->userdata('user')->id)
                ->get();
                       
        $t = $q->result()[0]->token;
        
        return $t = $token;
    }
    
    public function makePaid($id, $z){
        $q = "UPDATE refund_requests_". $z ." SET paid = 1 WHERE id = ". $id;
        
        $this->db->query($q);
    }
}