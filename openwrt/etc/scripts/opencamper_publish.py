import os, json, time, commands
import paho.mqtt.client as mqtt

net = {}
mqtt_server = {}
mqtt_server["host"] = "10.10.31.2"
mqtt_server["port"] = 1883
mqtt_server["timeout"] = 60
mqtt_server["username"] = 0
mqtt_server["password"] = 0
mqtt_server["topic"] = "wowa/openwrt/"

def callNetwork(interface, action):
	return commands.getoutput("ubus -S call network."+interface+" "+action)

client = mqtt.Client("openwrt_publish")
client.connect(mqtt_server["host"], mqtt_server["port"], mqtt_server["timeout"])
if mqtt_server["username"] is not 0 and mqtt_server["password"] is not 0:
    client.username_pw_set(mqtt_server["username"], mqtt_server["password"])

while True:
    net["ap"] = json.loads(callNetwork("wireless", "status"))
    net["wan"] = json.loads(callNetwork("interface.wan", "status"))
    net["vpn"] = json.loads(callNetwork("interface.office_itstall_devpn", "status"))
    net["lte"] = json.loads(callNetwork("interface.lte", "status"))
    net["lte"]["signal"] = commands.getoutput("/usr/bin/gcom -d /dev/ttyUSB0 | awk '/Signal Quality:/ {print$3}'").replace(",99", "")

    if(mqtt_server != 0):
        client.publish(mqtt_server['topic'], json.dumps(net))