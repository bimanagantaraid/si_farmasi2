<?php

defined("BASEPATH") or EXIT('No direct script access allowed');
    class Login extends CI_Controller{
        function index(){
            $this->load->view('login.php');
        }
        function validation(){
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $loginuser = $this->model_login->can_login($username, $password);
            if($loginuser["status"] === "found"){
                $userdata = array(
                    'status'    => "login",
                    'nama'  => $loginuser["data"][0]["nama"]
                );
                $this->session->set_userdata($userdata);
                redirect(base_url('dashboard/index'));
            }else{
                redirect(base_url('login'));
            }
        }
        function out(){
            $this->session->sess_destroy();
            redirect(base_url('login'));
        }
    }