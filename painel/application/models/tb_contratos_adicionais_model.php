<?php

class Tb_contratos_adicionais_model extends CI_Model {

    private $_table = "tb_contratos_adicionais";

    public function fetch_result($id)
    {
        $data = array();

        $this->db->select('*');
        $this->db->where('id_contrato' , $id);
        $this->db->order_by('id_adicional', 'DESC');

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->result();
        }
        return $data;
    }

    public function fetch_row( $id )
    {
        $this->db->where('id_adicional' , $id);

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return false;
    }

    public function insert()
    {

        if(count($this->input->post('texto')) == 1)
        {$texto = $this->input->post('texto'); $texto = $texto[0]; } else  $texto = implode(' - ',$this->input->post('texto'));
        if(count($this->input->post('valueAditivo')) == 1)
        {$valueAditivo = $this->input->post('valueAditivo'); $valueAditivo = $valueAditivo[0];} else  $valueAditivo = implode(' e ',$this->input->post('valueAditivo'));

        $data = array(
            'id_contrato'   => $this->input->post('id_contrato'),
            'texto'         => $texto,
            'valueAditivo'  => $valueAditivo
        );

        if( $this->db->insert( $this->_table, $data) ) {
            //Grava Log
            $this->load->model('tb_logs_model');
            $this->tb_logs_model->insert_history('Inseriu aditivo no contrato' . $this->input->post('id_contrato'));

            return true;
        }
        return false;
    }

    public function update()
    {
        $user = $this->session->userdata('contrato_user');
        $data = $this->input->post();

        $data['id_pessoa_pai'] = $user['id_pessoa'];

        $this->db->where( 'id_adicional', $this->input->post('id_adicional') );
        if( $this->db->update( $this->_table, $data ) ) {

            return true;
        }
        return false;
    }
}