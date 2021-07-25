<?php 

defined('BASEPATH')or exit('not allowed script');
    class Pivot extends CI_Controller{
        function index(){
            $this->load->view('pivot/index');
        }
        function getDataTest(){
            $list = $this->model_pivot->get_datatables();
            $data = array();
            $no = @$_POST['start'];
            //echo json_encode($list);
            foreach ($list as $item) {
                $no++;
                $row = array();
                $row[] = $no.".";
                $row[] = $item->NamaObat;
                $row[] = $item->JanuariDinkes;
                $row[] = $item->JanuariBlud;
                $row[] = $item->FebruariDinkes;
                $row[] = $item->FebruariBlud;
                $row[] = $item->Total;
                $data[] = $row;
            }
            $output = array(
                "draw" => @$_POST['draw'],
                "recordsTotal" => $this->model_pivot->count_all(),
                "recordsFiltered" => $this->model_pivot->count_filtered(),
                "data" => $data,
            );
            echo json_encode($output);
        }
    }