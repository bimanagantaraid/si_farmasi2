<?php

class Model_pivot extends CI_Model{

    var $column_order = array(); 
        var $column_search = array(); 
        var $order = array('obat.IdObat' => 'asc'); 
    
        private function _get_datatables_query() {
            $this->db->select('obat.NamaObat, obatmasukgudang.IdObatMasuk,
            SUM(CASE WHEN obatmasukgudang.BulanMasuk = "Januari" THEN obatmasukgudang.Dinkes else NULL end) AS JanuariDinkes,
            SUM(CASE WHEN obatmasukgudang.BulanMasuk = "Januari" THEN obatmasukgudang.Blud else NULL end) AS JanuariBlud, 
            SUM(CASE WHEN obatmasukgudang.BulanMasuk = "Februari" THEN obatmasukgudang.Dinkes else NULL end) AS FebruariDinkes, 
            SUM(CASE WHEN obatmasukgudang.BulanMasuk = "Februari" THEN obatmasukgudang.Blud else NULL end) AS FebruariBlud,
            (SUM(obatmasukgudang.Blud)+SUM(obatmasukgudang.Dinkes)) AS Total');
            $this->db->from('obatmasukgudang');
            $this->db->join('obat','obat.IdObat=obatmasukgudang.IdObat');
            $this->db->group_by('obat.NamaObat');
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
        function get_datatables() {
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
            $this->db->from('obatmasukgudang');
            return $this->db->count_all_results();
        }
}