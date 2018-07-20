<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if(@$_POST['hiddeninput']) {
            file_put_contents("../config.json", $_POST['hiddeninput']);
        }
        $data['json_string'] = file_get_contents("../config.json");
        $data['json_schema'] = file_get_contents("../config.schema");
        $data['title'] = 'Configuration';
        $data['view'] = 'admin/configuration/index';
        $this->load->view('admin/layout', $data);
    }
}

?>