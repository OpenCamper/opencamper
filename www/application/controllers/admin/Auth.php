<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Auth extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('admin/auth_model', 'auth_model');
		}

		public function index(){
			if($this->session->has_userdata('is_admin_login'))
			{
				redirect('admin/dashboard');
			}
			else{
				redirect('admin/auth/login');
			}
		}

		public function login(){

			if($this->input->post('submit')){
				$this->form_validation->set_rules('email', 'Email', 'trim|required');
				$this->form_validation->set_rules('password', 'Password', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$this->load->view('admin/auth/login');
				}
				else {
					$data = array(
					'email' => $this->input->post('email'),
					'password' => $this->input->post('password')
					);
					$result = $this->auth_model->login($data);
					if ($result == TRUE) {
						$admin_data = array(
							'admin_id' => $result['id'],
						 	'name' => $result['username'],
						 	'is_admin_login' => TRUE
						);
						$this->session->set_userdata($admin_data);
						redirect(base_url('admin/dashboard'), 'refresh');
					}
					else{
						$data['msg'] = 'Invalid Email or Password!';
						$this->load->view('admin/auth/login', $data);
					}
				}
			}
			else{
				$data['title'] = 'Login';
				$this->load->view('admin/auth/login');
			}
		}	
		
		public function profile(){
			if($this->input->post('submit')){
				$data = array(
						'username' => $this->input->post('username'),
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'email' => $this->input->post('email'),
						'mobile_no' => $this->input->post('mobile_no'),
						'updated_at' => date('Y-m-d : h:m:s'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->auth_model->update_admin($data);
					if($result){
						$this->session->set_flashdata('msg', 'Record is Updated Successfully!');
						redirect(base_url('admin/auth/profile'), 'refresh');
					}
			}
			else{
				$data['admin'] = $this->auth_model->get_admin_detail();
				$data['title'] = 'User Profile';
				$data['view'] = 'admin/auth/profile';
				$this->load->view('admin/layout', $data);
			}
		}

		public function change_pwd(){
			$id = $this->session->userdata('admin_id');
			if($this->input->post('submit')){
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				$this->form_validation->set_rules('confirm_pwd', 'Confirm Password', 'trim|required|matches[password]');
				if ($this->form_validation->run() == FALSE) {
					$data['admin'] = $this->auth_model->get_admin_detail();
					$data['view'] = 'admin/auth/profile';
					$this->load->view('admin/layout', $data);
				}
				else{
					$data = array(
						'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
					);
					$result = $this->auth_model->change_pwd($data, $id);
					if($result){
						$this->session->set_flashdata('msg', 'Password has been changed successfully!');
						redirect(base_url('admin/auth/profile'));
					}
				}
			}
			else{
				$data['title'] = 'Change Password';
				$data['view'] = 'admin/auth/change_pwd';
				$this->load->view('admin/layout', $data);
			}
		}
				
		public function logout(){
			$this->session->sess_destroy();
			redirect(base_url('admin/auth/login'), 'refresh');
		}
			
	}  // end class


?>