#!/usr/bin/python3
###############################################
# Copyright by IT Stall (www.itstall.de) 2018 #
# Author:   Dennis Eisold                     #
# Created:  28.07.2018                        #
###############################################

import os, json, subprocess, shlex, time
import paho.mqtt.client as mqtt

try:
	with open('/opt/opencamper/config.json') as f:
		config = json.load(f)
except KeyError:
	print("No config file found")
	exit()

config_set = "watchdog"
mqtt_server = config[config_set]['mqtt_setting']
data = {}
if(mqtt_server):
    client = mqtt.Client()
    client.connect(config[mqtt_server]['host'], config[mqtt_server]['port'], config[mqtt_server]['timeout'])
    if config[mqtt_server]['username'] is not 0 and config[mqtt_server]['password'] is not 0:
        client.username_pw_set(config[mqtt_server]['username'], config[mqtt_server]['password'])

def screen_present(process_name):
    screens = subprocess.check_output(["screen -ls; true"], shell=True)
    if ("." + process_name + "\t(" in screens.decode('utf-8')):
        data[process_name] = 1
    else:
        data[process_name] = 0
        print("Starting process: " + process_name + " command: " + config[config_set]['processes'][process_name])
        args = shlex.split(config[config_set]['processes'][process_name])
        subprocess.call(args)
        time.sleep(3)
        return 0

while True:
    for process_name in config[config_set]['processes']:
        if(config[config_set]['processes'][process_name] != 0):
            screen_present(process_name)

    print(data)
    client.publish(config[config_set]['mqtt_topic'], json.dumps(data))
    time.sleep(config[config_set]['check_delay'])