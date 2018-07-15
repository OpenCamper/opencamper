#!/usr/bin/python3

###############################################
# Copyright by IT Stall (www.itstall.de) 2018 #
# Author:   Dennis Eisold                     #
# Created:  11.07.2018                        #
###############################################

import requests
import json
import time
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

def _req_json_rpc(url, session_id, rpcmethod, subsystem, method, **params):
    """Perform one JSON RPC operation."""
    data = json.dumps({"jsonrpc": "2.0", "id": 1, "method": rpcmethod, "params": [session_id, subsystem, method, params]})

    try:
        res = requests.post(url, data=data, timeout=5)

    except (requests.exceptions.ConnectionError, requests.exceptions.Timeout):
        return

    if res.status_code == 200:
        response = res.json()
        if 'error' in response:
            print(response['error']['message'])

        if rpcmethod == "call":
            try:
                return response["result"][1]
            except IndexError:
                return
        else:
            return response["result"]


def _get_session_id(url, username, password):
    """Get the authentication token for the given host+username+password."""
    res = _req_json_rpc(url, "00000000000000000000000000000000", 'call', 'session', 'login', username=username, password=password)
    return res["ubus_rpc_session"]

while True:
    sessionid = _get_session_id(config["openwrt"]['router_url'], config["openwrt"]['router_username'], config["openwrt"]['router_password'])
    lte_result = _req_json_rpc(config["openwrt"]['router_url'], sessionid, 'call', 'network.interface.lte', 'status')
    wan_result = _req_json_rpc(config["openwrt"]['router_url'], sessionid, 'call', 'network.interface.wan', 'status')
    ap_result = _req_json_rpc(config["openwrt"]['router_url'], sessionid, 'call', 'network.wireless', 'status')
    ap_result = ap_result['radio0']

    ap = {}
    if(ap_result['up'] == True and ap_result['disabled'] == False and ap_result['interfaces'][0]['config']['mode'] == 'ap'):
        ap['ssid'] = ap_result['interfaces'][0]['config']['ssid']
        ap['up'] = ap_result['up']
        ap['disabled'] = ap_result['disabled']

    wan = {}
    wan['up'] = wan_result['up']
    wan['available'] = wan_result['available']
    if(wan_result['up'] == True):
        wan['ip'] = wan_result['ipv4-address'][0]['address']
        wan['metric'] = wan_result['metric']

    lte = {}
    lte['up'] = lte_result['up']
    lte['available'] = lte_result['available']
    if(lte_result['up'] == True):
        lte['ip'] = lte_result['ipv4-address'][0]['address']
        lte['metric'] = lte_result['metric']

    net = {}
    net['lte'] = lte
    net['wan'] = wan
    net['ap'] = ap
    if(mqtt_server != 0):
        client.publish(config["openwrt"]['mqtt_topic'], json.dumps(net))
    if(mqtt_main_server != 0):
        mqtt_main.publish(config["openwrt"]['mqtt_main_topic'], json.dumps(net))
    time.sleep(config["openwrt"]['sleep'])