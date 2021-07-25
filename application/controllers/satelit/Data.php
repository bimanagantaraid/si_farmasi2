<?php
defined('BASEPATH') or exit('script not allowes');
class Data extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect('login');
        }
    }
    function index()
    {
        $this->load->view('satelit/index');
    }
    function getDataSatelit()
    {
        $list = $this->model_satelit->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $item->NamaObat;
            $row[] = $item->MutasiKeluar;
            $row[] = $item->EDSatelit;
            $row[] = $item->Tanggal;
            $row[] = $item->IdSatelit;
            $row[] = "<a href='" . base_url('satelit/data/edit/') . $item->IdDataSatelit . "'><button type='button' class='btn btn-sm btn-primary m-1'>Edit</button></a><a href='" . base_url('satelit/data/hapus/') . $item->IdDataSatelit . "'><button type='button' class='btn btn-sm btn-danger m-1'>Hapus</button></a>";
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->model_satelit->count_all(),
            "recordsFiltered" => $this->model_satelit->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function tambah()
    {
        $this->load->view('satelit/tambah');
    }

    function tambahdata()
    {
        $data = array(
            'IdDataSatelit'     => '',
            'Tanggal'           => $this->input->post('Tanggal'),
            'MutasiKeluar'      => $this->input->post('MutasiKeluar'),
            'EDSatelit'         => $this->input->post('EDSatelit'),
            'IdObat'            => $this->input->post('IdObat'),
            'IdSatelit'         => $this->input->post('IdSatelit')
        );
        $resultInsert =  $this->model_satelit->tambahData($data);
        if($resultInsert === true){
            $this->session->set_flashdata('success', 'Tambah data Berhasil');
        }else{
            $this->session->set_flashdata('gagal', 'Tambah data Gagal');
        }
        redirect(base_url('satelit/data'), 'refresh');
    }

    function edit($IdDataSatelit)
    {
        $data['datasatelit'] = $this->model_satelit->datasatelitbyID($IdDataSatelit);
        $this->load->view('satelit/edit', $data);
    }
    function editdata()
    {
        $IdDataSatelit = $this->input->post('IdDataSatelit');
        $data = array(
            'Tanggal'           => $this->input->post('Tanggal'),
            'MutasiKeluar'      => $this->input->post('MutasiKeluar'),
            'EDSatelit'         => $this->input->post('EDSatelit'),
            'IdObat'            => $this->input->post('IdObat'),
            'IdSatelit'         => $this->input->post('IdSatelit')
        );
        $result =  $this->model_satelit->editData($data, $IdDataSatelit);
        if($result === true){
            $this->session->set_flashdata('success', 'Edit data Berhasil');
        }else{
            $this->session->set_flashdata('failed', 'Edit data Gagal');
        }
        redirect(base_url('satelit/data'));
    }

    function hapus($IdDataSatelit)
    {
        $result = $this->model_satelit->hapusData($IdDataSatelit);
        if($result === true){
            $this->session->set_flashdata('success', 'Hapus data Berhasil');
        }else{
            $this->session->set_flashdata('failed', 'Hapus data Gagal');
        }
        redirect(base_url('satelit/data'),'refresh');
    }

    function rekap()
    {
        $filter['filter'] = $this->input->post('rekapdate') . '-' . $this->input->post('IdSatelitRekap');
        $this->load->view('satelit/rekap', $filter);
    }
    function getRekap($filter)
    {
        $list = $this->model_satelit->get_datatablesRekap($filter);
        $Penerimaan = $this->model_satelit->getPenerimaan($filter);
        $data = array();
        $no = @$_POST['start'];
        $i = 0;
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $item->NamaObat;
            $row[] = $Penerimaan[$i]['Penerimaan'];
            $penerimaansat = $Penerimaan[$i]['Penerimaan'];
            $i++;
            $row[] = $item->duaenam;
            $row[] = $item->duatuju;
            $row[] = $item->dualapan;
            $row[] = $item->duasembilan;
            $row[] = $item->tigapuluh;
            $row[] = $item->tigasatu;
            $row[] = $item->satu;
            $row[] = $item->dua;
            $row[] = $item->tiga;
            $row[] = $item->empat;
            $row[] = $item->lima;
            $row[] = $item->enam;
            $row[] = $item->tuju;
            $row[] = $item->delapan;
            $row[] = $item->sembilan;
            $row[] = $item->sepuluh;
            $row[] = $item->sebelas;
            $row[] = $item->duabelas;
            $row[] = $item->tigabelas;
            $row[] = $item->empatbelas;
            $row[] = $item->limabelas;
            $row[] = $item->enambelas;
            $row[] = $item->tujubelas;
            $row[] = $item->delapanbelas;
            $row[] = $item->sembilanbelas;
            $row[] = $item->duapuluh;
            $row[] = $item->duasatu;
            $row[] = $item->duadua;
            $row[] = $item->duatiga;
            $row[] = $item->duaempat;
            $row[] = $item->dualima;
            $row[] = $item->EDSatelit;
            $ED = $item->EDSatelit;
            $row[] = $item->duaenam + $item->duatuju + $item->dualapan + $item->duasembilan + $item->tigapuluh + $item->tigasatu + $item->satu + $item->dua + $item->tiga + $item->empat + $item->lima + $item->tuju + $item->delapan + $item->sembilan + $item->sepuluh + $item->sebelas + $item->duabelas + $item->tigabelas + $item->empatbelas + $item->limabelas + $item->enambelas + $item->tujubelas + $item->delapanbelas + $item->sembilanbelas + $item->duapuluh + $item->duasatu + $item->duadua + $item->duatiga + $item->duaempat + $item->dualima + $ED;
            $MutasiKeluar = ($item->duaenam + $item->duatuju + $item->dualapan + $item->duasembilan + $item->tigapuluh + $item->tigasatu + $item->satu + $item->dua + $item->tiga + $item->empat + $item->lima + $item->tuju + $item->delapan + $item->sembilan + $item->sepuluh + $item->sebelas + $item->duabelas + $item->tigabelas + $item->empatbelas + $item->limabelas + $item->enambelas + $item->tujubelas + $item->delapanbelas + $item->sembilanbelas + $item->duapuluh + $item->duasatu + $item->duadua + $item->duatiga + $item->duaempat + $item->dualima) + $ED;
            $row[] = ($penerimaansat) - ($MutasiKeluar + $ED);
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->model_satelit->count_allRekap(),
            "recordsFiltered" => $this->model_satelit->count_filteredRekap($filter),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function generateDataSatelit()
    {
        $tanggal = array('26', '27', '28', '29', '30', '31', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25');
        $obat = $this->model_satelit->getObat();
        $bulandata = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $data = array();
        $tahun = 2021;
        $list = array();
        foreach ($obat as $obat) {
            foreach ($bulandata as $bulan) {
                foreach ($tanggal as $tgl) {
                    if (in_array($tgl, range(26, 31)) && $bulan === "1") {
                        $data = array(
                            'IdDataSatelit'     => '',
                            'Tanggal'           => ($tahun - 1) . '-12-' . $tgl,
                            'MutasiKeluar'      => 0,
                            'EDSatelit'         => 0,
                            'IdObat'            => $obat['IdObat'],
                            'IdSatelit'         => 'SatJ',
                        );
                        $list[] = $data;
                    } else if (in_array($tgl, range(26, 31))) {
                        $data = array(
                            'IdDataSatelit'     => '',
                            'Tanggal'           => ($tahun) . '-' . ($bulan - 1) . '-' . $tgl,
                            'MutasiKeluar'      => 0,
                            'EDSatelit'         => 0,
                            'IdObat'            => $obat['IdObat'],
                            'IdSatelit'         => 'SatJ',
                        );
                        $list[] = $data;
                    } else {
                        $data = array(
                            'IdDataSatelit'     => '',
                            'Tanggal'           => ($tahun) . '-' . $bulan . '-' . $tgl,
                            'MutasiKeluar'      => 0,
                            'EDSatelit'         => 0,
                            'IdObat'            => $obat['IdObat'],
                            'IdSatelit'         => 'SatJ',
                        );
                        $list[] = $data;
                    }
                }
            }
        }
        $this->model_satelit->generateInsert($list);
        redirect(base_url('satelit/data'));
    }
    function generatedatasatelitrekap()
    {
        $obat = $this->model_satelit->getObat();
        $bulandata = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $list = array();
        foreach ($obat as $obat) {
            foreach ($bulandata as $bulan) {
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
                        $bulan = "November";
                        break;
                    case "12":
                        $bulan = "Desember";
                        break;
                }
                $data = array(
                    'IdRekap'   => '',
                    'MutasiKeluar'  => 0,
                    'ED'            => 0,
                    'Total'         => 0,
                    'Bulan'         => $bulan,
                    'Tahun'         => 2021,
                    'IdObat'        => $obat['IdObat'],
                );
                $list[] = $data;
            }
        }
        $this->db->insert_batch('satelitrekap', $list);
        echo json_encode($list);
    }
    function savepemakian()
    {
        $filter = $this->input->post('savedatatanggal');
        $list  = $this->model_satelit->getPemakian($filter);
        $data = array();
        foreach ($list as $item) {
            $row = array();
            $ED = $item->EDSatelit;
            $row["Ed"] = $item->EDSatelit;
            $row["MutasiKeluar"] = $item->duaenam + $item->duatuju + $item->dualapan + $item->duasembilan + $item->tigapuluh + $item->tigasatu + $item->satu + $item->dua + $item->tiga + $item->empat + $item->lima + $item->tuju + $item->delapan + $item->sembilan + $item->sepuluh + $item->sebelas + $item->duabelas + $item->tigabelas + $item->empatbelas + $item->limabelas + $item->enambelas + $item->tujubelas + $item->delapanbelas + $item->sembilanbelas + $item->duapuluh + $item->duasatu + $item->duadua + $item->duatiga + $item->duaempat + $item->dualima + $ED;
            $MutasiKeluar = ($item->duaenam + $item->duatuju + $item->dualapan + $item->duasembilan + $item->tigapuluh + $item->tigasatu + $item->satu + $item->dua + $item->tiga + $item->empat + $item->lima + $item->tuju + $item->delapan + $item->sembilan + $item->sepuluh + $item->sebelas + $item->duabelas + $item->tigabelas + $item->empatbelas + $item->limabelas + $item->enambelas + $item->tujubelas + $item->delapanbelas + $item->sembilanbelas + $item->duapuluh + $item->duasatu + $item->duadua + $item->duatiga + $item->duaempat + $item->dualima) + $ED;
            $row["Total"] = $item->EDSatelit + $MutasiKeluar;
            $update  = array(
                'MutasiKeluar'  => $MutasiKeluar,
                'ED'            => $item->EDSatelit,
                'Total'         => $MutasiKeluar + $item->EDSatelit
            );
            $this->db->where('Tahun', 2021);
            $this->db->where('Bulan', 'Januari');
            $this->db->where('IdObat', $item->IdObat);
            $this->db->update('satelitrekap', $update);
            $data[] = $row;
        }
        redirect('satelit/data');
    }
    function getsatelitrekap()
    {
        $list = $this->model_satelit->get_datatablessatelitrekap();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $item->NamaObat;
            $row[] = $item->Januari;
            $row[] = $item->Februari;
            $row[] = $item->Maret;
            $row[] = $item->April;
            $row[] = $item->Mei;
            $row[] = $item->Juni;
            $row[] = $item->Juli;
            $row[] = $item->Agustus;
            $row[] = $item->September;
            $row[] = $item->Oktober;
            $row[] = $item->November;
            $row[] = $item->Desember;
            $row[] = $item->Januari + $item->Februari + $item->Maret + $item->April + $item->Mei + $item->Juni + $item->Juli + $item->Agustus + $item->September + $item->Oktober + $item->November + $item->Desember;
            $row[] = $item->JanuariED;
            $row[] = $item->FebruariED;
            $row[] = $item->MaretED;
            $row[] = $item->AprilED;
            $row[] = $item->MeiED;
            $row[] = $item->JuniED;
            $row[] = $item->JuliED;
            $row[] = $item->AgustusED;
            $row[] = $item->SeptemberED;
            $row[] = $item->OktoberED;
            $row[] = $item->NovemberED;
            $row[] = $item->DesemberED;
            $row[] = $item->JanuariED + $item->FebruariED + $item->MaretED + $item->AprilED + $item->MeiED + $item->JuniED + $item->JuliED + $item->AgustusED + $item->SeptemberED + $item->OktoberED + $item->NovemberED + $item->DesemberED;
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->model_satelit->count_allsatelitrekap(),
            "recordsFiltered" => $this->model_satelit->count_filteredsatelitrekap(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    function pemakainsatelit()
    {
        $this->load->view('satelit/pemakian');
    }
}
