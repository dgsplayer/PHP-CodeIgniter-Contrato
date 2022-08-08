<?php

class Tb_creditos_model extends CI_Model {

    private $_table = "tb_pessoas";

    public function contratos_mes()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select("count(*) as total");
        $this->db->select("DATE_FORMAT(dt_cad, '%Y%m') as meses", FALSE);

        $this->db->where('id_pessoa_pai', $user["id_pessoa"] );
        $this->db->group_by('meses');
        $this->db->order_by('meses DESC');
        $q = $this->db->get( 'tb_contratos' );
        if($q->num_rows > 0) {
            return $q->result();
        }
    }

    public function credito_mes_vigente()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select("count(*) as total");

        $this->db->where('MONTH(dt_cad) = MONTH(current_date)' );
        $this->db->where('YEAR(dt_cad) = YEAR(current_date)' );
        $this->db->where('id_pessoa_pai', $user["id_pessoa"] );
        $q = $this->db->get( 'tb_contratos' );
        if($q->num_rows > 0) {
            return $q->row();
        }
    }

    public function credito_usuarios()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select("count(*) as total");
        $this->db->where('id_pessoa', $user["id_pessoa"] );
        $q = $this->db->get( 'tb_usuarios' );
        if($q->num_rows > 0) {
            return $q->row();
        }
    }

    public function credito_tipos_contratos()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->select("count(*) as total");
        $this->db->where('id_pessoa_pai', $user["id_pessoa"] );
        $q = $this->db->get( 'tb_contratos_tipos_x_pessoas' );
        if($q->num_rows > 0) {
            return $q->row();
        }
    }

    public function contratada()
    {
        $user = $this->session->userdata('contrato_user');

        $this->db->where('id_pessoa', $user["id_pessoa"] );
        $this->db->limit(1);
        $q = $this->db->get( $this->_table );
        if($q->num_rows > 0) {
            return $q->row();
        }
    }

    public function plano()
    {
        $user = $this->session->userdata('contrato_user');

        $this->db->where('id', $user["plano"] );
        $this->db->limit(1);
        $q = $this->db->get( 'tb_planos' );
        if($q->num_rows > 0) {
            return $q->row();
        }
    }


}