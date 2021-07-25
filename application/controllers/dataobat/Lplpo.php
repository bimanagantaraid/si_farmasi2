<?php

defined('BASEPATH') OR exit('No direct script access allowed');
    class Lplpo extends CI_Controller{
        function index(){
            $this->load->view('lplpo/index');
        }

        function getDatalplpo(){
            $list = $this->model_lplpo->getDataLplpo();
            $data = array();
            $no = @$_POST['start'];
            foreach($list as $item){
                $no++;
                $row[] = $item->NamaObat;
                $row[] = $item->StokAwalLPLPO;
                $row[] = $item->PenerimaanLPLPO;
                $row[] = $item->PersediaanLPLPO;
                $row[] = $item->RusakEDLPLPO;
                $row[] = $item->SisaStokLPLPO;
                $row[] = $item->StokOptimum;
                $row[] = $item->PermintaanLPLPO;
                $row[] = $item->PemberiaanLPLPO;
                $row[] = $item->KeteranganLPLPO;
                $row[] = $item->BulanLPLPO;
                $row[] = $item->TahunLPLPO;
                $data[] = $row;
            };

            $output = array(
                'draw'              => @$_POST['draw'],
                'RecordsTotal'      => $this->model_lplpo->count_all(),
                'RecordsFiltered'   => $this->model_lplpo->count_filtered(),
                'data'              => $data
            );
            echo json_encode($output);

        }
    }