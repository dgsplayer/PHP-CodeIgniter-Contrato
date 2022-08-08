<?php

class Crud_model extends CI_Model
{

    /**
     * Call table
     * @var string
     */
//    private $_table = "tb_contatos";

    /**
     * Responsable for auto load the database
     * @return void
     */
//    public function __construct()
//    {
//        $this->load->database();
//    }
    /**
     * Get product by his is
     * @param int $product_id
     * @return array
     */
    public function row($table, $search_string)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($search_string);
        $query = $this->db->get();
        if( $query->num_rows > 0 ) {
            return $query->row();
        }
        return false;
    }

    /**
     * Fetch all data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function rows($table, $search_string = null, $order = null, $order_type = 'Asc', $limit_start = null, $limit_end = null, $fields = null, $group_by = null)
    {


        if ($fields) {
            $this->db->select($fields);
        }else{
            $this->db->select('*');
        }

        $this->db->from($table);
        if ($search_string) {
            $this->db->where($search_string);
        }
//        $this->db->group_by('id');
        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('id', $order_type);
        }
        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }
        if ($group_by) {
            $this->db->group_by($group_by);
        }

        $query = $this->db->get();

        return $query->result();
    }

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_($table, $search_string = null, $order = null)
    {
        $this->db->select('*');
        $this->db->from($table);
        if ($search_string) {
            $this->db->like($search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function insert($table, $data)
    {
        $insert = $this->db->insert($table, $data);
        return $insert;
    }

    /**
     * Update manufacture
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update($table, $id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete 
     * @param int $id - manufacture id
     * @return boolean
     */
    function delete($table, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

    //atualiza data de acesso do log
    public function do_update_data_acesso(){
        //  $date = new DateTime();
        //$date->format('Y-m-d H:i:s')
        $this->db->update('tb_usuarios',array('ativo' => 'Sim'), 'id_usuario = ' . $this->session->userdata("id_usuario"));
    }

    public function do_insert($tabela=NULL,$dados=NULL,$redirect=NULL){
        if($dados!=NULL && $tabela!=NULL){
            $this->db->insert($tabela,$dados);
            $id_return = $this->db->insert_id();

            $this->session->set_flashdata('cadastro_ok','Registrado com sucesso');
//            if($redirect==NULL){
//                redirect(current_url());
//            }
            return $id_return;
        }else{

            return false;
        }
    }

    //atualiza dados
    public function do_update($table=NULL,$dados=NULL, $condicao=NULL,$redirect=NULL){
        if($condicao!=NULL && $dados!=NULL && $table!=NULL){
            $this->db->update($table,$dados, $condicao);
            $this->session->set_flashdata('cadastro_ok','Atualizado com sucesso');
            if($redirect!=NULL){
                redirect($redirect);
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //atualiza todos os dados
    public function do_update_all($table=NULL,$dados=NULL, $condicao=NULL,$redirect=NULL){
        if($dados!=NULL && $table!=NULL){
            $this->db->update($table,$dados, $condicao);

        }else{
            return false;
        }
    }

    //deleta dados
    public function do_delete($table=NULL,$condicao=NULL,$redirect=NULL){
        if($condicao!=NULL && $table!=NULL){
            $this->db->delete($table, $condicao);
            $this->session->set_flashdata('cadastro_ok','Excluído com sucesso');
            if($redirect!=NULL){
                redirect($redirect);
            }else{
                redirect(current_url());
            }

        }else{
            return false;
        }
    }
    //resgata todos os dados
    public function get_all($table=NULL,$orderby=NULL){
        if($table!=NULL){
            if($orderby!=NULL){
                $this->db->order_by($orderby);
            }
            //var_dump($this->db->get($table));
            return $this->db->get($table);
        }else{
            return false;
        }
    }

    //resgata todos os dados com join
    public function get_all_join($table=NULL,$table2=NULL,$whereon=NULL,$orderby=NULL,$fields=NULL,$table3=NULL,$whereon3=NULL){
        if($table!=NULL && $table2!=NULL){
            if($fields!=NULL){
                $campos = $fields;
            }else{
                $campos = '*';
            }
            if($orderby!=NULL){
                $this->db->order_by($orderby);
            }
            $this->db->select($campos);
            $this->db->distinct($campos);

            $this->db->from($table);
            $this->db->join($table2, $whereon);
            if($table3!=NULL){
                $this->db->join($table3, $whereon3);
            }
            return $this->db->get();
        }else{
            return false;
        }
    }

    //resgata dados por ID
    public function get_by_id($table=NULL,$id=NULL,$field=NULL){
        if($table!=NULL && $id!=NULL){
            if($field!=NULL){
                $campo =  $field;
            }else{
                $campo =  'id';
            }
            $this->db->where($campo , $id);

            $this->db->limit(1);
            return $this->db->get($table)->row();
        }else{
            return false;
        }
    }

    //resgata dados por qualquer coisa
    public function get_by_something($table=NULL,$field=NULL, $where=NULL, $orderby=NULL){
        if($table!=NULL){
            if($field!=NULL){
                $campo =  $field;
            }else{
                $campo =  '*';
            }
            if($where!=NULL)
                $this->db->where($where);

            if($orderby!=NULL){
                $this->db->order_by($orderby);
            }
            return $this->db->get($table)->result();
        }else{
            return false;
        }
    }

    //resgata dados por ID do usuario logado
    public function get_by_dados_empresa(){

        $this->db->where('id' , $this->session->userdata("id_cliente"));

        return $this->db->get('tb_cliente')->result();
    }



    //resgata login
    public function get_tb_usuarios_x_tb_cliente_by_id($id_cliente=NULL){
        if($id_cliente!=NULL){

            $this->db->select('tb_cliente.*, tb_usuarios.email, tb_usuarios.password, tb_usuarios.ativo');
            $this->db->from('tb_cliente');
            $this->db->join('tb_usuarios',   'tb_cliente.id = tb_usuarios.id_cliente');
            $this->db->where('tb_cliente.id' , $id_cliente);

            return $this->db->get()->result();
        }else{
            return false;
        }
    }

    //resgata todos os dados com join
    public function get_all_logs($verTodas=NULL){

        $this->db->select('*, tb_usuarios.nome as nome_admin, tb_usuarios.email as email_admin');

        $this->db->from('tb_logacao');
        //if($this->session->userdata("id_cliente") != '1'){
        //$this->db->where('tb_usuarios.id_cliente' , $this->session->userdata("id_cliente"));
        //}
        $this->db->where('tb_logacao.id_usuario' , $this->session->userdata("id_usuario"));
        if($verTodas == NULL)
            $this->db->where('tb_logacao.lido' , 'f');

        $this->db->join('tb_usuarios',     'tb_usuarios.id = tb_logacao.id_usuario');
        $this->db->join('tb_cliente',   'tb_cliente.id = tb_logacao.para_id_cliente');
        $this->db->order_by('tb_logacao.id', 'DESC');

        return $this->db->get();
    }

    //grava logs para cada usuario HZI e cada usuario do Cliente
    public function do_insert_log($dados=NULL){
        if($dados!=NULL){
            $dados['ip'] = $_SERVER['SERVER_ADDR'];

            $sessionIdAdmin = $this->session->userdata("id_usuario");
            if(!empty($sessionIdAdmin))
                $dados["de_id_usuario"]   = $this->session->userdata("id_usuario");

            $sessionIdCliente = $this->session->userdata("id_cliente");
            if(empty($dados["para_id_cliente"])){
                if(!empty($sessionIdCliente))
                    $dados["para_id_cliente"]   = $this->session->userdata("id_cliente");
            }

            $this->db->select('tb_usuarios.id');
            $this->db->from('tb_usuarios');
            $this->db->where('tb_usuarios.id_cliente = 1 OR tb_usuarios.id_cliente = ' . $this->session->userdata("id_cliente"));
            $listaAdmins = $this->db->get()->result();

            if(!empty($listaAdmins)){
                foreach($listaAdmins as $value){
                    $dados['id_usuario'] = $value->id;
                    $this->db->insert('tb_logacao',$dados);

                }
            }



        }else{
            return false;
        }
    }


}

?>