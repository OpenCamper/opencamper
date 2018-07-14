<?php
	class Group_model extends CI_Model{

		public function add_group($data){
			return $this->db->insert('ci_user_groups', $data);
		}

		public function get_all_groups(){
			$query = $this->db->get('ci_user_groups');
			return $result = $query->result_array();
		}

		public function edit_group($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_user_groups', $data);
			return true;

		}

		public function get_group_by_id($id){
			$query = $this->db->get_where('ci_user_groups', array('id' => $id));
			return $result = $query->row_array();
		}

	}

?>	