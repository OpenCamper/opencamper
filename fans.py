#!/usr/bin/python3
###############################################
# Copyright by IT Stall (www.itstall.de) 2018 #
# Author:   Dennis Eisold                     #
# Created:  28.07.2018                        #
###############################################

import os, json, time, threading
import paho.mqtt.client as mqtt

config_set = "fans"

try:
	with open('/opt/opencamper/config.json') as f:
		config = json.load(f)
except KeyError:
	print("No config file found")
	exit()

fans = {}
fans["1"] = config[config_set]['start_speed_fan1']
fans["2"] = config[config_set]['start_speed_fan2']
fans["3"] = config[config_set]['start_speed_fan3']
fans["4"] = config[config_set]['start_speed_fan4']
fans["5"] = config[config_set]['start_speed_fan5']
fans["6"] = config[config_set]['start_speed_fan6']

mqtt_server = config[config_set]['mqtt_setting']

def setFan(client, fan, speed):
    global fans
    os.system("gridfan set fans "+str(fan)+" speed "+str(speed))
    fans[fan] = speed
    client.publish(config[config_set]['mqtt_status_topic'], json.dumps(fans))

def on_message(client, userdata, msg):
    fan = msg.topic.replace(config[config_set]['mqtt_topic'].replace("+", ""), "")
    setFan(client, fan, str(msg.payload.decode("utf-8")))

def on_subscribe(client, userdata, mid, granted_qos):
    print("Subscribed: "+str(mid)+" "+str(granted_qos))

def status_messages():
    while True:
        client.publish(config[config_set]['mqtt_status_topic'], json.dumps(fans))
        print("Send Status to MQTT")
        time.sleep(config[config_set]['status_sleep'])

def init():
    setFan(client, 1, fans["1"])
    setFan(client, 2, fans["2"])
    setFan(client, 3, fans["3"])
    setFan(client, 4, fans["4"])
    setFan(client, 5, fans["5"])
    setFan(client, 6, fans["6"])
    print("Initialized")

if(mqtt_server):
    client = mqtt.Client()
    client.on_subscribe = on_subscribe
    client.on_message = on_message
    client.connect(config[mqtt_server]['host'], config[mqtt_server]['port'], config[mqtt_server]['timeout'])
    if config[mqtt_server]['username'] is not 0 and config[mqtt_server]['password'] is not 0:
        client.username_pw_set(config[mqtt_server]['username'], config[mqtt_server]['password'])
    init()
    t2 = threading.Thread(target=status_messages)
    t2.start()
    client.subscribe(config[config_set]['mqtt_topic'], qos=0)
    client.loop_forever()
