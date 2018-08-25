<?php
/**
 * Created by PhpStorm.
 * User: Dennis Eisold
 * Date: 18.08.2018
 * Time: 17:15
 */
require __DIR__ . '/../vendor/autoload.php';

$database = InfluxDB\Client::fromDSN(sprintf('influxdb://root:root@%s:%s/%s', "localhost", 8086, "wowa"));

$days = intval($_REQUEST['days']);
$group = intval($_REQUEST['group']);

$result = $database->query('SELECT
                              mean("CPU_temp") as CPU_temp,
                              mean("Disk_usage") as Disk_usage,
                              mean("RAM_usage") as RAM_usage,
                              mean("CPU_load") as CPU_load
                            FROM status
                            WHERE time > now() - 1d
                            GROUP BY time(5m);');
$points = $result->getPoints();

function toFloat($number) {
    return (float)(number_format($number, 2));
}

$CPU_temp["name"] = "CPU temp";
$Disk_usage["name"] = "Disk usage";
$RAM_usage["name"] = "RAM usage";
$CPU_load["name"] = "CPU load";

foreach($points as $point) {
    $time = strtotime($point['time'])*1000;
    $CPU_temp["data"][] = array(
        "x" => $time,
        "y" => toFloat($point['CPU_temp'])
    );
    $Disk_usage["data"][] = array(
        "x" => $time,
        "y" => toFloat($point['Disk_usage'])
    );
    $RAM_usage["data"][] = array(
        "x" => $time,
        "y" => toFloat($point['RAM_usage'])
    );
    $CPU_load["data"][] = array(
        "x" => $time,
        "y" => toFloat($point['CPU_load'])
    );

}
$data = array(
    "system" => array(
        $CPU_temp,
        $Disk_usage,
        $RAM_usage,
        $CPU_load
    )
);
echo json_encode($data);
?>