import os, json, time, commands
import paho.mqtt.client as mqtt

net = {}
mqtt_server = {}
mqtt_server["host"] = "10.10.31.2"
mqtt_server["port"] = 1883
mqtt_server["timeout"] = 60
mqtt_server["username"] = 0
mqtt_server["password"] = 0
mqtt_server["topic"] = "wowa/openwrt/vpn/"

def setVPN(status):
    if(status == 1):
        os.system("/etc/init.d/openvpn start")
        print("openvpn start")
    if(status == 0):
        os.system("/etc/init.d/openvpn stop")
        print("openvpn stop")

def on_message(client, userdata, msg):
    setVPN(int(msg.payload.decode("utf-8")))

def on_subscribe(client, userdata, mid, granted_qos):
    print("Subscribed: "+str(mid)+" "+str(granted_qos))

client = mqtt.Client("openwrt_subscribe")
client.on_subscribe = on_subscribe
client.on_message = on_message
client.connect(mqtt_server["host"], mqtt_server["port"], mqtt_server["timeout"])
if(mqtt_server["username"] is not 0 and mqtt_server["password"] is not 0):
    client.username_pw_set(mqtt_server["username"], mqtt_server["password"])
client.subscribe(mqtt_server["topic"], qos=0)
client.loop_forever()

if(mqtt_server != 0):
    client.publish(mqtt_server['topic'], json.dumps(net))