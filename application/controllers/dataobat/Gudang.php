<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Gudang extends CI_Controller
{
    function index()
    {
        $this->load->view('gudang/index');
    }

    function getGudang()
    {
        $list = $this->model_obat->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $item->NamaObat;
            $row[] = $item->StokAwal;
            $row[] = $item->Penerimaan;
            $row[] = $item->Distribusi;
            $row[] = $item->RusakED;
            $row[] = $item->SisaStok;
            $row[] = $item->BulanGudang;
            $row[] = $item->TahunGudang;
            $row[] = "<a href='" . base_url('dataobat/obat/update/') . $item->IdObat . "'><button type='button' class='btn btn-sm btn-primary m-1'>Edit</button></a><a href='" . base_url('dataobat/obat/deleteDataObat/') . $item->IdObat . "'><button type='button' class='btn btn-sm btn-danger m-1'>Hapus</button></a>";
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->model_obat->count_all(),
            "recordsFiltered" => $this->model_obat->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function generateData()
    {
        $Bulan="Januari";
        $Tahun=2021;
        $dataObat = $this->model_gudang->getObat();
        $dataStok = $this->model_gudang->getStok();
        $dataPenerimaan = $this->model_gudang->getPenerimaan($Bulan);
        $dataDistribusi = $this->model_gudang->getDistribusi($Bulan);
        $dataED = $this->model_gudang->getED();
        $dataInsert = array();
        $i = 0;
        foreach($dataObat as $obat){
            $row = array();
            $row['NamaObat'] = $obat['NamaObat'];
            $row['StokAwal'] = 0;
            $row['Penerimaan'] = $dataPenerimaan[$i]->Penerimaan;
            $row['Distribusi'] = $dataDistribusi[$i]->Distribusi;
            $row['ED'] = $dataDistribusi[$i]->ED;
            $row['SisaStok'] = $row['StokAwal'] + $row['Penerimaan'] - $row['Distribusi'] - $row['ED'];
            // $data = array(
            //     'IdGudang'      => '',
            //     'StokAwal'      => $row['StokAwal'],
            //     'Penerimaan'    => $row['Penerimaan'],
            //     'Distribusi'    => $row['Distribusi'],
            //     'RusakED'       => $row['ED'],
            //     'SisaStok'      => $row['SisaStok'],
            //     'BulanGudang'   => $Bulan,
            //     'TahunGudang'   => $Tahun,
            //     'IdObat'        => $obat['IdObat']       
            // );
            //$this->model_gudang->insertGenerate($data);
            $i++;
            $dataInsert[] = $row;
        }
        echo json_encode($dataInsert);
    }
}
