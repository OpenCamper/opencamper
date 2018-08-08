#!/usr/bin/python3

###############################################
# Copyright by IT Stall (www.itstall.de) 2018 #
# Author:   Dennis Eisold                     #
# Created:  11.07.2018                        #
###############################################

import gpsd, sys, time, json
import paho.mqtt.client as mqtt

try:
    with open('/opt/opencamper/config.json') as f:
        config = json.load(f)
except KeyError:
    print("No config file found")
    exit()

mqtt_server = config["GPS"]['mqtt_setting']
if(mqtt_server):
    client = mqtt.Client()
    client.loop_start()
    client.connect(config[mqtt_server]['host'], config[mqtt_server]['port'], config[mqtt_server]['timeout'])
    if config[mqtt_server]['username'] is not 0 and config[mqtt_server]['password'] is not 0:
        client.username_pw_set(config[mqtt_server]['username'], config[mqtt_server]['password'])

mqtt_topic = "wowa/gps"

gpsd.connect()
while True:
    packet = gpsd.get_current()
    print(gpsd.get_current())

    data = {}
    data["sats"] = packet.sats
    data["mode"] = packet.mode
    data["lat"] = packet.lat
    data["lon"] = packet.lon
    data["climb"] = packet.climb
    data["hspeed"] = packet.hspeed
    data["track"] = packet.track
    data["alt"] = packet.alt
    mqtt_data = json.dumps(data)
    client.publish(config["GPS"]['mqtt_topic'], mqtt_data)
    if(packet.hspeed > 10):
        time.sleep(0.25)
    elif(packet.hspeed > 1):
        time.sleep(1)
    else:
        time.sleep(30)
