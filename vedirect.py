#!/usr/bin/python3

###############################################
# Copyright by IT Stall (www.itstall.de) 2018 #
# Author:   Dennis Eisold                     #
# Created:  11.07.2018                        #
###############################################

import sys
from serial import Serial
import paho.mqtt.client as mqtt
import json
import getopt


def main(argv):
    global device
    try:
        opts, args = getopt.getopt(argv, "hd:", ["device="])
    except getopt.GetoptError:
        print('vedirect.py --device <device>')
        sys.exit(2)
    for opt, arg in opts:
        if opt == '-h':
            print('vedirect.py --device <device>')
            sys.exit()
        elif opt in ("-d", "--device"):
            device = arg


if __name__ == "__main__":
    main(sys.argv[1:])

if(device == 'None'):
    print("We need a device to listen on")
    print('vedirect.py --device <device>')
    exit()

try:
    with open('/opt/opencamper/config.json') as f:
        config = json.load(f)
except KeyError:
    print("No config file found")
    exit()

try:
    if(config[device]['protocol']):
        with open('/opt/opencamper/lib/protocols/'+config[device]['protocol']+'.json') as f:
            deviceprotocol = json.load(f)
except KeyError:
    print("No protocol in config specified")
    exit()

try:
    port = Serial(config[device]['port'], config[device]['speed'], rtscts=True, dsrdtr=True)
except ValueError:
    print("Could not connect to Port: " + config[device]['port'])

mqtt_server = config[device]['mqtt_setting']
mqtt_main_server = config[device]['mqtt_main_setting']
if(mqtt_server):
    client = mqtt.Client()
    client.loop_start()
    client.connect(config[mqtt_server]['host'], config[mqtt_server]['port'], config[mqtt_server]['timeout'])
    if config[mqtt_server]['username'] is not 0 and config[mqtt_server]['password'] is not 0:
        client.username_pw_set(config[mqtt_server]['username'], config[mqtt_server]['password'])

if(mqtt_main_server):
    mqtt_main = mqtt.Client()
    mqtt_main.loop_start()
    mqtt_main.connect(config[mqtt_main_server]['host'], config[mqtt_main_server]['port'], config[mqtt_main_server]['timeout'])
    if config[mqtt_main_server]['username'] is not 0 and config[mqtt_main_server]['password'] is not 0:
        mqtt_main.username_pw_set(config[mqtt_main_server]['username'], config[mqtt_main_server]['password'])

data = {}
main = {}
if(config[device]["mqtt_counter"] < 1):
    counter = 0
try:
    while True:
        line = port.readline().strip()
        if line:
            try:
                key, value = [x.strip() for x in line.split()[:2]]
                # If Value is a Checksum, we can ignore it
                if(key.decode("utf-8") != 'Checksum'):
                    # If Key is in protocol specified, we use that one, and looking for calculation and units
                    # If not, we use the received one
                    try:
                        newkey = deviceprotocol['Key'][key.decode("utf-8")]['name']
                    except KeyError:
                        newkey = key.decode("utf-8")

                    # Is a specification for the key values in the protocol?
                    if(newkey in deviceprotocol):
                        try:
                            data[newkey] = deviceprotocol[newkey][str(value.decode("utf-8"))]
                        except KeyError:
                            data[newkey] = value.decode("utf-8")
                    else:
                        data[newkey] = value.decode("utf-8")
                    try:
                        calc = deviceprotocol['Key'][key.decode("utf-8")]['calc']
                        data[newkey] = float(value.decode("utf-8")) / float(calc)
                    except KeyError:
                        calc = 0
                    if(config[device]['mqtt_main_setting']):
                        if(newkey in config[device]['mqtt_main_items']):
                            main[newkey] = data[newkey]
                else:
                    checksum = value.decode("utf-8")
                    client.publish(config[device]['mqtt_topic'], json.dumps(data), int(config[device]['mqtt_qos']))
                    if (mqtt_main_server):
                        if(counter < config[device]["mqtt_counter"]):
                            counter += 1
                        else:
                            mqtt_main.publish(config[device]['mqtt_main_topic'], json.dumps(main), int(config[device]['mqtt_main_qos']))
                            counter = 0
            except ValueError: error = "Malformed Line: {}".format(line)
except KeyboardInterrupt: pass
port.close()
