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

    public function get_all($table, $where = "", $sort = '', $select = '*', $group_by = '') {
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

            return $this->db->get();
        }
    }

    public function authenticate($username, $password) {
        $this->db->select()->from(USERS)->where(array('emp_code' => $username, 'password' => $password));
        return $this->db->get();
    }

    public function simple_insert($table, $insert_arr) {
        return $this->db->insert($table, $insert_arr);
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