#!/bin/bash
mosquitto_pub -h 10.10.31.2 -t "wowa/openwrt/net/lte/signal" -m `/usr/bin/gcom -d /dev/ttyUSB0 | awk '/Signal Quality:/ {print$3}'`