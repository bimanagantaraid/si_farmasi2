<?php

class Model_satelit extends CI_Model
{
    var $column_order = array(null, 'obat.NamaObat', null, null, null, null,null,null);
    var $column_search = array('obat.NamaObat');
    var $order = array('datasatelit.IdDataSatelit' => 'asc');

    private function _get_datatables_query()
    {
        $this->db->select('obat.NamaObat, datasatelit.*');
        $this->db->from('datasatelit');
        $this->db->join('obat', 'obat.IdObat=datasatelit.IdObat','left');
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

        if (@$_POST['tanggal'] == '') {
        } else if ($_POST['tanggal']) {
            $this->db->where('datasatelit.Tanggal', $_POST['tanggal']);
        }
        if(@$_POST['IdSatelit'] == 'Satelit'){}else if($_POST['IdSatelit']){
            $this->db->where('datasatelit.IdSatelit', $_POST['IdSatelit']);
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
        $this->db->from('datasatelit');
        return $this->db->count_all_results();
    }

    function tambahData($data)
    {
        $this->db->insert('datasatelit', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function datasatelitbyID($IdDataSatelit)
    {
        $this->db->select('obat.NamaObat, datasatelit.*');
        $this->db->where('IdDataSatelit', $IdDataSatelit);
        $this->db->from('datasatelit');
        $this->db->join('obat', 'obat.IdObat=datasatelit.IdObat');
        return $this->db->get()->result_array();
    }

    function editData($data, $IdDataSatelit)
    {
        $this->db->where('IdDataSatelit', $IdDataSatelit);
        $this->db->update('datasatelit', $data);
        return $this->db->affected_rows() > 0 ? true : false;
    }

    function hapusData($IdDataSatelit)
    {
        $this->db->where('IdDataSatelit', $IdDataSatelit);
        $this->db->delete('datasatelit');
        return $this->db->affected_rows() > 0 ? true : false;
    }

    var $column_orderRekap = array(null);
    var $column_searchRekap = array('obat.NamaObat');
    var $orderRekap = array('obat.IdObat' => 'asc');

    private function _get_datatables_queryRekap($filter)
    {
        $date = explode("-", $filter);
        $bulan = $date[0];
        $tahun = $date[1];
        $satelit = $date[2];
        if ($bulan == 1 || $bulan == 0) {
            $this->db->select('
            obat.IdObat,
            obat.NamaObat,
            SUM(CASE WHEN datasatelit.Tanggal="' . ($tahun - 1) . '-12-26" THEN datasatelit.MutasiKeluar else 0 end) as duaenam,
            SUM(CASE WHEN datasatelit.Tanggal="' . ($tahun - 1) . '-12-27" THEN datasatelit.MutasiKeluar else 0 end) as duatuju,
            SUM(CASE WHEN datasatelit.Tanggal="' . ($tahun - 1) . '-12-28" THEN datasatelit.MutasiKeluar else 0 end) as dualapan,
            SUM(CASE WHEN datasatelit.Tanggal="' . ($tahun - 1) . '-12-29" THEN datasatelit.MutasiKeluar else 0 end) as duasembilan,
            SUM(CASE WHEN datasatelit.Tanggal="' . ($tahun - 1) . '-12-30" THEN datasatelit.MutasiKeluar else 0 end) as tigapuluh,
            SUM(CASE WHEN datasatelit.Tanggal="' . ($tahun - 1) . '-12-31" THEN datasatelit.MutasiKeluar else 0 end) as tigasatu,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-1" THEN datasatelit.MutasiKeluar else 0 end) as satu,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-2" THEN datasatelit.MutasiKeluar else 0 end) as dua,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-3" THEN datasatelit.MutasiKeluar else 0 end) as tiga,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-4" THEN datasatelit.MutasiKeluar else 0 end) as empat,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-5" THEN datasatelit.MutasiKeluar else 0 end) as lima,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-6" THEN datasatelit.MutasiKeluar else 0 end) as enam,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-7" THEN datasatelit.MutasiKeluar else 0 end) as tuju,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-8" THEN datasatelit.MutasiKeluar else 0 end) as delapan,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-9" THEN datasatelit.MutasiKeluar else 0 end) as sembilan,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-10" THEN datasatelit.MutasiKeluar else 0 end) as sepuluh,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-11" THEN datasatelit.MutasiKeluar else 0 end) as sebelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-12" THEN datasatelit.MutasiKeluar else 0 end) as duabelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-13" THEN datasatelit.MutasiKeluar else 0 end) as tigabelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-14" THEN datasatelit.MutasiKeluar else 0 end) as empatbelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-15" THEN datasatelit.MutasiKeluar else 0 end) as limabelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-16" THEN datasatelit.MutasiKeluar else 0 end) as enambelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-17" THEN datasatelit.MutasiKeluar else 0 end) as tujubelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-18" THEN datasatelit.MutasiKeluar else 0 end) as delapanbelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-19" THEN datasatelit.MutasiKeluar else 0 end) as sembilanbelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-20" THEN datasatelit.MutasiKeluar else 0 end) as duapuluh,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-21" THEN datasatelit.MutasiKeluar else 0 end) as duasatu,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-22" THEN datasatelit.MutasiKeluar else 0 end) as duadua,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-23" THEN datasatelit.MutasiKeluar else 0 end) as duatiga,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-24" THEN datasatelit.MutasiKeluar else 0 end) as duaempat,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-25" THEN datasatelit.MutasiKeluar else 0 end) as dualima,
            (SUM(datasatelit.EDSatelit)) as EDSatelit
            ');
        } else {
            $this->db->select('
        obat.IdObat,
        obat.NamaObat,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . ($bulan - 1) . '-26" THEN datasatelit.MutasiKeluar else 0 end) as duaenam,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . ($bulan - 1) . '-27" THEN datasatelit.MutasiKeluar else 0 end) as duatuju,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . ($bulan - 1) . '-28" THEN datasatelit.MutasiKeluar else 0 end) as dualapan,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . ($bulan - 1) . '-29" THEN datasatelit.MutasiKeluar else 0 end) as duasembilan,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . ($bulan - 1) . '-30" THEN datasatelit.MutasiKeluar else 0 end) as tigapuluh,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . ($bulan - 1) . '-31" THEN datasatelit.MutasiKeluar else 0 end) as tigasatu,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-1" THEN datasatelit.MutasiKeluar else 0 end) as satu,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-2" THEN datasatelit.MutasiKeluar else 0 end) as dua,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-3" THEN datasatelit.MutasiKeluar else 0 end) as tiga,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-4" THEN datasatelit.MutasiKeluar else 0 end) as empat,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-5" THEN datasatelit.MutasiKeluar else 0 end) as lima,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-6" THEN datasatelit.MutasiKeluar else 0 end) as enam,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-7" THEN datasatelit.MutasiKeluar else 0 end) as tuju,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-8" THEN datasatelit.MutasiKeluar else 0 end) as delapan,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-9" THEN datasatelit.MutasiKeluar else 0 end) as sembilan,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-10" THEN datasatelit.MutasiKeluar else 0 end) as sepuluh,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-11" THEN datasatelit.MutasiKeluar else 0 end) as sebelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-12" THEN datasatelit.MutasiKeluar else 0 end) as duabelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-13" THEN datasatelit.MutasiKeluar else 0 end) as tigabelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-14" THEN datasatelit.MutasiKeluar else 0 end) as empatbelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-15" THEN datasatelit.MutasiKeluar else 0 end) as limabelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-16" THEN datasatelit.MutasiKeluar else 0 end) as enambelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-17" THEN datasatelit.MutasiKeluar else 0 end) as tujubelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-18" THEN datasatelit.MutasiKeluar else 0 end) as delapanbelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-19" THEN datasatelit.MutasiKeluar else 0 end) as sembilanbelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-20" THEN datasatelit.MutasiKeluar else 0 end) as duapuluh,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-21" THEN datasatelit.MutasiKeluar else 0 end) as duasatu,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-22" THEN datasatelit.MutasiKeluar else 0 end) as duadua,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-23" THEN datasatelit.MutasiKeluar else 0 end) as duatiga,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-24" THEN datasatelit.MutasiKeluar else 0 end) as duaempat,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-25" THEN datasatelit.MutasiKeluar else 0 end) as dualima,
        (SUM(datasatelit.EDSatelit)) as EDSatelit');
        }

        $this->db->from('obat');
        $this->db->join('datasatelit', 'datasatelit.IdObat=obat.IdObat', 'left');
        $this->db->where('datasatelit.IdSatelit', $satelit);
        $this->db->group_by('obat.IdObat, obat.NamaObat');
        $i = 0;
        foreach ($this->column_searchRekap as $item) {
            if (@$_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_searchRekap) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }


        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_orderRekap[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->orderRekap)) {
            $orderRekap = $this->orderRekap;
            $this->db->order_by(key($orderRekap), $orderRekap[key($orderRekap)]);
        }
    }
    function get_datatablesRekap($filter)
    {
        $this->_get_datatables_queryRekap($filter);
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filteredRekap($filter)
    {
        $this->_get_datatables_queryRekap($filter);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_allRekap()
    {
        $this->db->from('datasatelit');
        return $this->db->count_all_results();
    }
    function getPenerimaan($filter)
    {
        $date = explode("-", $filter);
        $bulan = $date[0];
        $tahun = $date[1];
        $satelit = $date[2];
        switch ($bulan) {
            case "1":
                $bulan = "Januari";
                break;
            case "2":
                $bulan = "Februari";
                break;
            case "3":
                $bulan = "Maret";
                break;
            case "4":
                $bulan = "April";
                break;
            case "5":
                $bulan = "Mei";
                break;
            case "6":
                $bulan = "Juni";
                break;
            case "7":
                $bulan = "Juli";
                break;
            case "8":
                $bulan = "Agustus";
                break;
            case "9":
                $bulan = "September";
                break;
            case "10":
                $bulan = "Oktober";
                break;
            case "11":
                $bulan = "Nopember";
                break;
            case "12":
                $bulan = "Desember";
                break;
        }
        
        $this->db->select('SUM(CASE WHEN obatkeluargudang.IdSatelit="' . $satelit . '" THEN obatkeluargudang.JumlahObatKeluar else 0 end) as Penerimaan');
        $this->db->from('obatkeluargudang');
        $this->db->join('obat', 'obat.IdObat=obatkeluargudang.IdObat');
        $this->db->where('obatkeluargudang.BulanObatKeluar', $bulan);
        $this->db->where('obatkeluargudang.TahunObatKeluar', $tahun);
        $this->db->group_by('obat.IdObat');
        return $this->db->get()->result_array();  
    }
    
    function getObat()
    {
        return $this->db->get('obat')->result_array();
    }
    function getSatelit(){
        return $this->db->get('satelit')->result_array();
    }
    function generateInsert($data)
    {
        if ($this->generateCheck($data) != "ready") {
            $this->db->insert_batch('datasatelit', $data);
        }
    }
    function generateCheck($data)
    {
        $this->db->where('Tanggal', $data[0]['Tanggal']);
        $this->db->where('IdObat', $data[0]['IdObat']);
        $this->db->where('IdSatelit', $data[0]['IdSatelit']);
        $this->db->get('datasatelit')->result();
        if ($this->db->affected_rows() > 0) {
            return "ready";
        } else {
            return "notready";
        }
    }
    function getPemakian($filter){
        $date = explode("-", $filter);
        $bulan = $date[0];
        $tahun = $date[1];
        if ($bulan == 1 || $bulan == 0) {
            $this->db->select('
            obat.IdObat,
            obat.NamaObat,
            SUM(CASE WHEN datasatelit.Tanggal="' . ($tahun - 1) . '-12-26" THEN datasatelit.MutasiKeluar else 0 end) as duaenam,
            SUM(CASE WHEN datasatelit.Tanggal="' . ($tahun - 1) . '-12-27" THEN datasatelit.MutasiKeluar else 0 end) as duatuju,
            SUM(CASE WHEN datasatelit.Tanggal="' . ($tahun - 1) . '-12-28" THEN datasatelit.MutasiKeluar else 0 end) as dualapan,
            SUM(CASE WHEN datasatelit.Tanggal="' . ($tahun - 1) . '-12-29" THEN datasatelit.MutasiKeluar else 0 end) as duasembilan,
            SUM(CASE WHEN datasatelit.Tanggal="' . ($tahun - 1) . '-12-30" THEN datasatelit.MutasiKeluar else 0 end) as tigapuluh,
            SUM(CASE WHEN datasatelit.Tanggal="' . ($tahun - 1) . '-12-31" THEN datasatelit.MutasiKeluar else 0 end) as tigasatu,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-1" THEN datasatelit.MutasiKeluar else 0 end) as satu,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-2" THEN datasatelit.MutasiKeluar else 0 end) as dua,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-3" THEN datasatelit.MutasiKeluar else 0 end) as tiga,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-4" THEN datasatelit.MutasiKeluar else 0 end) as empat,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-5" THEN datasatelit.MutasiKeluar else 0 end) as lima,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-6" THEN datasatelit.MutasiKeluar else 0 end) as enam,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-7" THEN datasatelit.MutasiKeluar else 0 end) as tuju,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-8" THEN datasatelit.MutasiKeluar else 0 end) as delapan,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-9" THEN datasatelit.MutasiKeluar else 0 end) as sembilan,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-10" THEN datasatelit.MutasiKeluar else 0 end) as sepuluh,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-11" THEN datasatelit.MutasiKeluar else 0 end) as sebelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-12" THEN datasatelit.MutasiKeluar else 0 end) as duabelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-13" THEN datasatelit.MutasiKeluar else 0 end) as tigabelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-14" THEN datasatelit.MutasiKeluar else 0 end) as empatbelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-15" THEN datasatelit.MutasiKeluar else 0 end) as limabelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-16" THEN datasatelit.MutasiKeluar else 0 end) as enambelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-17" THEN datasatelit.MutasiKeluar else 0 end) as tujubelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-18" THEN datasatelit.MutasiKeluar else 0 end) as delapanbelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-19" THEN datasatelit.MutasiKeluar else 0 end) as sembilanbelas,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-20" THEN datasatelit.MutasiKeluar else 0 end) as duapuluh,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-21" THEN datasatelit.MutasiKeluar else 0 end) as duasatu,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-22" THEN datasatelit.MutasiKeluar else 0 end) as duadua,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-23" THEN datasatelit.MutasiKeluar else 0 end) as duatiga,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-24" THEN datasatelit.MutasiKeluar else 0 end) as duaempat,
            SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-25" THEN datasatelit.MutasiKeluar else 0 end) as dualima,
            (SUM(datasatelit.EDSatelit)) as EDSatelit
            ');
        } else {
            $this->db->select('
        obat.IdObat,
        obat.NamaObat,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . ($bulan - 1) . '-26" THEN datasatelit.MutasiKeluar else 0 end) as duaenam,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . ($bulan - 1) . '-27" THEN datasatelit.MutasiKeluar else 0 end) as duatuju,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . ($bulan - 1) . '-28" THEN datasatelit.MutasiKeluar else 0 end) as dualapan,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . ($bulan - 1) . '-29" THEN datasatelit.MutasiKeluar else 0 end) as duasembilan,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . ($bulan - 1) . '-30" THEN datasatelit.MutasiKeluar else 0 end) as tigapuluh,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . ($bulan - 1) . '-31" THEN datasatelit.MutasiKeluar else 0 end) as tigasatu,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-1" THEN datasatelit.MutasiKeluar else 0 end) as satu,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-2" THEN datasatelit.MutasiKeluar else 0 end) as dua,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-3" THEN datasatelit.MutasiKeluar else 0 end) as tiga,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-4" THEN datasatelit.MutasiKeluar else 0 end) as empat,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-5" THEN datasatelit.MutasiKeluar else 0 end) as lima,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-6" THEN datasatelit.MutasiKeluar else 0 end) as enam,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-7" THEN datasatelit.MutasiKeluar else 0 end) as tuju,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-8" THEN datasatelit.MutasiKeluar else 0 end) as delapan,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-9" THEN datasatelit.MutasiKeluar else 0 end) as sembilan,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-10" THEN datasatelit.MutasiKeluar else 0 end) as sepuluh,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-11" THEN datasatelit.MutasiKeluar else 0 end) as sebelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-12" THEN datasatelit.MutasiKeluar else 0 end) as duabelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-13" THEN datasatelit.MutasiKeluar else 0 end) as tigabelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-14" THEN datasatelit.MutasiKeluar else 0 end) as empatbelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-15" THEN datasatelit.MutasiKeluar else 0 end) as limabelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-16" THEN datasatelit.MutasiKeluar else 0 end) as enambelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-17" THEN datasatelit.MutasiKeluar else 0 end) as tujubelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-18" THEN datasatelit.MutasiKeluar else 0 end) as delapanbelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-19" THEN datasatelit.MutasiKeluar else 0 end) as sembilanbelas,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-20" THEN datasatelit.MutasiKeluar else 0 end) as duapuluh,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-21" THEN datasatelit.MutasiKeluar else 0 end) as duasatu,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-22" THEN datasatelit.MutasiKeluar else 0 end) as duadua,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-23" THEN datasatelit.MutasiKeluar else 0 end) as duatiga,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-24" THEN datasatelit.MutasiKeluar else 0 end) as duaempat,
        SUM(CASE WHEN datasatelit.Tanggal="' . $tahun . '-' . $bulan . '-25" THEN datasatelit.MutasiKeluar else 0 end) as dualima,
        (SUM(datasatelit.EDSatelit)) as EDSatelit');
        }

        $this->db->from('obat');
        $this->db->join('datasatelit', 'datasatelit.IdObat=obat.IdObat');
        $this->db->group_by('obat.IdObat, obat.NamaObat');
        return $this->db->get()->result();
    }
    var $column_ordersatelitrekap = array(null, 'obat.NamaObat', null, null, null, null,null,null);
    var $column_searchsatelitrekap = array('obat.NamaObat');
    var $ordersatelitrekap = array('obat.IdObat' => 'asc');
    function getsatelitrekap(){
        $this->db->select(
            'obat.NamaObat,
            SUM(CASE WHEN satelitrekap.Bulan="Januari" THEN satelitrekap.Total else 0 end) as Januari,
            SUM(CASE WHEN satelitrekap.Bulan="Februari" THEN satelitrekap.Total else 0 end) as Februari,
            SUM(CASE WHEN satelitrekap.Bulan="Maret" THEN satelitrekap.Total else 0 end) as Maret,
            SUM(CASE WHEN satelitrekap.Bulan="April" THEN satelitrekap.Total else 0 end) as April,
            SUM(CASE WHEN satelitrekap.Bulan="Mei" THEN satelitrekap.Total else 0 end) as Mei,
            SUM(CASE WHEN satelitrekap.Bulan="Juni" THEN satelitrekap.Total else 0 end) as Juni,
            SUM(CASE WHEN satelitrekap.Bulan="Juli" THEN satelitrekap.Total else 0 end) as Juli,
            SUM(CASE WHEN satelitrekap.Bulan="Agustus" THEN satelitrekap.Total else 0 end) as Agustus,
            SUM(CASE WHEN satelitrekap.Bulan="September" THEN satelitrekap.Total else 0 end) as September,
            SUM(CASE WHEN satelitrekap.Bulan="Oktober" THEN satelitrekap.Total else 0 end) as Oktober,
            SUM(CASE WHEN satelitrekap.Bulan="November" THEN satelitrekap.Total else 0 end) as November,
            SUM(CASE WHEN satelitrekap.Bulan="Desember" THEN satelitrekap.Total else 0 end) as Desember,
            SUM(CASE WHEN satelitrekap.Bulan="Januari" THEN satelitrekap.ED else 0 end) as JanuariED,
            SUM(CASE WHEN satelitrekap.Bulan="Februari" THEN satelitrekap.ED else 0 end) as FebruariED,
            SUM(CASE WHEN satelitrekap.Bulan="Maret" THEN satelitrekap.ED else 0 end) as MaretED,
            SUM(CASE WHEN satelitrekap.Bulan="April" THEN satelitrekap.ED else 0 end) as AprilED,
            SUM(CASE WHEN satelitrekap.Bulan="Mei" THEN satelitrekap.ED else 0 end) as MeiED,
            SUM(CASE WHEN satelitrekap.Bulan="Juni" THEN satelitrekap.ED else 0 end) as JuniED,
            SUM(CASE WHEN satelitrekap.Bulan="Juli" THEN satelitrekap.ED else 0 end) as JuliED,
            SUM(CASE WHEN satelitrekap.Bulan="Agustus" THEN satelitrekap.ED else 0 end) as AgustusED,
            SUM(CASE WHEN satelitrekap.Bulan="September" THEN satelitrekap.ED else 0 end) as SeptemberED,
            SUM(CASE WHEN satelitrekap.Bulan="Oktober" THEN satelitrekap.ED else 0 end) as OktoberED,
            SUM(CASE WHEN satelitrekap.Bulan="November" THEN satelitrekap.ED else 0 end) as NovemberED,
            SUM(CASE WHEN satelitrekap.Bulan="Desember" THEN satelitrekap.ED else 0 end) as DesemberED'
        );
        $this->db->from('satelitrekap');
        $this->db->join('obat','obat.IdObat=satelitrekap.IdObat');
        $this->db->group_by('obat.IdObat');
        if (@$_POST['tanggal'] == '') {
        } else if ($_POST['tanggal']) {
            //$this->db->where('datasatelit.Tanggal', $_POST['tanggal']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_ordersatelitrekap[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->ordersatelitrekap)) {
            $ordersatelitrekap = $this->ordersatelitrekap;
            $this->db->order_by(key($ordersatelitrekap), $ordersatelitrekap[key($ordersatelitrekap)]);
        }
    }
    function get_datatablessatelitrekap()
    {
        $this->getsatelitrekap();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filteredsatelitrekap()
    {
        $this->getsatelitrekap();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_allsatelitrekap()
    {
        $this->db->from('satelitrekap');
        return $this->db->count_all_results();
    }


}
