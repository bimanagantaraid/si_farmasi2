<?php

    class model_obatkeluargudang extends CI_Model{
        var $column_order = array(null, 'obat.NamaObat', 'obatkeluargudang.JumlahObatKeluar', 'satelit.NamaSatelit', 'obatkeluargudang.BulanObatKeluar', 'obatkeluargudang.TahunObatKeluar'); 
        var $column_search = array('obat.NamaObat', 'satelit.NamaSatelit'); 
        var $order = array('obat.IdObat' => 'asc'); 
    
        private function _get_datatables_query() {
            $this->db->select('obat.NamaObat, satelit.NamaSatelit, obatkeluargudang.*');
            $this->db->from('obatkeluargudang');
            $this->db->join('satelit', 'satelit.IdSatelit=obatkeluargudang.IdSatelit');
            $this->db->join('obat', 'obat.IdObat=obatkeluargudang.IdObat');
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
            if(@$_POST['BulanKeluar']=='Bulan'){

            }else if($_POST['BulanKeluar']!='Bulan'){
                $this->db->where('obatkeluargudang.BulanObatKeluar', $_POST['BulanKeluar']);
            }

            //filter tahun masuk
            if(@$_POST['TahunKeluar']=='Tahun'){

            }else if($_POST['TahunKeluar']!='Tahun'){
                $this->db->where('obatkeluargudang.TahunObatKeluar', $_POST['TahunKeluar']);
            }
            
            if(@$_POST['IdSatelit']=='Satelit'){
            
            }else if($_POST['IdSatelit']!='Satelit'){
                $this->db->where('obatkeluargudang.IdSatelit', $_POST['IdSatelit']);
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
            $this->db->from('obatkeluargudang');
            return $this->db->count_all_results();
        }

        //get data obat
        function getObat(){
            return $this->db->get('obat')->result_array();
        }

        //get data satelit
        function getSatelit(){
            return $this->db->get('satelit')->result_array();
        }

        //generate obat keluar ke satelit
        function generateData($DataGenerateObatKeluarSatelit){
            $ValidationDataGenerate = $this->validationDataReady($DataGenerateObatKeluarSatelit);
            if($ValidationDataGenerate === 'notready'){
                $this->db->insert('obatkeluargudang', $DataGenerateObatKeluarSatelit);
                if($this->db->affected_rows() > 0){
                    return 'sukses';
                }else{
                    return 'false';
                }
            }else{
                return 'data sudah tersedia';
            }
        }


        //section insert data
        function insertOKG($data){
            $validationData = $this->validationDataReady($data);
            if($validationData === 'notready'){
                $this->db->insert('obatkeluargudang', $data);
                if($this->db->affected_rows() > 0){
                    return 'sukses';
                }else{
                    return 'gagal';
                }
            }else if($validationData=== 'ready'){
                return 'data sudah tersedia';
            }
        }

        //section validasi data sudah ada di DB
        function validationDataReady($data){
            $this->db->where('IdSatelit', $data['IdSatelit']);
            $this->db->where('IdObat', $data['IdObat']);
            $this->db->where('BulanObatKeluar', $data['BulanObatKeluar']);
            $this->db->where('TahunObatKeluar', $data['TahunObatKeluar']);
            $this->db->get('obatkeluargudang')->result();
            if($this->db->affected_rows() > 0){
                return 'ready';
            }else{
                return 'notready';
            }
        }

        //section delete data
        function deleteOKG($IdObatKeluar){
            $this->db->where('IdObatKeluar', $IdObatKeluar);
            $this->db->delete('obatkeluargudang');
            return ($this->db->affected_rows() > 0 ) ? true:false;
        }

        //section update data
        function getDataObatKeluarById($IdObatKeluar){
            $this->db->select('*');
            $this->db->from('obatkeluargudang');
            $this->db->join('obat', 'obat.IdObat=obatkeluargudang.IdObat');
            $this->db->where('obatkeluargudang.IdObatKeluar', $IdObatKeluar);
            return $this->db->get()->result_array();
        }

        function updateOKG($where, $dataOKG){
            $this->db->update('obatkeluargudang', $dataOKG, $where);
            return $this->db->affected_rows() > 0 ? true:false;
        }

        //section export to excel
        function getAllOKG(){
            $this->db->where('TahunObatKeluar', 2021);
            return $this->db->get('obatkeluargudang')->result_array();

        }

    }


?>