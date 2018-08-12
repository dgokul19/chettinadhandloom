<?php

class App_model extends CI_Model
{
     public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
    }

    public function simple_update($table, $update_arr, $where) {
        $this->db->where($where);
        $sql = $this->db->update($table, $update_arr);
        if ($sql) {
            return true;
        } else {
//                    return $this->db->_error_message();
            return $this->db->error();
        }
    }

    public function get_all($table, $where = "", $sort = '', $select = '*', $group_by = '', $limit = '', $offset = '') {
        if ($where == "") {
            $this->db->select($select)->from($table);
            if (!empty($sort)) {
                foreach ($sort as $key => $value) {
                    $this->db->order_by($key, $value);
                }
            }
            if (!empty($group_by)) {
                $this->db->group_by($group_by);
            }

            return $this->db->get();
        } else {
            $this->db->select($select)->from($table)->where($where);
            if (!empty($sort)) {
                foreach ($sort as $key => $value) {
                    $this->db->order_by($key, $value);
                }
            }
            if (!empty($group_by)) {
                $this->db->group_by($group_by);
            }
            if (!empty($limit)) {
                if(!empty($offset)){
                    /*
                    The SQL query below says "return only 10 records, start on record 16 (OFFSET 15)":
                    $sql = "SELECT * FROM Orders LIMIT 15, 10";
                    */
                    $this->db->limit($limit,$offset); //The second parameter to LIMIT is not an offset, it's a length relative to the offset. So if you want 9 rows, it would be LIMIT 48, 9.
                }else{
                    $this->db->limit($limit);
                }
            }

            $exe = $this->db->get();
            if($exe){
                return $exe;
            }else{
                echo json_encode(['status'=>"failed",'error'=>$this->db->error()]);die;
            }
        }
    }

    public function simple_insert($table, $insert_arr) {
        return $this->db->insert($table, $insert_arr);
    }
    
    public function insert_if_not_exist($table,$insert_arr,$where){
        $temp_key = array_keys($insert_arr);
        $temp_val = array_values($insert_arr);
        $fields = "";
        foreach($temp_key as $keys){
            $fields .= "'$keys', ";
        }
        $field_values = "";
        foreach($temp_val as $val){
            $field_values .= "'$val', ";
        }
        
        $temp2 = array_keys($where);
        $sql = "INSERT INTO $table ($fields)"
                . "SELECT * FROM (SELECT $field_values) AS tmp"
                . "WHERE NOT EXISTS ("
                . "SELECT name FROM $table WHERE name = 'Rupert'"
                .") LIMIT 1;';";
    }

    public function simple_delete($table, $delarr) {
        return $this->db->delete($table, $delarr);
    }

    public function encode($val) {
        $tmp = $this->encrypt->encode($val);
        return str_replace(array('+', '/', '='), array('-', '_', '~'), $tmp);
    }

    public function decode($val) {
        $encrypted_string2 = str_replace(array('-', '_', '~'), array('+', '/', '='), $val);
        return $this->encrypt->decode($encrypted_string2);
    }

    public function ExecuteQuery($QueryStatement) {
        return $this->db->query($QueryStatement);
    }
    
    public function get_all_or_where($table, $where = "", $sort = '', $select = '*', $group_by = ''){
        if ($where == "") {
            $this->db->select($select)->from($table);
            if (!empty($sort)) {
                foreach ($sort as $key => $value) {
                    $this->db->order_by($key, $value);
                }
            }
            if (!empty($group_by)) {
                $this->db->group_by($group_by);
            }

            return $this->db->get();
        } else {
            $this->db->select($select)->from($table)->or_where($where);
            if (!empty($sort)) {
                foreach ($sort as $key => $value) {
                    $this->db->order_by($key, $value);
                }
            }
            if (!empty($group_by)) {
                $this->db->group_by($group_by);
            }

            return $this->db->get();
        }
    }
    

}