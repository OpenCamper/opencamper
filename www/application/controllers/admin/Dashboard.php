<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Dashboard extends MY_Controller {
        public function __construct(){
            parent::__construct();
            $this->json_config = json_decode(file_get_contents("../config.json"));
        }

        public function toFloat($number) {
            return (float)(number_format($number, 2));
        }

        public function get_fans() {
            $return['counter'] = 0;
            foreach($this->json_config->fans->fan as $key => $fan) {
                if($fan->active) {
                    @$return['fans']['fan'.$key]['description'] = $fan->description;
                    $return['counter']++;
                }
            }
            if(is_array($return)) { return $return; }
            else { return false; }
        }

        public function index() {
            require __DIR__ . '/../../../vendor/autoload.php';
            $data['title'] = 'Dashboard';
            $data['view'] = 'admin/dashboard/index';
            $data['javascript_variables'] = array();
            $Influx = InfluxDB\Client::fromDSN(sprintf('influxdb://root:root@%s:%s/%s', "localhost", 8086, "wowa"));
            $gyro_result = $Influx->query('SELECT x, y FROM "gyro" ORDER BY time DESC LIMIT 1;');
            $gyro_points = $gyro_result->getPoints();
            $data['gyro']['x'] = $gyro_points[0]['x'];
            $data['gyro']['y'] = $gyro_points[0]['y'];
            $gps_result = $Influx->query('SELECT * FROM "gps" ORDER BY time DESC LIMIT 1;');
            $gps_points = $gps_result->getPoints();
            $data['gps']['lat'] = $gps_points[0]['lat'];
            $data['gps']['lon'] = $gps_points[0]['lon'];
            $data['gps']['alt'] = $gps_points[0]['alt'];
            $data['gps']['sats'] = $gps_points[0]['sats'];
            if($this->json_config->fans->modul_active) {
                $temp = $this->get_fans();
                $data['fans'] = $temp['fans'];
                $data['javascript_variables']['fans'] = $temp['counter'];
                if($data['fans']) { $data['hidde_fans'] = false; }
            }
            else { $data['hidde_fans'] = true; }

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