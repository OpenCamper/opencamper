from __future__ import division
from subprocess import PIPE, Popen
import os, json, time, psutil
import paho.mqtt.client as mqtt

try:
	with open('/opt/opencamper/config.json') as f:
		config = json.load(f)
except KeyError:
	print("No config file found")
	exit()

config_set = "status"
mqtt_server = config[config_set]['mqtt_setting']

data = {}
data['CPU'] = {}
data['RAM'] = {}
data["Disk"] = {}

if(mqtt_server):
    client = mqtt.Client()
    client.loop_start()
    client.connect(config[mqtt_server]['host'], config[mqtt_server]['port'], config[mqtt_server]['timeout'])
    if config[mqtt_server]['username'] is not 0 and config[mqtt_server]['password'] is not 0:
        client.username_pw_set(config[mqtt_server]['username'], config[mqtt_server]['password'])

# Return CPU temperature as a character string                                      
def getCPUtemperature():
    res = os.popen('vcgencmd measure_temp').readline()
    return(float(res.replace("temp=","").replace("'C\n","")))

# Return RAM information (unit=kb) in a list                                        
# Index 0: total RAM                                                                
# Index 1: used RAM                                                                 
# Index 2: free RAM                                                                 
def getRAMinfo():
    p = os.popen('free')
    i = 0
    while 1:
        i = i + 1
        line = p.readline()
        if i==2:
            return(line.split()[1:4])

# Return % of CPU used by user as a character string                                
def getCPUuse():
    return(str(os.popen("top -n1 | awk '/Cpu\(s\):/ {print $2}'").readline().strip(\
)))

# Return information about disk space as a list (unit included)                     
# Index 0: total disk space                                                         
# Index 1: used disk space                                                          
# Index 2: remaining disk space                                                     
# Index 3: percentage of disk used                                                  
def getDiskSpace():
    p = os.popen("df -h /")
    i = 0
    while 1:
        i = i +1
        line = p.readline()
        if i==2:
            return(line.split()[1:5])

while True:
    ram = psutil.virtual_memory()
    disk = getDiskSpace()
    data["CPU"]["temp"] = getCPUtemperature()
    data["CPU"]["usage"] = float(getCPUuse().replace(",","."))
    data["RAM"]["total"] = ram.total / 2**20
    data["RAM"]["used"] = ram.used / 2**20
    data["RAM"]["free"] = ram.free / 2**20
    data["RAM"]["usage"] = ram.percent
    data["Disk"]["total"] = disk[0]
    data["Disk"]["used"] = disk[1]
    data["Disk"]["free"] = disk[2]
    data["Disk"]["usage"] = disk[3].replace("%", "")
    if(config[config_set]["fan_topic"]):
        if(data["CPU"]["temp"] > config[config_set]['cpu_high']):
            client.publish(config[config_set]['fan_topic'] + "2", "100")
        if(data["CPU"]["temp"] < config[config_set]['cpu_low']):
            client.publish(config[config_set]['fan_topic'] + "2", "0")

    mqtt_data = json.dumps(data)
    client.publish(config[config_set]['mqtt_topic'], mqtt_data)
    print(data["CPU"]["temp"])
    time.sleep(config[config_set]['sleep'])