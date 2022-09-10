<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){

		parent::__construct();
	        
		// load base_url
		$this->load->helper('url');
		$this->load->model("Articles_model");
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	          }

	
	public function index()
	{
		// $this->load->view('welcome_message');
		$this->load->view("navbar2.php");
		$this->load->view("news.html");
	}

	

	public function register(){
		$this->load->view("navbar2.php");
		$this->load->view("register.php");
		
	}

	public function upload_file(){
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
	}

	

	public function save_register(){
	$firstname= strip_tags(trim($this->input->post("fname", true))) ;
	$lastname= strip_tags(trim($this->input->post("lname", true))) ;
	$username= strip_tags(trim($this->input->post("username", true))) ;
	$email=strip_tags(trim($this->input->post("email", true))) ;
	$passwd= strip_tags(trim($this->input->post("pswd", true))) ;
	//$confirm_pswd= strip_tags(trim($this->input->post("fname", true))) ;
	$db_data= array(
		'firstname'=>$firstname,
		'lastname'=>$lastname,
		'email'=>$email,
		'username'=>$username,
		'pass'=>md5($passwd),

	);
	
	$this->form_validation->set_rules("username", "User name", "trim|required|is_unique[users.username]|max_length[50]|min_length[5]");
	$this->form_validation->set_rules("email", "Email address", "trim|required|is_unique[users.email]|valid_email");
	$this->form_validation->set_rules("pswd", "Password", "trim|required|max_length[30]|min_length[5]|matches[confirm_pswd]");
	$this->form_validation->set_rules("confirm_pswd", "Confirm password", "required|trim");
	
	$this->form_validation->set_message(
		array(
		    "required"      => "{field} should not be left blank.",
		    "valid_email"   => "{field} is not valid email",
		    "matches"       => "passwords do not match",
		    "is_unique"     => "{field} already in use",
		    "max_length"    => "{field} can max {param} characters",
		    "min_length"    => "{field} must be at least {param} characters."
		)
	        );
	        $viewData=new stdClass(); 
	        if ($this->form_validation->run()){
		$this->db->insert("users", $db_data);
		redirect(base_url()."code/welcome/login");
	        }else{
		
		$viewData->form_errors=validation_errors(); //Validation 
		$this->load->view("navbar2.php");
		$this->load->view("register.php",$viewData);
		
	        }
	

	}

	public function login(){
		$this->load->view("navbar2.php");
		$this->load->view("login.html");

	}
	public function check_login(){
		$username= $this->input->post("username");
		$password= $this->input->post("pswd");
                        if ($this->Articles_model->check($username, "username")>0){
			$check_pass= $this->Articles_model->check_pass($username);
			if ($check_pass == md5($password)){

			$this->session->set_userdata('username', $username);
			$this->load->view("navbar2.php");
		            $this->load->view("news.html");
			}
			else {
			echo "no";
			}

		}
		else {
		  echo "user not found";
		}

		
		
	}

            public function log_out(){
		$this->session->unset_userdata("username");
		// $this->load->view("navbar2.php");
		// $this->load->view("news.html");
		redirect(base_url()."/code");
	}

	public function news(){
		$this->load->view("navbar2.php");
		$this->load->view("news.html");

	}

	public function write_article(){
		$this->load->view("navbar2.php");
		$this->load->view("write_article.html");

	}

	public function about(){
		$this->load->view("navbar2.php");
		$this->load->view("about_us.html");

	}

	
}
