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
screen -list