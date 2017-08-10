<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Login_Model','lm');
    }

    public function index() {
        $this->load->view('login');
    }

   /*  public function userlogin() {


        $email_passwords = array('edwardsn@usc.edu.tt');

        //if(in_array($this->input->post("email"), $email_passwords) ) {
        if (empty($_SESSION)) {
            if ($this->input->post("password") === "accessGranted") {
                $username = $this->input->post("username");
                $_SESSION['user'] = $username;
                redirect('requisition/index');
            } else {
                $this->index();
            }
        } else {
            redirect('requisition/index');
        }
    } */

    public function change() {
        $this->lm->changePassword();
    }

    // Setup Login for all Users
    public function login() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');



        if ($this->form_validation->run() == FALSE) {
            redirect(base_url() . 'index.php/login/index');
        } else {
            $post = $this->input->post();
            $clean = $this->security->xss_clean($post);


            $userInfo = $this->lm->checkLogin($clean);

            /* if(!$userInfo){
              $this->session->set_flashdata('flash_message', 'The login was unsucessful!');
              redirect(base_url().'index.php/login/index');
              } */
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'index.php/requisition/index');
        unset($_SESSION);

        if (!isset($_SESSION)) {
            $this->index();
        }
    }

}
