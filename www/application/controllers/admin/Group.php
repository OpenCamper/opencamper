<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Group extends MY_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('admin/group_model', 'group_model');
		}
		public function index(){
			$data['all_groups'] = $this->group_model->get_all_groups();
			$data['title'] = 'User Group';
			$data['view'] = 'admin/group/group_list';
			$this->load->view('admin/layout', $data);
		}
		public function add(){
			if($this->input->post('submit')){
				$this->form_validation->set_rules('group_name', 'Group', 'trim|min_length[3]|required');
				if ($this->form_validation->run() == FALSE) {
					$data['title'] = 'Add Group';
					$data['view'] = 'admin/group/group_add';
					$this->load->view('admin/layout', $data);
				}
				else{
					$data = array(
						'group_name' => $this->input->post('group_name'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->group_model->add_group($data);
					if($result){
						$this->session->set_flashdata('msg', 'Group is Added Successfully!');
						redirect(base_url('admin/group'));
					}
				}
			}
			else{
				$data['title'] = 'Add Group';
				$data['view'] = 'admin/group/group_add';
				$this->load->view('admin/layout', $data);
			}
		}
		public function edit($id=0){
			if($this->input->post('submit')){
				$data = array(
					'group_name' => $this->input->post('group_name'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->group_model->edit_group($data, $id);
				if($result){
					$this->session->set_flashdata('msg', 'Group is Added Successfully!');
					redirect(base_url('admin/group'));
				}
			}
			else{
				$data['group'] = $this->group_model->get_group_by_id($id);
				$data['title'] = 'Edit Group';
				$data['view'] = 'admin/group/group_edit';
				$this->load->view('admin/layout', $data);
			}
		}
		public function del($id){
			$this->db->delete('ci_user_groups', array('id' => $id));
			$this->session->set_flashdata('msg', 'Record is Deleted Successfully!');
			redirect(base_url('admin/group'));
		}
	}

?>