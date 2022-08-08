<?php

class Tb_contratos_design_model extends CI_Model {

    private $_table = "tb_contratos_design";

    public function fetch_row()
    {
        $user = $this->session->userdata('contrato_user');
        $this->db->where('id_pessoa_pai', $user["id_pessoa"] );

        $q = $this->db->get( $this->_table );
        if( $q->num_rows > 0 ) {
            return $q->row();
        }
        return false;
    }

    public function update()
    {
        $user           = $this->session->userdata('contrato_user');
        $data           = $this->input->post();

        if (!empty($_FILES)) {

            $this->load->helper('funcoes');

            $upload_path = BASEPATH . '../recursos/logomarcas/';

            if(!is_dir($upload_path))
                mkdir($upload_path, 0777);

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|png';
            $config['max_size']     = '2048'; //2MB
            $config['max_width']     = '1024';
            $config['max_height']     = '768';
            $targetFile = time() . $_FILES["file"]["name"];
            $targetFile = retira_acentos($targetFile);

            $config['file_name'] = $targetFile;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')) {

                $this->session->set_flashdata('error', $this->upload->display_errors());

            } else {

                        $upload_data = $this->upload->data();
                        $file_name =   $upload_data['file_name'];
////
//                        $data = array();
                        $data['file'] = $file_name;
                        $header = '<p style="text-align: center;"><strong><span style="color: #333399;"><img src="http://www.contratonet.com.br/painel/recursos/logomarcas/' . $file_name . '" alt="" width="200" height="50" /></span></strong></p>';

//                        $this->tb_clientes_model->update($this->session->userdata('id_cliente') , $data);
//
//                        $this->session->set_flashdata('sucesso', 'Logo atualizado com sucesso!');
            }
        }

        if($data['botao_gravar'] == 'Voltar ao Padrão'){
            $data['cor_topo']           = '#333333';
            $data['cor_topo_fonte']     = '#ffffff';
            $data['cor_quadro']         = '#ffffff';
            $data['cor_quadro_fonte']   = '#000000';
            $data['cor_clausula']       = '#dddddd';
            $data['cor_clausula_fonte'] = '#000000';
            $data['cor_fundo']          = '#ffffff';
        }

        $data['header']          = @$header . $data['header'];

        unset($data['botao_gravar']);

        $this->db->where( 'id_pessoa_pai', $user['id_pessoa'] );
        if( $this->db->update( $this->_table, $data ) ) {
            return true;
        }
        return false;
    }

}