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

try:
    with open('/opt/opencamper/config.json') as f:
        config = json.load(f)
except KeyError:
    print("No config file found")
    exit()

mqtt_server = config["Gyro"]['mqtt_setting']
if(mqtt_server != 0):
    client = mqtt.Client()
    client.loop_start()
    client.connect(config[mqtt_server]['host'], config[mqtt_server]['port'], config[mqtt_server]['timeout'])
    if config[mqtt_server]['username'] is not 0 and config[mqtt_server]['password'] is not 0:
        client.username_pw_set(config[mqtt_server]['username'], config[mqtt_server]['password'])

mqtt_main_server = config["Gyro"]['mqtt_main_setting']
if(mqtt_main_server != 0):
    mqtt_main = mqtt.Client()
    mqtt_main.loop_start()
    mqtt_main.connect(config[mqtt_main_server]['host'], config[mqtt_main_server]['port'], config[mqtt_main_server]['timeout'])
    if config[mqtt_main_server]['username'] is not 0 and config[mqtt_main_server]['password'] is not 0:
        mqtt_main.username_pw_set(config[mqtt_main_server]['username'], config[mqtt_main_server]['password'])


def read_byte(reg):
    return bus.read_byte_data(int(config["Gyro"]["gyro_address"], 16), reg)

def read_word(reg):
    h = bus.read_byte_data(int(config["Gyro"]["gyro_address"], 16), reg)
    l = bus.read_byte_data(int(config["Gyro"]["gyro_address"], 16), reg + 1)
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
    return -math.degrees(radians)

def get_x_rotation(x,y,z):
    radians = math.atan2(y, dist(x, z))
    return math.degrees(radians)

bus = smbus.SMBus(1)
bus.write_byte_data(int(config["Gyro"]["gyro_address"], 16), int(config["Gyro"]["power_mgmt_1"], 16), 0)

while True:
    time.sleep(config["Gyro"]['sleep'])
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

    x_rotation = x_rotation_temp/50
    y_rotation = y_rotation_temp/50
    data = {}
    data["rotation_x"] = (int((x_rotation + config["Gyro"]["offset_x"])*10)/10)
    data["rotation_y"] = (int((y_rotation + config["Gyro"]["offset_y"])*10)/10)
    mqtt_data = json.dumps(data)
    if(mqtt_server != 0):
        client.publish(config["Gyro"]['mqtt_topic'], mqtt_data)
    if(mqtt_main_server != 0):
        mqtt_main.publish(config["Gyro"]['mqtt_main_topic'], mqtt_data)
