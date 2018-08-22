<?php
/**
 * Created by PhpStorm.
 * User: Dennis Eisold
 * Date: 18.08.2018
 * Time: 17:15
 */
require __DIR__ . '/../vendor/autoload.php';

$database = InfluxDB\Client::fromDSN(sprintf('influxdb://root:root@%s:%s/%s', "localhost", 8086, "wowa"));

$result = $database->query('SELECT
                              mean("sats") AS sats,
                              mean("speed") AS speed,
                              mean("alt") AS alt,
                              mean("lat") AS lat,
                              mean("lon") AS lon
                            FROM "gps"
                            WHERE time > now() - 1d
                            GROUP BY time(5m);');
$points = $result->getPoints();

function toFloat($number) {
    return (float)(number_format($number, 2));
}

foreach($points as $point) {
    $time = strtotime($point['time'])*1000;
    $alt["name"] = "Altitude";
    $alt["data"][] = array(
        "x" => $time,
        "y" => toFloat($point['alt'])
    );
    $speed["name"] = "Speed";
    $speed["data"][] = array(
        "x" => $time,
        "y" => toFloat($point['speed'])
    );
    $sats["name"] = "Sats";
    $sats["data"][] = array(
        "x" => $time,
        "y" => toFloat($point['sats'])
    );

}
$data = array(
    "gps" => array(
        $alt,
        $speed,
        $sats
    )
);
echo json_encode($data);
?>