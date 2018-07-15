#!/usr/bin/python3

###############################################
# Copyright by IT Stall (www.itstall.de) 2018 #
# Author:   Dennis Eisold                     #
# Created:  11.07.2018                        #
###############################################

import subprocess, sys, time, json
import paho.mqtt.client as mqtt

try:
    with open('/opt/opencamper/config.json') as f:
        config = json.load(f)
except KeyError:
    print("No config file found")
    exit()

mqtt_server = config["Gyro"]['mqtt_setting']
mqtt_main_server = config["Gyro"]['mqtt_main_setting']
if(mqtt_server != 0):
    client = mqtt.Client()
    client.loop_start()
    client.connect(config[mqtt_server]['host'], config[mqtt_server]['port'], config[mqtt_server]['timeout'])
    if config[mqtt_server]['username'] is not 0 and config[mqtt_server]['password'] is not 0:
        client.username_pw_set(config[mqtt_server]['username'], config[mqtt_server]['password'])

if(mqtt_main_server != 0):
    mqtt_main = mqtt.Client()
    mqtt_main.loop_start()
    mqtt_main.connect(config[mqtt_main_server]['host'], config[mqtt_main_server]['port'], config[mqtt_main_server]['timeout'])
    if config[mqtt_main_server]['username'] is not 0 and config[mqtt_main_server]['password'] is not 0:
        mqtt_main.username_pw_set(config[mqtt_main_server]['username'], config[mqtt_main_server]['password'])

states = {}
wlan0_state = 0
eth0_state = 0
lora_state = 0
bt_state = 0

while True:
    with open('/sys/class/net/wlan0/operstate') as f:
        wlan0_state = f.read().rstrip()

    with open('/sys/class/net/eth0/operstate') as f:
        eth0_state = f.read().rstrip()

    if(wlan0_state == 'up'):
        states['wlan0'] = 1
    elif(wlan0_state == 'down'):
        states['wlan0'] = 0

    if(eth0_state == 'up'):
        states['eth0'] = 1
    elif(eth0_state == 'down'):
        states['eth0'] = 0

    states['lora'] = 0
    states['bt'] = 1

    if(mqtt_server != 0):
        client.publish(config["net_check"]['mqtt_topic'], json.dumps(states))
    if(mqtt_main_server != 0):
        mqtt_main.publish(config["net_check"]['mqtt_main_topic'], json.dumps(states))

    time.sleep(15)
