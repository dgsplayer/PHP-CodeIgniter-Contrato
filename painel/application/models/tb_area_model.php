<?php

class Tb_area_model extends CI_Model {

	private $_table = "tb_area";

    /**
     * Get product by his is
     * @param int $product_id
     * @return array
     */
    public function row($id)
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('id_area', $id);
        $query = $this->db->get();
        if( $query->num_rows > 0 ) {
            return $query->row();
        }
        return false;

//        return $query->result_array();
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
    public function rows($search_string = null, $order = null, $order_type = 'Asc', $limit_start = null, $limit_end = null)
    {

        $this->db->select('*');
        $this->db->from($this->_table);

        $this->db->group_by('id_area');
        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('id_area', $order_type);
        }
        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }
        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }

        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_($search_string = null, $order = null)
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        if ($search_string) {
            $this->db->like('name', $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('id_area', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function insert($data)
    {
        $insert = $this->db->insert($this->_table, $data);
        return $insert;
    }

    /**
     * Update manufacture
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->_table, $data);
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
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->_table);

        $this->db->where('id_grupo', $id);
        $this->db->delete('tb_grupos_x_cliente');

    }
}