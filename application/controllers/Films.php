<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Films extends CI_Controller {

	public function index()
	{
                $this->load->model('films_model');
                
                $data = $this->films_model->getAllFilms();
                
                echo json_encode($data);
	}   
        
        public function arrayToCsv( array &$fields, $delimiter = ';', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {
            $delimiter_esc = preg_quote($delimiter, '/');
            $enclosure_esc = preg_quote($enclosure, '/');

            $output = array();
            foreach ( $fields as $field ) {
                if ($field === null && $nullToMysqlNull) {
                    $output[] = 'NULL';
                    continue;
                }

                // Enclose fields containing $delimiter, $enclosure or whitespace
                if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
                    $output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
                }
                else {
                    $output[] = $field;
                }
            }

            return implode( $delimiter, $output );
        }      
}
