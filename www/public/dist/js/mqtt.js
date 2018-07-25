/* 
 * MQTT-WebClient
*/

var hostname = "10.10.31.2";
var port = 8083;
var clientId = "webio4mqttexample";
clientId += new Date().getUTCMilliseconds();
;
var username = "";
var password = "";
var subscription = "wowa/#";

// Create a client instance
client = new Paho.MQTT.Client(hostname, Number(port), clientId);

// set callback handlers
client.onConnectionLost = onConnectionLost;
client.onMessageArrived = onMessageArrived;

// connect the client
client.connect({onSuccess: onConnect});

// called when the client connects
function onConnect() {
    // Once a connection has been made, make a subscription and send a message.
    console.log("onConnect");
    client.subscribe(subscription);
    message = new Paho.MQTT.Message("Hello");
    message.destinationName = "World";
    client.send(message);
}

// called when the client loses its connection
function onConnectionLost(responseObject) {
    if (responseObject.errorCode !== 0) {
        console.log("onConnectionLost:" + responseObject.errorMessage);
    }
}

function isFloat(n) {
    return Number(n) === n && n % 1 !== 0;
}

function isInt(n) {
    return Number(n) === n && n % 1 === 0;
}

// called when a message arrives
function onMessageArrived(message) {
    console.log("onMessageArrived:" + message.payloadString);
    if (message.destinationName == "wowa/gyro") {
        var gyro = JSON.parse(message.payloadString);
        if (isFloat(gyro['rotation_x']) || isInt(gyro['rotation_x'])) {
            $('#gyro_rotation_x').text("X: " + gyro['rotation_x']);
            $('#gyro_rotation_x_img').css('-webkit-transform', 'rotate(' + gyro['rotation_x'] + 'deg)');
            //document.getElementById("gyro.rotation_x").className = "";
        }
        else {
            document.getElementById('gyro.rotation_x').innerHTML = 0;
        }
        if (isFloat(gyro['rotation_y']) || isInt(gyro['rotation_y'])) {
            $('#gyro_rotation_y').text("Y: " + gyro['rotation_y']);
            $('#gyro_rotation_y_img').css('-webkit-transform', 'rotate(' + gyro['rotation_y'] + 'deg)');
            //document.getElementById("gyro.rotation_y").className = "";
        }
        else {
            document.getElementById('gyro.rotation_y').innerHTML = 0;
        }
    }
    if (message.destinationName == "wowa/gps") {
        var gps = JSON.parse(message.payloadString);
        if (gps['lat']) {
            $('#gps_lat').text("Lat: " + gps['lat']);
        } else {
            $('#gps_lat').text("Lat: No Data");
        }
        if (gps['lon']) {
            $('#gps_lon').text("Lon: " + gps['lon']);
        } else {
            $('#gps_lon').text("Lon: No Data");
        }
        if (gps['alt']) {
            $('#gps_alt').text("Alt: " + gps['alt']);
        } else {
            $('#gps_alt').text("Alt: No Data");
        }
        if (gps['sats']) {
            $('#gps_sats').text("Sats: " + gps['sats']);
        } else {
            $('#gps_sats').text("Sats: No Data");
        }
    }
    if (message.destinationName == "wowa/net") {
        var net = JSON.parse(message.payloadString);
        if (net['bt'] == 1) {
            $('#net_bt').text("bluetooth");
            $('#net_bt').removeClass("red").addClass("green");
        }
        else {
            $('#net_bt').text("bluetooth_disabled");
            $('#net_bt').removeClass("green").addClass("red");
        }
        if (net['wlan0'] == 1) {
            $('#net_wlan0').text("signal_wifi_4_bar");
            $('#net_wlan0').removeClass("red").addClass("green");
        }
        else {
            $('#net_wlan0').text("signal_wifi_off");
            $('#net_wlan0').removeClass("green").addClass("red");
        }
        if (net['eth0'] == 1) {
            $('#net_eth0').text("settings_ethernet");
            $('#net_eth0').removeClass("red").addClass("green");
        }
        else {
            $('#net_eth0').text("settings_ethernet");
            $('#net_eth0').removeClass("green").addClass("red");
        }
        if (net['lora'] == 1) {
            $('#net_lora').text("NETZWERK");
            $('#net_lora').removeClass("red").addClass("green");
        }
        else {
            $('#net_lora').text("not_interested");
            $('#net_lora').removeClass("green").addClass("red");
        }
    }
    if (message.destinationName == "wowa/openwrt/net") {
        var openwrt = JSON.parse(message.payloadString);
        if (openwrt['ap']['up'] == true && openwrt['ap']['disabled'] == false) {
            $('#net_ap').text("cloud");
            $('#net_ap').removeClass("red").addClass("green");
        }
        else {
            $('#net_ap').text("cloud_off");
            $('#net_ap').removeClass("green").addClass("red");
        }
        if (openwrt['lte']['up'] == true && openwrt['lte']['available'] == true) {
            $('#net_lte').text("signal_cellular_4_bar");
            $('#net_lte').removeClass("red").addClass("green");
        }
        else {
            $('#net_lte').text("signal_cellular_off");
            $('#net_lte').removeClass("green").addClass("red");
        }
        if (openwrt['wan']['up'] == true && openwrt['wan']['available'] == true) {
            $('#net_wan').text("wifi_tethering");
            $('#net_wan').removeClass("red").addClass("green");
        }
        else {
            $('#net_wan').text("portable_wifi_off");
            $('#net_wan').removeClass("green").addClass("red");
        }
    }
	if (message.destinationName == "wowa/BMV712") {
		var bmv = JSON.parse(message.payloadString);
		if (bmv['Product_Name']) {
			$('#bmv_name').text(bmv['Product_Name']);
		}
		if (bmv['Restzeit']) {
			$('#bmv_Restzeit').text("Restzeit: " + bmv['Restzeit']);
		}
		if (bmv['Akkuzustand_Prozent']) {
			$('#bmv_Akkuzustand_Prozent').text("Kapazität: " + bmv['Akkuzustand_Prozent'] + " %");
		}
		if (bmv['Spannung_V']) {
			$('#bmv_Spannung_V').text("Spannung: " + bmv['Spannung_V'] + " V");
		}
		if (bmv['Strom_A']) {
			$('#bmv_Strom_A').text("Strom: " + bmv['Strom_A'] + " A");
		}
	}
}