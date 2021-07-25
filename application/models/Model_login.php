<?php

    class Model_login extends CI_Model{
        function can_login($username, $password){
            $this->db->where('username', $username);
            $this->db->where('password', $password);
            $data = $this->db->get('user')->result_array();
            if($this->db->affected_rows() > 0){
                $valid = array(
                    'status'    => 'found',
                    'data'      => $data
                );
                return $valid;
            }else{
                $valid = array(
                    'status'    => 'notfound',
                    'data'      => $data
                );
                return $valid;
            }
        }
        function count(){
            return $this->db->count_all('user');
        }
    }