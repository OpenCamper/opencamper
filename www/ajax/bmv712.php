<?php
/**
 * Created by PhpStorm.
 * User: Dennis Eisold
 * Date: 16.08.2018
 * Time: 12:41
 */
require __DIR__ . '/../vendor/autoload.php';

$database = InfluxDB\Client::fromDSN(sprintf('influxdb://root:root@%s:%s/%s', "localhost", 8086, "wowa"));

$days = intval($_REQUEST['days']);
$group = intval($_REQUEST['group']);

$result = $database->query('SELECT
                              mean(Akkuzustand_Prozent) AS Akkuzustand_Prozent,
                              mean(Kapazitaet_entnommen_Ah) AS Kapazitaet_entnommen_Ah,
                              mean(Strom_A) AS Strom_A,
                              mean(Spannung_V) AS Spannung_V
                            FROM "BMV712"
                            where time > now() - '.$days.'d
                            GROUP BY time('.$group.'m);');
$points = $result->getPoints();

function toFloat($number) {
    return (float)(number_format($number, 2));
}

foreach($points as $point) {
    $time = strtotime($point['time'])*1000;
    $Akkustand_Prozent[] = array("x" => $time, "y" => toFloat($point['Akkuzustand_Prozent']));
    $Kapazitaet_entnommen_Ah[] = array("x" => $time, "y" => toFloat($point['Kapazitaet_entnommen_Ah'] * -1));
    $Spannung_V[] = array("x" => $time, "y" => toFloat($point['Spannung_V']));
    $Strom_A[] = array("x" => $time, "y" => toFloat($point['Strom_A']));
}
$data = array(
    "Akkuzustand_Prozent" => $Akkustand_Prozent,
    "Kapazitaet_entnommen_Ah" => $Kapazitaet_entnommen_Ah,
    "Spannung_V" => $Spannung_V,
    "Strom_A" => $Strom_A,
);
echo json_encode($data);
?>