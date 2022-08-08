<?php

class Tb_ajuda_voce_sabia_model extends CI_Model {

    private $_table = "tb_ajuda_voce_sabia";

    public function fetch_result()
    {
        $data = array();

        $this->db->select('*');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(10);

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->result();
        }
        return $data;
    }


}