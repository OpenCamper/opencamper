#!/bin/bash
screen -dm -S watchdog /root/miniconda3/bin/python3 /opt/opencamper/watchdog.py
echo "watchdog started"
