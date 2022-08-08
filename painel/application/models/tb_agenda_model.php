<?php

class Tb_agenda_model extends CI_Model {

    private $_table = "evenement";

    public function fetch_results()
    {
        $data = array();
        $user = $this->session->userdata('contrato_user');

        $this->db->select('*');
        $this->db->where('id_usuario', $user["id_usuario"] );
        $this->db->order_by('id', 'DESC');

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->result();
        }
        return $data;
    }

    public function fetch_all_dia( $dia = null )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('id_usuario', $user['id_usuario']);
        $this->db->where('lido', 'f');
        $today   = date('Y') . '-' . date('m') . '-' . date('d') ;
        //exit;
        $this->db->where("start like '" .  $today . "%'");
        //$this->db->where('start >=',date("Y-m-d H:i:s",strtotime("-1 day")));

        $q = $this->db->get($this->_table);
        return $q->result();
    }

    public function fetch_all_amanha( $dia = null )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('id_usuario', $user['id_usuario']);
        $this->db->where('lido', 'f');
        $tomorrow   = date('Y') . '-' . date('m') . '-' . date('d',strtotime("+1 day")) . '' ;
        //exit;
        $this->db->where("start like '" .  $tomorrow . "%'");
        //$this->db->where('start >=',date("Y-m-d H:i:s",strtotime("-1 day")));

        $q = $this->db->get($this->_table);
        return $q->result();
    }

    public function fetch_row_servicos( $id_servico )
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('id' , $id_servico);
        $this->db->where('id_pessoa_pai', $user['id_pessoa'] );

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return false;
    }

    public function insert()
    {
        $user = $this->session->userdata('contrato_user');
        $data = $this->input->post();

        $data['id_usuario']  = $user['id_usuario'];

        if( $this->db->insert( $this->_table, $data) ) {
            return true;
        }
        return false;
    }

    public function insert_via_contrato($id_contrato)
    {
        $user               = $this->session->userdata('contrato_user');
        $data               = array();
        $dtExpiracao        = $this->input->post('data_vigencia_contrato');
        //inserindo no calendário

        if(!empty($dtExpiracao)){

            $data['start']   =  substr($this->input->post('data_vigencia_contrato') ,13,10);
            $data['start']   =  implode( "-", array_reverse( explode( "/", $data['start'] ) ) );
            $data['title']      = 'Prazo de vigência do contrato ' . $id_contrato . ' expira hoje!';
            $data['end']        = $data['start'];
            $data['id_usuario']   = $user['id_usuario'];

            if( $this->db->insert( $this->_table, $data) ) {
                return true;
            }
        }
        return false;
    }

    public function insert_via_orcamento($id_orcamento)
    {
        $user               = $this->session->userdata('contrato_user');
        $data               = array();
        $dtExpiracao        = $this->input->post('validade');
        //inserindo no calendário

        if(!empty($dtExpiracao)){

            $dt_cad             = date('Y') . '-' . date('m') . '-' . date('d');
            $data['start']      = date('Y-m-d', strtotime("+". $dtExpiracao . " days", strtotime($dt_cad)));
           // $data['start']   =  substr($this->input->post('data_vigencia_contrato') ,13,10);
            // $data['start']   =  implode( "-", array_reverse( explode( "/", $data['start'] ) ) );
            $data['title']      = 'Prazo de validade do orçamento ' . $id_orcamento . ' expira hoje!';
            $data['end']        = $data['start'];
            $data['id_usuario']   = $user['id_usuario'];

            if( $this->db->insert( $this->_table, $data) ) {
                return true;
            }
        }
        return false;
    }

    public function update()
    {
        $user = $this->session->userdata('contrato_user');
        $data = $this->input->post();

        $data['id_usuario'] = $user['id_usuario'];

        $this->db->where( 'id', $this->input->post('id') );
        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }

    public function updateLido( $id )
    {
        $user = $this->session->userdata('contrato_user');

        $data['lido']       = 't';
        $data['id_usuario']   = $user['id_usuario'];

        $this->db->where( 'id', $id );
        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }
}