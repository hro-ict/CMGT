<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){

		parent::__construct();
	        
		// load base_url
		$this->load->helper('url');
	          }

	
	public function index()
	{
		// $this->load->view('welcome_message');
		$this->load->view("navbar2.php");
		$this->load->view("news.html");
	}

	public function deneme(){
		$this->load->view('test.html');
		$this->load->view('test2.html');
	}

	public function register(){
		$this->load->view("navbar2.php");
		$this->load->view("register.html");
	}

	public function login(){
		$this->load->view("navbar2.php");
		$this->load->view("login.html");

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
