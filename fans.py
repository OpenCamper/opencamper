#!/usr/bin/python3
###############################################
# Copyright by IT Stall (www.itstall.de) 2018 #
# Author:   Dennis Eisold                     #
# Created:  28.07.2018                        #
###############################################

import os, json, time
import paho.mqtt.client as mqtt

config_set = "fans"
fans = {}
fans["1"] = 0
fans["2"] = 0
fans["3"] = 0
fans["4"] = 0
fans["5"] = 0
fans["6"] = 0

try:
	with open('/opt/opencamper/config.json') as f:
		config = json.load(f)
except KeyError:
	print("No config file found")
	exit()

mqtt_server = config[config_set]['mqtt_setting']

def setFan(fan, speed):
	os.system("gridfan set fans "+fan+" speed "+speed)
	fans[fan] = speed
	client.publish(config[config_set]['mqtt_status_topic'], json.dumps(fans))

def on_message(client, userdata, msg):
    fan = msg.topic.replace(config[config_set]['mqtt_topic'].replace("+", ""), "")
    setFan(fan, str(msg.payload.decode("utf-8")))

def on_subscribe(client, userdata, mid, granted_qos):
    print("Subscribed: "+str(mid)+" "+str(granted_qos))

if(mqtt_server):
    client = mqtt.Client()
    client.on_subscribe = on_subscribe
    client.on_message = on_message
    client.connect(config[mqtt_server]['host'], config[mqtt_server]['port'], config[mqtt_server]['timeout'])
    if config[mqtt_server]['username'] is not 0 and config[mqtt_server]['password'] is not 0:
        client.username_pw_set(config[mqtt_server]['username'], config[mqtt_server]['password'])
    client.subscribe(config[config_set]['mqtt_topic'], qos=0)
    client.loop_forever()