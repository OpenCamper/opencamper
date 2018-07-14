<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// -----------------------------------------------------------------------------
    function getGroupyName($id){
    	
    	$CI = & get_instance();
    	return $CI->db->get_where('ci_user_groups', array('id' => $id))->row_array()['group_name'];
    }

?>    