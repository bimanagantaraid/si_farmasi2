<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Obat extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect('login');
        }
    }
    function getObat()
    {
        $list = $this->model_obat->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $item->NamaObat;
            $row[] = $item->SatuanObat;
            if ($item->HargaSatuanObat === null) {
                $row[] = 0;
            } else {
                $row[] = $item->HargaSatuanObat;
            }
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

    //halaman index obat
    function index()
    {
        $this->load->view('obat/index');
    }

    //start section insert obat
    function insert()
    {
        $this->load->view('obat/insert');
    }

    function insertDataObat()
    {
        $dataObat = [
            'IdObat'            => '',
            'NamaObat'          => $_POST['NamaObat'],
            'SatuanObat'        => $_POST['SatuanObat'],
            'HargaSatuanObat'   => $_POST['HargaSatuanObat']
        ];

        $ResultInsert = $this->model_obat->insertObat($dataObat);
        if ($ResultInsert === true) {
            $this->session->set_flashdata('success','Tambah data berhasil');
        } else {
            $this->session->set_flashdata('failed','Tambah data gagal');
        }
        redirect(base_url('dataobat/obat'), 'refresh');
    }
    //end section insert obat

    //start section update obat
    function update($IdObat)
    {
        $DataEdit['obat'] = $this->model_obat->getObatById($IdObat);
        $this->load->view('obat/edit', $DataEdit);
    }

    function updateDataObat()
    {
        if ($this->input->post('IdObat') != null) {
            $IdObat = $this->input->post('IdObat');
            $dataObat = [
                'NamaObat'          => $this->input->post('NamaObat'),
                'SatuanObat'        => $this->input->post('SatuanObat'),
                'HargaSatuanObat'   => $this->input->post('HargaSatuanObat')
            ];
            $resultUpdate = $this->model_obat->updateObat($dataObat, $IdObat);
            if($resultUpdate===true){
                $this->session->set_flashdata('success','Edit data berhasil');
            } else {
                $this->session->set_flashdata('failed','Edit data gagal');
            }
        } else {
            $this->session->set_flashdata('notfound','proses data gagal');
        }
        redirect(base_url('dataobat/obat'),'refresh');
    }
    //end section update obat

    //start section delete
    function deleteDataObat($IdObat)
    {
        $resultDelete = $this->model_obat->deleteObat($IdObat);
        echo ($resultDelete == 1) ? 'success' : 'fail';
        if($resultDelete===true){
            $this->session->set_flashdata('success','Hapus data berhasil');
        }else{
            $this->session->set_flashdata('failed','Hapus data gagal');
        }
        redirect(base_url('dataobat/obat'));
    }
    //end section delete obat

    function upload()
    {
        $this->load->view('upload');
    }

    public function import_excel()
    {
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if (isset($_FILES['fileExcel']['name']) && in_array($_FILES['fileExcel']['type'], $file_mimes)) {

            $arr_file = explode('.', $_FILES['fileExcel']['name']);
            $extension = end($arr_file);

            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['fileExcel']['tmp_name']);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            // echo json_encode($sheetData);
            // echo $sheetData[0]['1'];
            for ($i = 0; $i < count($sheetData); $i++) {
                $dataObat = [
                    'IdObat'            => '',
                    'NamaObat'          => $sheetData[$i]['0'],
                    'SatuanObat'        => $sheetData[$i]['1'],
                    'HargaSatuanObat'   => null
                ];
                $insert = $this->model_obat->insertObat($dataObat);
                echo $insert;
            }
        }
    }
}
