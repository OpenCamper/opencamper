#!/usr/bin/python3
###############################################
# Copyright by IT Stall (www.itstall.de) 2018 #
# Author:   Dennis Eisold                     #
# Created:  14.08.2018                        #
###############################################

import datetime, time, json, subprocess, sys, time
import paho.mqtt.client as mqtt
from influxdb import InfluxDBClient

try:
    with open('/opt/opencamper/config.json') as f:
        config = json.load(f)
        print("config loaded")
except KeyError:
    print("No config file found")
    exit()

config_set = "mqtt_to_influx"
mqtt_server = config[config_set]['mqtt_setting']
influx_server = config[config_set]['influxdb_setting']

def iterate(dictionary):
    for key, value in dictionary.items():
        if isinstance(value, dict):
            iterate(value)
            continue
    print('key {!r} -> value {!r}'.format(key, value))

def on_connect(client, userdata, flags, rc):
    client.subscribe("wowa/#")

def on_message(client, userdata, msg):
    # Use utc as timestamp
    loaded_json = json.loads(msg.payload.decode("utf-8"))
    isfloatValue=False

    if(msg.topic == "wowa/gyro"):
        print("write to influxDB: gyro")
        json_body = [{
            "measurement": "gyro",
            "fields": {
                "rotation_y": float(abs(loaded_json['rotation_y'])),
                "rotation_x": float(abs(loaded_json['rotation_y']))
            }
        }]
        dbclient.write_points(json_body)
    elif(msg.topic == "wowa/BMV712"):
        print("write to influxDB: BMV712")
        json_body = [{
            "measurement": "BMV712",
            "fields": {
                "Spannung_V": float(loaded_json['Spannung_V']),
                "Strom_A": float(loaded_json['Strom_A']),
                "Akkuzustand_Prozent": float(loaded_json['Akkuzustand_Prozent']),
                "Kapazitaet_entnommen_Ah": float(loaded_json['Kapazitaet_entnommen_Ah'])
            }
        }]
        dbclient.write_points(json_body)
    elif(msg.topic == "wowa/status"):
        print("write to influxDB: status")
        json_body = [{
            "measurement": "status",
            "fields": {
                "CPU_temp": float(loaded_json['CPU']['temp']),
                "CPU_load": float(loaded_json['CPU']['usage']),
                "RAM_usage": float(loaded_json['RAM']['usage']),
                "Disk_usage": float(loaded_json['Disk']['usage'])
            }
        }]
        dbclient.write_points(json_body)
    elif(msg.topic == "wowa/gps"):
        print("write to influxDB: gps")
        json_body = [{
            "measurement": "gps",
            "fields": {
                "lat": float(loaded_json['lat']),
                "lon": float(loaded_json['lon']),
                "sats": float(loaded_json['sats']),
                "speed": float(loaded_json['hspeed'])
            }
        }]
        dbclient.write_points(json_body)
    elif(msg.topic == "wowa/fans/2"):
        print("write to influxDB: fan_2")
        json_body = [{
            "measurement": "fans",
            "fields": {
                "1": float(0),
                "2": float(msg.payload.decode("utf-8")),
                "3": float(0),
                "4": float(0),
                "5": float(0),
                "6": float(0)
            }
        }]
        dbclient.write_points(json_body)

def send_influx(table, field, message):
    try:
        val = float(message)
        isfloatValue=True
    except:
        print("Topic: "+table+" Could not convert " + message + " to a float value")
        isfloatValue=False

    if isfloatValue:
        print("write to influxDB: "+table+":"+field+":"+str(val))
        json_body = [
            {
                "measurement": table,
                "fields": {
                    field: val
                }
            }
        ]

        dbclient.write_points(json_body)

# Set up a client for InfluxDB
print("connect to influx Server: "+ influx_server)
dbclient = InfluxDBClient(config[influx_server]['host'], config[influx_server]['port'], config[influx_server]['username'], config[influx_server]['password'], config[influx_server]['database'])
print("influx connected")
#dbclient = InfluxDBClient(influx_host, influx_port, influx_user, influx_pass, influx_db)

# Initialize the MQTT client that should connect to the Mosquitto broker
if(mqtt_server != 0):
    print("connect to MQTT Server: "+mqtt_server)
    client = mqtt.Client(client_id="", clean_session=True, protocol=eval("mqtt.MQTTv311"))
    client.on_connect = on_connect
    client.on_message = on_message


    connOK = False
    while(connOK == False):
        try:
            client.connect(config[mqtt_server]['host'], config[mqtt_server]['port'], config[mqtt_server]['timeout'])
            if config[mqtt_server]['username'] is not 0 and config[mqtt_server]['password'] is not 0:
                client.username_pw_set(config[mqtt_server]['username'], config[mqtt_server]['password'])
            print("MQTT connected")
            connOK = True
        except:
            connOK = False
        time.sleep(2)

    # Blocking loop to the Mosquitto broker
    client.loop_forever()
else:
    print("No MQTT Server")