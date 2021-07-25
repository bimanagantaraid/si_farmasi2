<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

defined('BASEPATH') OR exit('No direct script access allowed');

    class ObatMasuk extends CI_Controller{
        //homepage obat masuk gudang
        function index(){
            $this->load->view('/obatmasukgudang/index');
        }

        //get data obat masuk to json and datatable
        function getObatMasukGudang(){
            $list = $this->model_obatmasukgudang->get_datatables();
            $data = array();
            $no = @$_POST['start'];
            foreach ($list as $item) {
                $no++;
                $row = array();
                $row[] = $no.".";
                $row[] = $item->NamaObat;
                $row[] = $item->Dinkes;
                $row[] = $item->Blud;
                $row[] = $item->BulanMasuk;
                $row[] = $item->TahunMasuk;
                $row[] = "<a href='" . base_url('dataobat/obatmasuk/update/') . $item->IdObatMasuk . "'><button type='button' class='btn btn-sm btn-primary m-1'>Edit</button></a><a href='" . base_url('dataobat/obatmasuk/deleteOMG/') . $item->IdObatMasuk . "'><button type='button' class='btn btn-sm btn-danger m-1'>Hapus</button></a>";
                $data[] = $row;
            }
            $output = array(
                "draw" => @$_POST['draw'],
                "recordsTotal" => $this->model_obatmasukgudang->count_all(),
                "recordsFiltered" => $this->model_obatmasukgudang->count_filtered(),
                "data" => $data,
            );
            echo json_encode($output);
        }

        // start section generate obat masuk gudang
        function generate(){
            $this->load->view('obatmasukgudang/generate');
        }

        function generateObatMasukGudang(){
            $dataGenerate = [
                'Dinkes'    => $_POST['Dinkes'],
                'Blud'      => $_POST['Blud'],
                'BulanMasuk'=> $_POST['BulanMasuk'],
                'TahunMasuk'=> $_POST['TahunMasuk']
            ];
            $resultGenerate = $this->model_obatmasukgudang->generateOMG($dataGenerate);
            echo ($resultGenerate === true) ? 'success':'fail';
        }
        //end section generate obat masuk gudang

        //start section insert data obat masuk gudang
        function insert(){
            $this->load->view('obatmasukgudang/insert');
        }

        function getObatInsert(){
            $data = $this->db->or_like('NamaObat',$_POST['query'])->get('obat')->result();
            echo json_encode($data);
        }

        function insertOMG(){
            $data = [
                'IdObatMasuk'           => '',
                'Dinkes'                => $_POST['Dinkes'],
                'Blud'                  => $_POST['Blud'],
                'BulanMasuk'            => $_POST['BulanMasuk'],
                'TahunMasuk'            => $_POST['TahunMasuk'],
                'IdObat'                => $_POST['IdObat']
            ];
            $resultInsert = $this->model_obatmasukgudang->insertOMG($data);
            if($resultInsert === 'duplicated'){
                echo 'data sudah tersedia, silahkan edit saja';
            }else if($resultInsert === true){
                echo 'success';
            }else{
                echo 'fail';
            }
        }
        //end section insert data obat masuk gudang

        //start section update obat masuk gudang
        function update($IdObatMasuk){
            $data['ObatMasuk'] = $this->model_obatmasukgudang->getObatMasukGudangById($IdObatMasuk);
            $this->load->view('obatmasukgudang/update', $data);
        }

        //update data obat masuk gudang
        function updateOMG(){
            $whereData = [
                'IdObatMasuk'           => $this->input->post('IdObatMasuk'),
                'IdObat'                => $this->input->post('IdObat')
            ];

            $valueData = [
                'Dinkes'                => $this->input->post('Dinkes'),
                'Blud'                  => $this->input->post('Blud'),
                'BulanMasuk'            => $this->input->post('BulanMasuk'),
                'TahunMasuk'            => $this->input->post('TahunMasuk'),
            ];
            
            $resultUpdate = $this->model_obatmasukgudang->updateOMG($whereData, $valueData);
            if($resultUpdate === true){
                echo 'success';
            }else{
                echo 'fail';
            }
        }

        //delete data obat masuk gudang
        function deleteOMG($IdObatMasuk){
            $resultDelete = $this->model_obatmasukgudang->deleteOMG($IdObatMasuk);
            if($resultDelete === true){
                echo 'success';
            }else{
                echo 'fail';
            }
        }

        //start section export excel obat masuk gudang
        function exportData(){
            $dataObat = $this->model_obatmasukgudang->getObat();
            $dataOMG = $this->model_obatmasukgudang->getAllOMG();
            $spreadsheet = new Spreadsheet;
            // set template excel export view
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A6', 'NO')
                        ->setCellValue('B6', 'Nama Barang Persedian')
                        ->setCellValue('C6', 'Satuan')
                        ->setCellValue('D6', 'Januari')
                        ->mergeCells('D6:E6')
                        ->setCellValue('D7', 'Dinkes')
                        ->setCellValue('E7', 'Blud')
                        ->setCellValue('F6', 'Februari')
                        ->mergeCells('F6:G6')
                        ->setCellValue('F7','Dinkes')
                        ->setCellValue('G7', 'Blud')
                        ->setCellValue('H6', 'Maret')
                        ->mergeCells('H6:I6')
                        ->setCellValue('H7','Dinkes')
                        ->setCellValue('I7', 'Blud')
                        ->setCellValue('J6', 'April')
                        ->mergeCells('J6:K6')
                        ->setCellValue('J7','Dinkes')
                        ->setCellValue('K7', 'Blud')
                        ->setCellValue('L6', 'Mei')
                        ->mergeCells('L6:M6')
                        ->setCellValue('L7','Dinkes')
                        ->setCellValue('M7', 'Blud')
                        ->setCellValue('N6', 'Juni')
                        ->mergeCells('N6:O6')
                        ->setCellValue('N7','Dinkes')
                        ->setCellValue('O7', 'Blud')
                        ->setCellValue('P6', 'Juli')
                        ->mergeCells('P6:Q6')
                        ->setCellValue('P7','Dinkes')
                        ->setCellValue('Q7', 'Blud')
                        ->setCellValue('R6', 'Agustus')
                        ->mergeCells('R6:S6')
                        ->setCellValue('R7','Dinkes')
                        ->setCellValue('S7', 'Blud')
                        ->setCellValue('T6', 'September')
                        ->mergeCells('T6:U6')
                        ->setCellValue('T7','Dinkes')
                        ->setCellValue('U7', 'Blud')
                        ->setCellValue('V6', 'Oktober')
                        ->mergeCells('V6:W6')
                        ->setCellValue('V7','Dinkes')
                        ->setCellValue('W7', 'Blud')
                        ->setCellValue('X6', 'November')
                        ->mergeCells('X6:Y6')
                        ->setCellValue('X7','Dinkes')
                        ->setCellValue('Y7', 'Blud')
                        ->setCellValue('Z6', 'Desember')
                        ->mergeCells('Z6:AA6')
                        ->setCellValue('Z7','Dinkes')
                        ->setCellValue('AA7', 'Blud')
                        ->setCellValue('AB6', 'Total Penerimaan');

            //start style excel 
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A1','LEMBAR PENERIMAAN OBAT')
                        ->setCellValue('A2', 'PUSKESMAS')
                        ->setCellValue('B2', '')
                        ->setCellValue('A3', 'KECAMATAN')
                        ->setCellValue('B3', '')
                        ->setCellValue('A4', 'KABUPATEN')
                        ->setCellValue('B4', 'GUNUNG KIDUL')
                        ->setCellValue('A5', 'DAERAH ISTIMEWA')
                        ->setCellValue('B5', 'YOGYAKARTA');
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth('5');   
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth('45');   
            $spreadsheet->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  
            $spreadsheet->getActiveSheet()->getStyle('D6:E6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('F6:G6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('H6:I6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('J6:K6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('L6:M6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('N6:O6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('P6:Q6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('R6:S6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('T6:U6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('V6:W6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('X6:Y6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('Z6:AA6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            //end style excel

            $kolom = 8;
            $nomor = 1;
            $totalPenerimaan = 0;
            foreach($dataObat as $obat){
                $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A'. $kolom, $nomor)
                        ->setCellValue('B'. $kolom, $obat['NamaObat'])
                        ->setCellValue('C'. $kolom, $obat['SatuanObat']);
                //custom output excel
                foreach($dataOMG as $omg){
                    if($omg['BulanMasuk'] === "Januari" && $omg['IdObat'] == $obat['IdObat']){
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('D'. $kolom, $omg['Dinkes'])
                        ->setCellValue('E'. $kolom, $omg['Blud']);
                        $totalPenerimaan += ($omg['Dinkes']+$omg['Blud']);
                    }else if($omg['BulanMasuk'] === "Februari" && $omg['IdObat'] == $obat['IdObat']){
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('F'. $kolom, $omg['Dinkes'])
                        ->setCellValue('G'. $kolom, $omg['Blud']);
                        $totalPenerimaan += ($omg['Dinkes']+$omg['Blud']);
                    }else if($omg['BulanMasuk'] === "Maret" && $omg['IdObat'] == $obat['IdObat']){
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('H'. $kolom, $omg['Dinkes'])
                        ->setCellValue('I'. $kolom, $omg['Blud']);
                        $totalPenerimaan += ($omg['Dinkes']+$omg['Blud']);
                    }else if($omg['BulanMasuk'] === "April" && $omg['IdObat'] == $obat['IdObat']){
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('J'. $kolom, $omg['Dinkes'])
                        ->setCellValue('K'. $kolom, $omg['Blud']);
                        $totalPenerimaan += ($omg['Dinkes']+$omg['Blud']);
                    }else if($omg['BulanMasuk'] === "Mei" && $omg['IdObat'] == $obat['IdObat']){
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('L'. $kolom, $omg['Dinkes'])
                        ->setCellValue('M'. $kolom, $omg['Blud']);
                        $totalPenerimaan += ($omg['Dinkes']+$omg['Blud']);
                    }else if($omg['BulanMasuk'] === "Juni" && $omg['IdObat'] == $obat['IdObat']){
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('N'. $kolom, $omg['Dinkes'])
                        ->setCellValue('O'. $kolom, $omg['Blud']);
                        $totalPenerimaan += ($omg['Dinkes']+$omg['Blud']);
                    }else if($omg['BulanMasuk'] === "Juli" && $omg['IdObat'] == $obat['IdObat']){
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('P'. $kolom, $omg['Dinkes'])
                        ->setCellValue('Q'. $kolom, $omg['Blud']);
                        $totalPenerimaan += ($omg['Dinkes']+$omg['Blud']);
                    }else if($omg['BulanMasuk'] === "Agustus" && $omg['IdObat'] == $obat['IdObat']){
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('R'. $kolom, $omg['Dinkes'])
                        ->setCellValue('S'. $kolom, $omg['Blud']);
                        $totalPenerimaan += ($omg['Dinkes']+$omg['Blud']);
                    }else if($omg['BulanMasuk'] === "September" && $omg['IdObat'] == $obat['IdObat']){
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('T'. $kolom, $omg['Dinkes'])
                        ->setCellValue('U'. $kolom, $omg['Blud']);
                        $totalPenerimaan += ($omg['Dinkes']+$omg['Blud']);
                    }else if($omg['BulanMasuk'] === "Oktober" && $omg['IdObat'] == $obat['IdObat']){
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('V'. $kolom, $omg['Dinkes'])
                        ->setCellValue('W'. $kolom, $omg['Blud']);
                        $totalPenerimaan += ($omg['Dinkes']+$omg['Blud']);
                    }else if($omg['BulanMasuk'] === "November" && $omg['IdObat'] == $obat['IdObat']){
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('X'. $kolom, $omg['Dinkes'])
                        ->setCellValue('Y'. $kolom, $omg['Blud']);
                        $totalPenerimaan += ($omg['Dinkes']+$omg['Blud']);
                    }else if($omg['BulanMasuk'] === "Desember" && $omg['IdObat'] == $obat['IdObat']){
                        $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('Z'. $kolom, $omg['Dinkes'])
                        ->setCellValue('AA'. $kolom, $omg['Blud']);
                        $totalPenerimaan += ($omg['Dinkes']+$omg['Blud']);
                    }
                    $spreadsheet->setActiveSheetIndex(0)
                                ->setCellValue('AB'.$kolom, $totalPenerimaan);
                }
                $totalPenerimaan=0;
                $kolom++;
                $nomor++;
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="DataObat.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        }
        
    }
