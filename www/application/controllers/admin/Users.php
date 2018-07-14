<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Users extends MY_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('admin/user_model', 'user_model');
		}

		public function index(){
			$data['all_users'] =  $this->user_model->get_all_users();
			$data['title'] = 'User List';
			$data['view'] = 'admin/users/user_list';
			$this->load->view('admin/layout', $data);
		}
		
		//---------------------------------------------------------------
		//  Add User
		public function add(){
			if($this->input->post('submit')){

				$this->form_validation->set_rules('username', 'Username', 'trim|min_length[5]|required');
				$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
				$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[ci_users.email]|required');
				$this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				$this->form_validation->set_rules('group', 'Group', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$data['title'] = 'Add User';
					$data['user_groups'] = $this->user_model->get_user_groups();
					$data['view'] = 'admin/users/user_add';
					$this->load->view('admin/layout', $data);
				}
				else{
					$data = array(
						'username' => $this->input->post('username'),
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'email' => $this->input->post('email'),
						'mobile_no' => $this->input->post('mobile_no'),
						'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
						'role' => $this->input->post('group'),
						'created_at' => date('Y-m-d : h:m:s'),
						'updated_at' => date('Y-m-d : h:m:s'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->user_model->add_user($data);
					if($result){
						$this->session->set_flashdata('msg', 'User has been Added Successfully!');
						redirect(base_url('admin/users'));
					}
				}
			}
			else{
				$data['user_groups'] = $this->user_model->get_user_groups();
				$data['title'] = 'Add User';
				$data['view'] = 'admin/users/user_add';
				$this->load->view('admin/layout', $data);
			}
			
		}

		//---------------------------------------------------------------
		//  Edit User
		public function edit($id = 0){
			if($this->input->post('submit')){
				$this->form_validation->set_rules('username', 'Username', 'trim|required');
				$this->form_validation->set_rules('firstname', 'Username', 'trim|required');
				$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|required');
				$this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
				$this->form_validation->set_rules('status', 'Status', 'trim|required');
				$this->form_validation->set_rules('group', 'Group', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$data['user'] = $this->user_model->get_user_by_id($id);
					$data['user_groups'] = $this->user_model->get_user_groups();
					$data['title'] = 'Edit User';
					$data['view'] = 'admin/users/user_edit';
					$this->load->view('admin/layout', $data);
				}
				else{
					$data = array(
						'username' => $this->input->post('username'),
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'email' => $this->input->post('email'),
						'mobile_no' => $this->input->post('mobile_no'),
						'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
						'role' => $this->input->post('group'),
						'is_active' => $this->input->post('status'),
						'updated_at' => date('Y-m-d : h:m:s'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->user_model->edit_user($data, $id);
					if($result){
						$this->session->set_flashdata('msg', 'User has been Updated Successfully!');
						redirect(base_url('admin/users'));
					}
				}
			}
			else{
				$data['user'] = $this->user_model->get_user_by_id($id);
				$data['user_groups'] = $this->user_model->get_user_groups();
				$data['title'] = 'Edit User';
				$data['view'] = 'admin/users/user_edit';
				$this->load->view('admin/layout', $data);
			}
		}

		//---------------------------------------------------------------
		//  Delete Users
		public function del($id = 0){
			$this->db->delete('ci_users', array('id' => $id));
			$this->session->set_flashdata('msg', 'User has been Deleted Successfully!');
			redirect(base_url('admin/users'));
		}

		//---------------------------------------------------------------
		//  Export Users PDF 
		public function create_users_pdf(){
			$this->load->helper('pdf_helper'); // loaded pdf helper
			$data['all_users'] = $this->user_model->get_all_users();
			$this->load->view('admin/users/users_pdf', $data);
		}

		//---------------------------------------------------------------	
		// Export data in CSV format 
		public function export_csv(){ 
		   // file name 
		   $filename = 'users_'.date('Y-m-d').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   
		   // get data 
		   $user_data = $this->user_model->get_all_users_for_csv();

		   // file creation 
		   $file = fopen('php://output', 'w');
		 
		   $header = array("ID", "Username", "First Name", "Last Name", "Email", "Mobile_no", "Created Date"); 
		   fputcsv($file, $header);
		   foreach ($user_data as $key=>$line){ 
		     fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
		  }
	}


?>