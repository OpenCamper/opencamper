#!/usr/bin/env bash
screen -dm -S gyro python3 /opt/opencamper/gyro.py
screen -dm -S gps python3 /opt/opencamper/gps.py
screen -dm -S net_check python3 /opt/opencamper/net_check.py
#screen -dm -S openwrt_api python3 /opt/opencamper/openwrt_api.py
#screen -dm -S vedirect python3 /opt/opencamper/vedirect.py --device BMV