<?php
/**
 * Created by PhpStorm.
 * User: Dennis Eisold
 * Date: 18.08.2018
 * Time: 17:15
 */
require __DIR__ . '/../vendor/autoload.php';

$database = InfluxDB\Client::fromDSN(sprintf('influxdb://root:root@%s:%s/%s', "localhost", 8086, "wowa"));

$result = $database->query('SELECT mean(*)
                            FROM "watchdog"
                            where time > now() - 1d
                            GROUP BY time(5m);');
$points = $result->getPoints();

function toFloat($number) {
    return (float)(number_format($number, 2));
}

foreach(array_keys($points[0]) as $Key) {
    if($Key != "time") {
        $name = str_replace("mean_", "", $Key);
        $watchdog[$name]["name"] = $name;
    }
}

foreach($points as $point) {
    $time = strtotime($point['time'])*1000;
    foreach($watchdog as $key => $value) {
        $watchdog[$key]['data'][] = array(
            "x" => $time,
            "y" => toFloat($point['mean_'.$key])
        );
    }
}
foreach($watchdog as $key => $value) {
    $data['watchdog'][] = $watchdog[$key];
}
echo json_encode($data);
?>