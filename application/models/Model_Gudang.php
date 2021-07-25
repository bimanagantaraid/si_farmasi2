<?php

class Model_Gudang extends CI_Model
{
    var $column_order = array('gudang.IdGudang', null, null, null, null, 'gudang.BulanGudang', 'gudang.TahunGudang', null);
    var $column_search = array('obat.NamaObat');
    var $order = array('obat.IdObat' => 'asc');

    private function _get_datatables_query()
    {
        $this->db->select('gudang.*, obat.NamaObat');
        $this->db->from('gudang');
        $this->db->join('obat', 'gudang.IdObat=obat.IdObat');
        $i = 0;
        foreach ($this->column_search as $item) {
            if (@$_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        $this->_get_datatables_query();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all()
    {
        $this->db->from('obatkeluargudang');
        return $this->db->count_all_results();
    }

    //section data obat
    function getObat(){
        return $this->db->get('obat')->result_array();
    }

    //section data penerimaan obat
    function getPenerimaan($Bulan){
        $query = 'select obat.NamaObat, 
        (SUM(obatmasukgudang.Dinkes)+SUM(obatmasukgudang.Blud)) as Penerimaan
        from obat join obatmasukgudang on obat.IdObat=obatmasukgudang.IdObat where obatmasukgudang.BulanMasuk="'.$Bulan.'" and obatmasukgudang.TahunMasuk=2021 group by obat.IdObat';
        return $this->db->query($query)->result();
    }

    //section data stok obat
    function getStok(){
        
    }
    function getDistribusi($Bulan){
        $query = 'select
        SUM(CASE WHEN obatkeluargudang.BulanObatKeluar="'.$Bulan.'" THEN obatkeluargudang.JumlahObatKeluar else NULL end) as Distribusi,
        SUM(CASE WHEN obatkeluargudang.BulanObatKeluar="'.$Bulan.'" THEN obatkeluargudang.ED else NULL end) as ED
        from obat
        join obatkeluargudang on obatkeluargudang.IdObat=obat.IdObat
        group by obat.NamaObat;';
        return $this->db->query($query)->result();
    }
    function getED(){}

    //section insert generate data gudang
    function insertGenerate($data){
        $this->db->insert('gudang', $data);
        return $this->db->affected_rows()>0 ? true:false;
    }

    function updateData(){

    }
}
