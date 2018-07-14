<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Adminlte extends CI_Controller {
		public function index(){
			redirect(base_url('admin/auth'));
		}
		public function top_nav(){
			$this->load->view('admin/adminlte/layout/top-nav');
		}
		public function boxed(){
			$this->load->view('admin/adminlte/layout/boxed');
		}
		public function fixed(){
			$this->load->view('admin/adminlte/layout/fixed');
		}
		public function collapsed_sidebar(){
			$this->load->view('admin/adminlte/layout/collapsed-sidebar');
		}
		public function widgets(){
			$data['view'] = 'admin/adminlte/widgets';
			$this->load->view('admin/layout', $data);
		}

		public function chartjs(){
			$data['view'] = 'admin/adminlte/charts/chartjs';
			$this->load->view('admin/layout', $data);
		}
		public function morris(){
			$data['view'] = 'admin/adminlte/charts/morris';
			$this->load->view('admin/layout', $data);
		}
		public function flot(){
			$data['view'] = 'admin/adminlte/charts/flot';
			$this->load->view('admin/layout', $data);
		}
		public function inline(){
			$data['view'] = 'admin/adminlte/charts/inline';
			$this->load->view('admin/layout', $data);
		}
		public function buttons(){
			$data['view'] = 'admin/adminlte/ui/buttons';
			$this->load->view('admin/layout', $data);
		}
		public function general(){
			$data['view'] = 'admin/adminlte/ui/general';
			$this->load->view('admin/layout', $data);
		}
		public function icons(){
			$data['view'] = 'admin/adminlte/ui/icons';
			$this->load->view('admin/layout', $data);
		}
		public function modals(){
			$data['view'] = 'admin/adminlte/ui/modals';
			$this->load->view('admin/layout', $data);
		}
		public function sliders(){
			$data['view'] = 'admin/adminlte/ui/sliders';
			$this->load->view('admin/layout', $data);
		}
		public function timeline(){
			$data['view'] = 'admin/adminlte/ui/timeline';
			$this->load->view('admin/layout', $data);
		}
		public function general_form(){
			$data['view'] = 'admin/adminlte/forms/general';
			$this->load->view('admin/layout', $data);
		}
		public function advanced_form(){
			$data['view'] = 'admin/adminlte/forms/advanced';
			$this->load->view('admin/layout', $data);
		}
		public function editors_form(){
			$data['view'] = 'admin/adminlte/forms/editors';
			$this->load->view('admin/layout', $data);
		}
		public function simple_table(){
			$data['view'] = 'admin/adminlte/tables/simple';
			$this->load->view('admin/layout', $data);
		}
		public function data_table(){
			$data['view'] = 'admin/adminlte/tables/data';
			$this->load->view('admin/layout', $data);
		}
		public function calendar(){
			$data['view'] = 'admin/adminlte/calendar';
			$this->load->view('admin/layout', $data);
		}
		public function inbox(){
			$data['view'] = 'admin/adminlte/mailbox/mailbox';
			$this->load->view('admin/layout', $data);
		}
		public function compose(){
			$data['view'] = 'admin/adminlte/mailbox/compose';
			$this->load->view('admin/layout', $data);
		}
		public function read_mail(){
			$data['view'] = 'admin/adminlte/mailbox/read-mail';
			$this->load->view('admin/layout', $data);
		}
		public function invoice(){
			$data['view'] = 'admin/adminlte/examples/invoice';
			$this->load->view('admin/layout', $data);
		}
		public function profile(){
			$data['view'] = 'admin/adminlte/examples/profile';
			$this->load->view('admin/layout', $data);
		}
		public function login(){
			$this->load->view('admin/adminlte/examples/login');
		}
		public function register(){
			$this->load->view('admin/adminlte/examples/register');
		}
		public function lockscreen(){
			$this->load->view('admin/adminlte/examples/lockscreen');
		}
		public function error404(){
			$data['view'] = 'admin/adminlte/examples/404';
			$this->load->view('admin/layout', $data);
		}
		public function errro500(){
			$data['view'] = 'admin/adminlte/examples/500';
			$this->load->view('admin/layout', $data);
		}
		public function blank(){
			$data['view'] = 'admin/adminlte/examples/blank';
			$this->load->view('admin/layout', $data);
		}
		public function pace(){
			$data['view'] = 'admin/adminlte/examples/pace';
			$this->load->view('admin/layout', $data);
		}




	}