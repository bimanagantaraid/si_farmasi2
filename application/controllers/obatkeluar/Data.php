<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use function PHPSTORM_META\map;

defined('BASEPATH') OR exit('No direct script access allowed');
    class Data extends CI_Controller{
        function __construct()
        {
            parent::__construct();
            if($this->session->userdata('status')!="login"){
                redirect('login');
            }
        }
        function getObatKeluar(){
            $list = $this->model_obatkeluargudang->get_datatables();
            $data = array();
            $no = @$_POST['start'];
            foreach ($list as $item) {
                $no++;
                $row = array();
                $row[] = $no.".";
                $row[] = $item->NamaObat;
                $row[] = $item->NamaSatelit;
                $row[] = $item->JumlahObatKeluar;
                $row[] = $item->BulanObatKeluar;
                $row[] = $item->TahunObatKeluar;
                $row[] = "<a href='" . base_url('obatkeluar/data/update/') . $item->IdObatKeluar . "'><button type='button' class='btn btn-sm btn-primary m-1'>Edit</button></a><a href='" . base_url('obatkeluar/data/delete/') . $item->IdObatKeluar . "'><button type='button' class='btn btn-sm btn-danger m-1'>Hapus</button></a>";
                $data[] = $row;
            }
            $output = array(
                "draw" => @$_POST['draw'],
                "recordsTotal" => $this->model_obatkeluargudang->count_all(),
                "recordsFiltered" => $this->model_obatkeluargudang->count_filtered(),
                "data" => $data,
            );
            echo json_encode($output);
        }

        //homepage obat keluar
        function index(){
            $this->load->view('obatkeluargudang/index');
        }

        //section generate obat keluar gudang
        function generate(){
            $this->load->view('obatkeluargudang/generate');
        }

        function generateObatSatelit(){
            $dataObat = $this->model_obatkeluargudang->getObat();
            $dataSatelit = $this->model_obatkeluargudang->getSatelit();
            $Bulan = ['Januari','Februari','Maret','April', 'Mei','Juni','Juli','Agustus','September', 'Oktober','November', 'Desember'];
            $i=0;
            foreach($dataObat as $obat){
                $dataGenerateObatSatelit = [
                    'IdObatKeluar'      => '',
                    'JumlahObatKeluar'  => $this->input->post('JumlahObatKeluar'),
                    'BulanObatKeluar'   => $this->input->post('BulanObatKeluar'),
                    'TahunObatKeluar'   => $this->input->post('TahunObatKeluar'),
                    'IdSatelit'         => $this->input->post('IdSatelit'),
                    'IdObat'            => $obat['IdObat']
                ];
                $resultGenerate = $this->model_obatkeluargudang->generateData($dataGenerateObatSatelit);       
            }
            redirect(base_url('obatkeluar/data'),'refresh');
        }

        //section insert/tambah obat keluar gudang
        function insert(){
            $this->load->view('obatkeluargudang/insert');
        }

        function insertData(){
            $data = array(
                'IdObatKeluar'      => '',
                'JumlahObatKeluar'  => $this->input->post('JumlahObatKeluar'),
                'BulanObatKeluar'   => $this->input->post('BulanObatKeluar'),
                'TahunObatKeluar'   => $this->input->post('TahunObatKeluar'),
                'IdSatelit'         => $this->input->post('IdSatelit'),
                'IdObat'            => $this->input->post('IdObat')
            );
            $resultInsert = $this->model_obatkeluargudang->insertOKG($data);
            if($resultInsert === "sukses"){
                $this->session->set_flashdata('success','tambah data berhasil');
            }else if($resultInsert === "gagal"){
                $this->session->set_flashdata('failed', 'tambah data gagal');
            }else if($resultInsert === "data sudah tersedia"){
                $this->session->set_flashdata('duplicated','data sudah ada');   
            }
            redirect(base_url('obatkeluar/data'), 'refresh');
        }

        //section delete data obat keluar gudang
        function delete($IdObatKeluar){
            $resultDelete = $this->model_obatkeluargudang->deleteOKG($IdObatKeluar);
            if($resultDelete === true){
                $this->session->set_flashdata('success','tambah data berhasil');
            }else{
                $this->session->set_flashdata('failed', 'tambah data gagal');
            }
            redirect(base_url('obatkeluar/data'), 'refresh');
        }

        //section edit data obat keluar gudang
        function update($IdObatKeluar){
            $data['DataOKG'] = $this->model_obatkeluargudang->getDataObatKeluarById($IdObatKeluar);
            $this->load->view('obatkeluargudang/update', $data); 
        }

        function updateOKG(){
            $where = array(
                'IdObatKeluar'       => $this->input->post('IdObatKeluar')
            );
            $dataOKG = array(
                'JumlahObatKeluar'  => $this->input->post('JumlahObatKeluar'),
                'BulanObatKeluar'   => $this->input->post('BulanObatKeluar'),
                'TahunObatKeluar'   => $this->input->post('TahunObatKeluar'),
                'IdSatelit'         => $this->input->post('IdSatelit'),
                'IdObat'            => $this->input->post('IdObat'),
            );
            $resultUpdate = $this->model_obatkeluargudang->updateOKG($where, $dataOKG);
            if($resultUpdate === true){
                $this->session->set_flashdata('success','tambah data berhasil');
            }else{
                $this->session->set_flashdata('failed', 'tambah data gagal');
            }
            redirect(base_url('obatkeluargudang/oobat'), 'refresh');
        }

        //section export to excel
        function exportExcelOKG(){
            $dataObat = $this->model_obatkeluargudang->getObat();
            $dataOKG = $this->model_obatkeluargudang->getAllOKG();
            $dataSatelit = $this->model_obatkeluargudang->getSatelit();
            $spreadsheet = new Spreadsheet;
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'Lembar Distribusi Obat Ke Satelit')
                        ->setCellValue('A2', 'PUSKESMAS')
                        ->setCellValue('B2', '')
                        ->setCellValue('A3', 'KECAMATAN')
                        ->setCellValue('B3', '')
                        ->setCellValue('A4', 'KABUPATEN')
                        ->setCellValue('B4', 'GUNUNG KIDUL')
                        ->setCellValue('A5', 'DAERAH ISTIMEWA')
                        ->setCellValue('B5', 'YOGYAKARTA')
                        ->setCellValue('A9', 'No')
                        ->setCellValue('B9', 'Nama Barang Persediaan')
                        ->setCellValue('C9', 'Satuan')
                        ->setCellValue('E9', 'Januari')
                        ->mergeCells('E9:N9')
                        ->setCellValue('E10', 'Sat A')
                        ->setCellValue('F10', 'Sat B')
                        ->setCellValue('G10', 'Sat C')
                        ->setCellValue('H10', 'Sat D')
                        ->setCellValue('I10', 'Sat E')
                        ->setCellValue('J10', 'Sat F')
                        ->setCellValue('K10', 'Sat G')
                        ->setCellValue('L10', 'Sat H')
                        ->setCellValue('M10', 'Sat I')
                        ->setCellValue('N10', 'Sat J')
                        ->setCellValue('O9', 'Februari')
                        ->mergeCells('O9:X9')
                        ->setCellValue('O10', 'Sat A')
                        ->setCellValue('P10', 'Sat B')
                        ->setCellValue('Q10', 'Sat C')
                        ->setCellValue('R10', 'Sat D')
                        ->setCellValue('S10', 'Sat E')
                        ->setCellValue('T10', 'Sat F')
                        ->setCellValue('U10', 'Sat G')
                        ->setCellValue('V10', 'Sat H')
                        ->setCellValue('W10', 'Sat I')
                        ->setCellValue('X10', 'Sat J')
                        ->setCellValue('Y9', 'Maret')
                        ->mergeCells('Y9:AH9')
                        ->setCellValue('Y10', 'Sat A')
                        ->setCellValue('Z10', 'Sat B')
                        ->setCellValue('AA10', 'Sat C')
                        ->setCellValue('AB10', 'Sat D')
                        ->setCellValue('AC10', 'Sat E')
                        ->setCellValue('AD10', 'Sat F')
                        ->setCellValue('AE10', 'Sat G')
                        ->setCellValue('AF10', 'Sat H')
                        ->setCellValue('AG10', 'Sat I')
                        ->setCellValue('AH10', 'Sat J')
                        ->setCellValue('AI9', 'April')
                        ->mergeCells('AI9:AR9')
                        ->setCellValue('AI10', 'Sat A')
                        ->setCellValue('AJ10', 'Sat B')
                        ->setCellValue('AK10', 'Sat C')
                        ->setCellValue('AL10', 'Sat D')
                        ->setCellValue('AM10', 'Sat E')
                        ->setCellValue('AN10', 'Sat F')
                        ->setCellValue('AO10', 'Sat G')
                        ->setCellValue('AP10', 'Sat H')
                        ->setCellValue('AQ10', 'Sat I')
                        ->setCellValue('AR10', 'Sat J')
                        ->setCellValue('AS9', 'Mei')
                        ->mergeCells('AS9:BB9')
                        ->setCellValue('AS10', 'Sat A')
                        ->setCellValue('AT10', 'Sat B')
                        ->setCellValue('AU10', 'Sat C')
                        ->setCellValue('AV10', 'Sat D')
                        ->setCellValue('AW10', 'Sat E')
                        ->setCellValue('AX10', 'Sat F')
                        ->setCellValue('AY10', 'Sat G')
                        ->setCellValue('AZ10', 'Sat H')
                        ->setCellValue('BA10', 'Sat I')
                        ->setCellValue('BB10', 'Sat J')
                        ->setCellValue('BC9', 'Juni')
                        ->mergeCells('BC9:BL9')
                        ->setCellValue('BC10', 'Sat A')
                        ->setCellValue('BD10', 'Sat B')
                        ->setCellValue('BE10', 'Sat C')
                        ->setCellValue('BF10', 'Sat D')
                        ->setCellValue('BG10', 'Sat E')
                        ->setCellValue('BH10', 'Sat F')
                        ->setCellValue('BI10', 'Sat G')
                        ->setCellValue('BJ10', 'Sat H')
                        ->setCellValue('BK10', 'Sat I')
                        ->setCellValue('BL10', 'Sat J')
                        ->setCellValue('BM9', 'Juli')
                        ->mergeCells('BM9:BV9')
                        ->setCellValue('BM10', 'Sat A')
                        ->setCellValue('BN10', 'Sat B')
                        ->setCellValue('BO10', 'Sat C')
                        ->setCellValue('BP10', 'Sat D')
                        ->setCellValue('BQ10', 'Sat E')
                        ->setCellValue('BR10', 'Sat F')
                        ->setCellValue('BS10', 'Sat G')
                        ->setCellValue('BT10', 'Sat H')
                        ->setCellValue('BU10', 'Sat I')
                        ->setCellValue('BV10', 'Sat J')
                        ->setCellValue('BW9', 'Agustus')
                        ->mergeCells('BW9:CF9')
                        ->setCellValue('BW10', 'Sat A')
                        ->setCellValue('BX10', 'Sat B')
                        ->setCellValue('BY10', 'Sat C')
                        ->setCellValue('BZ10', 'Sat D')
                        ->setCellValue('CA10', 'Sat E')
                        ->setCellValue('CB10', 'Sat F')
                        ->setCellValue('CC10', 'Sat G')
                        ->setCellValue('CD10', 'Sat H')
                        ->setCellValue('CE10', 'Sat I')
                        ->setCellValue('CF10', 'Sat J')
                        ->setCellValue('CG9', 'September')
                        ->mergeCells('CG9:CP9')
                        ->setCellValue('CG10', 'Sat A')
                        ->setCellValue('CH10', 'Sat B')
                        ->setCellValue('CI10', 'Sat C')
                        ->setCellValue('CJ10', 'Sat D')
                        ->setCellValue('CK10', 'Sat E')
                        ->setCellValue('CL10', 'Sat F')
                        ->setCellValue('CM10', 'Sat G')
                        ->setCellValue('CN10', 'Sat H')
                        ->setCellValue('CO10', 'Sat I')
                        ->setCellValue('CP10', 'Sat J')
                        ->setCellValue('CQ9', 'Oktober')
                        ->mergeCells('CQ9:CZ9')
                        ->setCellValue('CQ10', 'Sat A')
                        ->setCellValue('CR10', 'Sat B')
                        ->setCellValue('CS10', 'Sat C')
                        ->setCellValue('CT10', 'Sat D')
                        ->setCellValue('CU10', 'Sat E')
                        ->setCellValue('CV10', 'Sat F')
                        ->setCellValue('CW10', 'Sat G')
                        ->setCellValue('CX10', 'Sat H')
                        ->setCellValue('CY10', 'Sat I')
                        ->setCellValue('CZ10', 'Sat J')
                        ->setCellValue('DA9', 'November')
                        ->mergeCells('DA9:DJ9')
                        ->setCellValue('DA10', 'Sat A')
                        ->setCellValue('DB10', 'Sat B')
                        ->setCellValue('DC10', 'Sat C')
                        ->setCellValue('DD10', 'Sat D')
                        ->setCellValue('DE10', 'Sat E')
                        ->setCellValue('DF10', 'Sat F')
                        ->setCellValue('DG10', 'Sat G')
                        ->setCellValue('DH10', 'Sat H')
                        ->setCellValue('DI10', 'Sat I')
                        ->setCellValue('DJ10', 'Sat J')
                        ->setCellValue('DK9', 'Desember')
                        ->mergeCells('DK9:DT9')
                        ->setCellValue('DK10', 'Sat A')
                        ->setCellValue('DL10', 'Sat B')
                        ->setCellValue('DM10', 'Sat C')
                        ->setCellValue('DN10', 'Sat D')
                        ->setCellValue('DO10', 'Sat E')
                        ->setCellValue('DP10', 'Sat F')
                        ->setCellValue('DQ10', 'Sat G')
                        ->setCellValue('DR10', 'Sat H')
                        ->setCellValue('DS10', 'Sat I')
                        ->setCellValue('DT10', 'Sat J')
                        ->setCellValue('DU10', 'Total Distribusi');
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth('5');   
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth('45');
            $spreadsheet->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);  
            $spreadsheet->getActiveSheet()->getStyle('EJ')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('EJ9:EJ10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);   
            $spreadsheet->getActiveSheet()->getStyle('E9:N9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()
                        ->getStyle('A9:DU400')
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle((\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN));
            $kolom = 11;
            $nomor = 1;
            $ED = 0;
            $Januari = array('E','F','G','H','I','J','K','L','M','N');
            $Februari = array('O','P','Q','R','S','T','U','V','W','X');
            $Maret = array('Y','Z','AA','AB','AC','AD','AE','AF','AG','AH');
            $April = array('AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR');
            $Mei = array('AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB');
            $Juni = array('BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL');
            $Juli = array('BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV');
            $Agustus = array('BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF');
            $September = array('CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP');
            $Oktober = array('CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ');
            $November = array('DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ');
            $Desember = array('DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT');
            

            foreach($dataObat as $obat){
                $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('A'. $kolom, $nomor)
                            ->setCellValue('B'. $kolom, $obat['NamaObat'])
                            ->setCellValue('C'. $kolom, $obat['SatuanObat']);
                    $jan=$feb=$mar=$apr=$me=$jul=$jun=$ags=$sep=$okt=$nov=$des=$ED=0;
                    foreach($dataOKG as $OKG){
                        //selection berdasarkan bulan
                        if($OKG['BulanObatKeluar'] === 'Januari'){
                            foreach($dataSatelit as $satelit){
                                if($OKG['IdObat'] === $obat['IdObat'] && $OKG['IdSatelit'] === $satelit['IdSatelit']){
                                    $ED=$ED+$OKG['ED'];
                                    $spreadsheet->setActiveSheetIndex(0)
                                    ->setCellValue($Januari[$jan++]. $kolom, $OKG['JumlahObatKeluar']);
                                }
                            }
                        }else if($OKG['BulanObatKeluar'] === 'Februari'){
                            foreach($dataSatelit as $satelit){
                                if($OKG['IdObat'] === $obat['IdObat'] && $OKG['IdSatelit'] === $satelit['IdSatelit']){
                                    $ED=$ED+$OKG['ED'];
                                    $spreadsheet->setActiveSheetIndex(0)
                                                ->setCellValue($Februari[$feb++]. $kolom, $OKG['JumlahObatKeluar']);
                                }
                            }
                        }else if($OKG['BulanObatKeluar'] === 'Maret'){
                            foreach($dataSatelit as $satelit){
                                if($OKG['IdObat'] === $obat['IdObat'] && $OKG['IdSatelit'] === $satelit['IdSatelit']){
                                    $spreadsheet->setActiveSheetIndex(0)
                                                ->setCellValue($Maret[$mar++]. $kolom, $OKG['JumlahObatKeluar']);
                                }
                            }
                        }else if($OKG['BulanObatKeluar'] === 'April'){
                            foreach($dataSatelit as $satelit){
                                if($OKG['IdObat'] === $obat['IdObat'] && $OKG['IdSatelit'] === $satelit['IdSatelit']){
                                    $spreadsheet->setActiveSheetIndex(0)
                                                ->setCellValue($April[$apr++]. $kolom, $OKG['JumlahObatKeluar']);
                                }
                            }
                        }else if($OKG['BulanObatKeluar'] === 'Mei'){
                            foreach($dataSatelit as $satelit){
                                if($OKG['IdObat'] === $obat['IdObat'] && $OKG['IdSatelit'] === $satelit['IdSatelit']){
                                    $spreadsheet->setActiveSheetIndex(0)
                                                ->setCellValue($Mei[$me++]. $kolom, $OKG['JumlahObatKeluar']);
                                }
                            }
                        }else if($OKG['BulanObatKeluar'] === 'Juni'){
                            foreach($dataSatelit as $satelit){
                                if($OKG['IdObat'] === $obat['IdObat'] && $OKG['IdSatelit'] === $satelit['IdSatelit']){
                                    $spreadsheet->setActiveSheetIndex(0)
                                                ->setCellValue($Juni[$jun++]. $kolom, $OKG['JumlahObatKeluar']);
                                }
                            }
                        }else if($OKG['BulanObatKeluar'] === 'Juli'){
                            foreach($dataSatelit as $satelit){
                                if($OKG['IdObat'] === $obat['IdObat'] && $OKG['IdSatelit'] === $satelit['IdSatelit']){
                                    $spreadsheet->setActiveSheetIndex(0)
                                                ->setCellValue($Juli[$jul++]. $kolom, $OKG['JumlahObatKeluar']);
                                }
                            }
                        }else if($OKG['BulanObatKeluar'] === 'Agustus'){
                            foreach($dataSatelit as $satelit){
                                if($OKG['IdObat'] === $obat['IdObat'] && $OKG['IdSatelit'] === $satelit['IdSatelit']){
                                    $spreadsheet->setActiveSheetIndex(0)
                                                ->setCellValue($Agustus[$ags++]. $kolom, $OKG['JumlahObatKeluar']);
                                }
                            }
                        }else if($OKG['BulanObatKeluar'] === 'September'){
                            foreach($dataSatelit as $satelit){
                                if($OKG['IdObat'] === $obat['IdObat'] && $OKG['IdSatelit'] === $satelit['IdSatelit']){
                                    $spreadsheet->setActiveSheetIndex(0)
                                                ->setCellValue($September[$sep++]. $kolom, $OKG['JumlahObatKeluar']);
                                }
                            }
                        }else if($OKG['BulanObatKeluar'] === 'Oktober'){
                            foreach($dataSatelit as $satelit){
                                if($OKG['IdObat'] === $obat['IdObat'] && $OKG['IdSatelit'] === $satelit['IdSatelit']){
                                    $spreadsheet->setActiveSheetIndex(0)
                                                ->setCellValue($Oktober[$okt++]. $kolom, $OKG['JumlahObatKeluar']);
                                }
                            }
                        }else if($OKG['BulanObatKeluar'] === 'November'){
                            foreach($dataSatelit as $satelit){
                                if($OKG['IdObat'] === $obat['IdObat'] && $OKG['IdSatelit'] === $satelit['IdSatelit']){
                                    $spreadsheet->setActiveSheetIndex(0)
                                                ->setCellValue($November[$nov++]. $kolom, $OKG['JumlahObatKeluar']);
                                }
                            }
                        }else if($OKG['BulanObatKeluar'] === 'Desember'){
                            foreach($dataSatelit as $satelit){
                                if($OKG['IdObat'] === $obat['IdObat'] && $OKG['IdSatelit'] === $satelit['IdSatelit']){
                                    $spreadsheet->setActiveSheetIndex(0)
                                                ->setCellValue($Desember[$des++]. $kolom, $OKG['JumlahObatKeluar']);
                                }
                            }
                        }
                        if($OKG['IdObat'] === $obat['IdObat'] )
                        $rumus = "=sum(E".$kolom.":DT".$kolom.")";
                        $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('DU'.$kolom, $rumus);
                    }
                $kolom++;
                $nomor++;
            }
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Data Keluar Gudang Ke Satelit.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        }
    }
