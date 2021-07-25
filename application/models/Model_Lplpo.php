<?php 

    class Model_Lplpo extends CI_Model{
        //section datatables
        var $column_order = array(); 
        var $column_search = array(); 
        var $order = array('obat.IdObat' => 'asc'); 
        private function _get_datatables_query(){
            $this->db->select('lplpo.*, obat.NamaObat');
            $this->db->from('lplpo');
            $this->db->join('obat', 'lplpo.IdObat=obat.IdObat');
            $i = 0;
            foreach ($this->column_search as $item) {
                if(@$_POST['search']['value']) { 
                    if($i===0) {
                        $this->db->group_start();
                        $this->db->like($item, $_POST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                    if(count($this->column_search) - 1 == $i) 
                        $this->db->group_end();
                }
                $i++;
            }
            if(isset($_POST['order'])) { 
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            }  else if(isset($this->order)) {
                $order = $this->order;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
        function getDataLplpo() {
            $this->_get_datatables_query();
            if(@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
        function count_filtered() {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
        function count_all() {
            $this->db->from('obatkeluargudang');
            return $this->db->count_all_results();
        }
    }