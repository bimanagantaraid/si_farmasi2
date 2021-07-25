<?php

    class Model_obatmasukgudang extends CI_Model{
        var $column_order = array('obatmasukgudang.IdObatMasuk', 'obat.NamaObat', 'obatmasukgudang.Dinkes', 'obatmasukgudang.Blud','obatmasukgudang.BulanMasuk'); 
        var $column_search = array('obat.NamaObat', 'SatuanObat'); 
        var $order = array('obatmasukgudang.IdObatMasuk' => 'asc'); 
    
        private function _get_datatables_query() {
            $this->db->select('obat.IdObat, obat.NamaObat, obat.IdObat, obatmasukgudang.*');
            $this->db->from('obatmasukgudang');
            $this->db->join('obat', 'obatmasukgudang.IdObat=obat.IdObat');
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

            //filter bulan masuk
            if(@$_POST['BulanMasuk']=='Bulan'){

            }else if($_POST['BulanMasuk']!='Bulan'){
                $this->db->where('obatmasukgudang.BulanMasuk', $_POST['BulanMasuk']);
            }

            //filter tahun masuk
            if(@$_POST['TahunMasuk']=='Tahun'){

            }else if($_POST['TahunMasuk']!='Tahun'){
                $this->db->where('obatmasukgudang.TahunMasuk', $_POST['TahunMasuk']);
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

        //generate data obat masuk perbulan
        function generateOMG($dataGenerate){
            $dataobat = $this->db->get('obat')->result_array();
            foreach($dataobat as $obat){
                $data = [
                    'IdObatMasuk'       => '',
                    'Dinkes'            => $dataGenerate['Dinkes'],
                    'Blud'              => $dataGenerate['Blud'],
                    'BulanMasuk'        => $dataGenerate['BulanMasuk'],
                    'TahunMasuk'        => $dataGenerate['TahunMasuk'],
                    'IdObat'            => $obat['IdObat']
                ];
                if($this->checkingDataObatOMG($data) === true){
                    
                }else{
                    $this->db->insert('obatmasukgudang', $data);
                }
            }
            return true;
        }

        //validation generate data obat masuk
        function checkingDataObatOMG($dataGenerate){
            $this->db->where('BulanMasuk', $dataGenerate['BulanMasuk']);
            $this->db->where('TahunMasuk', $dataGenerate['TahunMasuk']);
            $this->db->where('IdObat', $dataGenerate['IdObat']);
            $this->db->get('obatmasukgudang');
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        //validation data sudah ada apa belum 
        function checkingDataOMG($data){
            $this->db->where('BulanMasuk', $data['BulanMasuk']);
            $this->db->where('TahunMasuk', $data['TahunMasuk']);
            $this->db->where('IdObat', $data['IdObat']);
            $this->db->get('obatmasukgudang');
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        //get data obat masuk gudang by id
        function getObatMasukGudangById($IdObatMasuk){
            $this->db->where('IdObatMasuk', $IdObatMasuk);
            $this->db->from('obatmasukgudang');
            $this->db->join('obat', 'obatmasukgudang.IdObat=obat.IdObat');
            return $this->db->get()->result_array();
        }

        //insert data obat masuk gudang
        function insertOMG($data){
            $dataOMG = $this->checkingDataOMG($data);
            if($dataOMG == 1){
                return 'duplicated';
            }else{
                $this->db->insert('obatmasukgudang', $data);
                return ($this->db->affected_rows() > 0) ? true:false;
            }
        }

        //update data obat masuk gudang
        function updateOMG($whereData, $valueData){
            $this->db->set('Dinkes' , $valueData['Dinkes']);
            $this->db->set('Blud', $valueData['Blud']);
            $this->db->set('BulanMasuk', $valueData['BulanMasuk']);
            $this->db->set('TahunMasuk', $valueData['TahunMasuk']);
            $this->db->where('IdObatMasuk', $whereData['IdObatMasuk']);
            $this->db->where('IdObat', $whereData['IdObat']);
            $this->db->update('obatmasukgudang');
            if($this->db->affected_rows() > 0 ){
                return true;
            }else{
                return false;
            }
        }

        //delete data obat masuk gudang
        function deleteOMG($whereData){
            $this->db->where('IdObatMasuk', $whereData);
            $this->db->delete('obatmasukgudang');
            if($this->db->affected_rows() > 0 ){
                return true;
            }else{
                return false;
            }
        }

        //export data obat masuk gudang ke excel
        function getObat(){
            return $this->db->get('obat')->result_array();
        }
        function getAllOMG(){
            $this->db->select('obat.*, obatmasukgudang.*');
            $this->db->from('obatmasukgudang');
            $this->db->join('obat', 'obatmasukgudang.IdObat=obat.IdObat');
            $this->db->where('obatmasukgudang.TahunMasuk', 2021);
            return $this->db->get()->result_array();
        }
    }

?>