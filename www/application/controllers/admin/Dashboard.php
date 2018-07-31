<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Dashboard extends MY_Controller {
        public function __construct(){
            parent::__construct();
            $this->json_config = json_decode(file_get_contents("../config.json"));
        }

        public function index() {
            $data['title'] = 'Dashboard';
            $data['view'] = 'admin/dashboard/index';
            $data['javascript_variables'] = array();
            if($this->json_config->gas) {
                if(@$this->json_config->gas->gas_1_topic) {
                    $data['javascript_variables']['gas_1_topic'] = $this->json_config->gas->gas_1_topic;
                }
                if(@$this->json_config->gas->gas_1_tara) {
                    $data['javascript_variables']['gas_1_tara'] = $this->json_config->gas->gas_1_tara;
                }
                if(@$this->json_config->gas->gas_1_netto) {
                    $data['javascript_variables']['gas_1_netto'] = $this->json_config->gas->gas_1_netto;
                }
                if(@$this->json_config->gas->gas_2_topic) {
                    $data['javascript_variables']['gas_2_topic'] = $this->json_config->gas->gas_2_topic;
                }
                if(@$this->json_config->gas->gas_2_tara) {
                    $data['javascript_variables']['gas_2_tara'] = $this->json_config->gas->gas_2_tara;
                }
                if(@$this->json_config->gas->gas_2_netto) {
                    $data['javascript_variables']['gas_2_netto'] = $this->json_config->gas->gas_2_netto;
                }
            }
            $this->load->view('admin/layout', $data);
        }
    }
?>