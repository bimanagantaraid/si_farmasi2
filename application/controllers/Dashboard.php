<?php

    class Dashboard extends CI_Controller{
        function __construct()
        {
            parent::__construct();
            if($this->session->userdata('status')!="login"){
                redirect('login');
            }
        }
        function index(){
            $data['obat'] = $this->model_obat->count();
            $data['apoteker'] = $this->model_login->count();
            $this->load->view('dashboard', $data);
        }
    }