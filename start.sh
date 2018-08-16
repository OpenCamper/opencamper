screen -dm -S gyro /root/miniconda3/bin/python3 /opt/opencamper/gyro.py
echo "gyro started"
screen -dm -S gps /root/miniconda3/bin/python3 /opt/opencamper/gps.py
echo "gps started"
screen -dm -S net_check /root/miniconda3/bin/python3 /opt/opencamper/net_check.py
echo "net_check started"
screen -dm -S system_status /root/miniconda3/bin/python3 /opt/opencamper/system_status.py
echo "system_status started"
screen -dm -S fans /root/miniconda3/bin/python3 /opt/opencamper/fans.py
echo "fans started"
screen -dm -S vedirect /root/miniconda3/bin/python3 /opt/opencamper/vedirect.py --device BMV
echo "vedirect started"
screen -dm -S tpms /opt/go/Projects/Proj1/src/github.com/ricallinson/tpms/examples/tpmssh/tpmssh
echo "tpms started"
screen -dm -S mqtt-to-influx /root/miniconda3/bin/python3 /opt/opencamper/mqtt-to-influx.py
echo "mqtt-to-influx started"
screen -list
