#!/usr/bin/python3
###############################################
# Copyright by IT Stall (www.itstall.de) 2018 #
# Author:   Dennis Eisold                     #
# Created:  11.07.2018                        #
###############################################

import time
import smbus
import math
import paho.mqtt.client as mqtt
import json

old_x = 0
old_y = 0
config_set = "Gyro"

try:
    with open('/opt/opencamper/config.json') as f:
        config = json.load(f)
except KeyError:
    print("No config file found")
    exit()

mqtt_server = config[config_set]['mqtt_setting']
if(mqtt_server != 0):
    client = mqtt.Client()
    client.loop_start()
    client.connect(config[mqtt_server]['host'], config[mqtt_server]['port'], config[mqtt_server]['timeout'])
    if config[mqtt_server]['username'] is not 0 and config[mqtt_server]['password'] is not 0:
        client.username_pw_set(config[mqtt_server]['username'], config[mqtt_server]['password'])
    time.sleep(2)

def read_byte(reg):
    return bus.read_byte_data(int(config[config_set]["gyro_address"], 16), reg)

def read_word(reg):
    h = bus.read_byte_data(int(config[config_set]["gyro_address"], 16), reg)
    l = bus.read_byte_data(int(config[config_set]["gyro_address"], 16), reg + 1)
    value = (h << 8) + l
    return value

def read_word_2c(reg):
    val = read_word(reg)
    if (val >= 0x8000):
        return -((65535 - val) + 1)
    else:
        return val

def dist(a,b):
    return math.sqrt((a*a)+(b*b))

def get_y_rotation(x,y,z):
    radians = math.atan2(x, dist(y, z))
    return math.degrees(radians)

def get_x_rotation(x,y,z):
    radians = math.atan2(y, dist(x, z))
    return math.degrees(radians)

bus = smbus.SMBus(1)
bus.write_byte_data(int(config[config_set]["gyro_address"], 16), int(config[config_set]["power_mgmt_1"], 16), 0)

while True:
    x_rotation_temp = 0
    y_rotation_temp = 0
    for x in range (0, 51):
        gyroskop_xout = read_word_2c(0x43)
        gyroskop_yout = read_word_2c(0x45)
        gyroskop_zout = read_word_2c(0x47)
        beschleunigung_xout = read_word_2c(0x3b)
        beschleunigung_yout = read_word_2c(0x3d)
        beschleunigung_zout = read_word_2c(0x3f)
        beschleunigung_xout_skaliert = beschleunigung_xout / 16384.0
        beschleunigung_yout_skaliert = beschleunigung_yout / 16384.0
        beschleunigung_zout_skaliert = beschleunigung_zout / 16384.0
        x_rotation = get_x_rotation(beschleunigung_xout_skaliert, beschleunigung_yout_skaliert, beschleunigung_zout_skaliert)
        y_rotation = get_y_rotation(beschleunigung_xout_skaliert, beschleunigung_yout_skaliert, beschleunigung_zout_skaliert)
        x_rotation_temp = x_rotation_temp + x_rotation
        y_rotation_temp = y_rotation_temp + y_rotation

    x_rotation = (int(((x_rotation_temp/50) + config[config_set]["gyro_offset_x"])*100)/100)
    y_rotation = (int(((y_rotation_temp/50) + config[config_set]["gyro_offset_y"])*100)/100)

    diff_x = abs(old_x - x_rotation)
    diff_y = abs(old_y - y_rotation)
    if(diff_x > config[config_set]["gyro_threshold"] or diff_y > config[config_set]["gyro_threshold"]):
        old_x = x_rotation
        old_y = y_rotation

        data = {}
        data["x"] = int(x_rotation*10)/10
        data["y"] = int(y_rotation*10)/10
        mqtt_data = json.dumps(data)
        if(mqtt_server != 0):
            client.publish(config[config_set]['mqtt_topic'], mqtt_data)
