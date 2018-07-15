# Installation von OpenCamper

!!!ACHTUNG!!!

Diese Anleitung ist noch unvollständig. Raspbian kannst du schon nach dieser Anleitung installieren aber bei OpenCamper selbst fehlt noch ein wenig was.

## Raspbian installieren
Zuerst brauchen wir eine Micro SD Karte für das Betriebssystem. Ich habe das ganze auf Rasbian Lite aufgebaut.
Ihr könnt klar auch das "norale" Raspbian nehmen oder ein anderes Linux. Mit dem normalen könnt ihr die Installation genauso aufbauen wie mit dem Lite, bei einem anderen Linux müsst ihr u.U. Anpassungen vornehmen.
Das Lite habe ich verwendet weil ich keine Grafische Oberfläche benötige und mir so den Platz und die Rechenleistung sparen kann.
Für dieses Projekt braucht ihr auch keine Grafische Oberfläche. Wenn ihr Sie jedoch wollt, nehmt das normale Raspbian.

Unter https://downloads.raspberrypi.org/raspbian_lite_latest könnt ihr das Image von Raspbian Lite herunter laden.

Die Zip Datei müsst ihr zuerst entpacken. Unter Windows ist das ja kein Problem ;)
Ihr braucht anschließend die enthaltene .img Datei.

Nun braucht ihr noch ein Tool um das Image auf die SD Karte zu bekommen. Ich nutze dafür gerne Etcher weil es so schön einfach und übersichtlich ist ^^

Geht auf https://etcher.io und sucht euch den Download passend zu eurem Betriebssystem aus. Im Normalfall sollte das richtige System bereits ausgewählt sein.

Wenn das Image heruntergeladen und Etcher gestartet ist, wählt ihr zuerst die .img Datei aus `Select Image` und dann die SD Karte `Select Drive`. Nun noch ein Klick auf `Flash!` und los geht's.
Das ganze Prozedere dauert nun ein paar Minuten, lasst euch den Kaffee schmecken ;)

Nachdem das Image fertig geschrieben ist, richten wir schon mal den SSH Zugang sowie das WLAN ein (falls benötigt).

Ziehe hierzu einmal die SD Karte aus dem Rechner und stecke sie wieder ein damit sie neu erkannt wird.
Jetzt sollte ein neues Laufwerk mit dem Namen `boot` auftauchen.

#### SSH aktivieren
Hierin legen wir nun eine Datei an die ssh heißt. Keine Erweiterung und kein Inhalt. Heißt auch keine ssh.txt o.Ä., der Name darf wirklich nur ssh sein ;)

#### WLAN einrichten
Die WLAN Einrichtung ist schon einwenig kniffeliger aber nicht unmöglich :)
Hierfür legen wir eine Datei wpa_supplicant.conf auf der SD Karte an mit folgendem Inhalt:
```
ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev
update_config=1
country=DE

network={
  ssid="DEINE-SSID"
  psk="PASSWORT"
  key_mgmt=WPA-PSK
}
```

#### Der erste Start
Jetzt ab mit der Karte in den Raspberry PI und Strom dran. Am einfachsten machst du das beim ersten mal mit einem Monitor und einer Tastatur damit du siehst wenn irgendwelche Fehler auftretten.

Herzlichen Glückwunsch, der erste Schritt ist erledigt, dein Raspberry läuft jetzt unter Raspbian :)

Die Zugangsdaten für den Raspberry sind jetzt noch:
* Benutzer: pi
* Passwort: raspberry

Vergesse nicht die noch zu ändern!

## Installation von OpenCamper
Ab jetzt gehts ans eingemachte, jetzt installieren und konfigurieren alle notwendigen Dienste und richten OpenCamper ein.

### Aktuallisieren des Systemes
Schon richtig, hört sich erstmal blöd an aber zuerst aktuallisieren wir die Paketquellen und machen ein System Update.
```
sudo apt-get update && sudo apt-get upgrade
```

### Aktivieren der Schnittstellen
Was uns noch fehlt ist die i2c Schnittstelle, die wird von OpenCamper genutzt um den Gyro abzufragen.
```
sudo raspi-config
```
In dem Menü wählen wir zuerst die `Interfacing Options (5) aus` und dann `I2C (P5)` mit zweimal Enter bestätigen wir das ganze nun.

Das war es hier auch schon, mit `Finish` verlassen wir raspi-config wieder.
Zum übernehmen müssen wir den Raspi einmal neu starten.

### Dienste installieren
```
sudo apt-get install -y php7.0-mysql mysql-server apache2 python3 i2c-tools python3-smbus python3-pip mosquitto git
sudo pip3 install paho-mqtt
```

### OpenCamper herunterladen
Nun können wir OpenCamper runterladen. Nachdem GIT eine geniale Sache ist, nutzen wir das auch dafür ;)
```
sudo git clone https://github.com/mcules/opencamper.git /opt/opencamper
```

### Dienste aktivieren
Für Apache2 gibt es das rewrite Modul, das brauchen wir für OpenCamper, also aktivieren wir das gleich mit und kopieren die Konfiguration.
```
sudo cp /opt/opencamper/install/apache.conf /etc/apache2/sites-available/000-default.conf
sudo a2ensite 000-default
sudo a2enmod rewrite && sudo systemctl restart apache2
```

### Konfigurationsdateien
Konfigs gibt es auch ein paar, die müssen jetzt erstmal kopiert werden:
```

cp /opt/opencamper/www/application/config/config.php.template /opt/opencamper/www/application/config/config.php
cp /opt/opencamper/www/application/config/database.php.template /opt/opencamper/www/application/config/database.php
```
```
mysql -uroot
CREATE DATABASE opencamper;
CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON * . * TO 'newuser'@'localhost';
FLUSH PRIVILEGES;
quit
```
```
mysql -uroot --database opencamper < /opt/opencamper/install/database.sql
```

### System konfigurieren
#### URL festlegen
Zuerst öffnet ihr die Datei /opt/opencamper/www/application/config/config.php und legt eine Domain fest. Für den Anfang reicht hier die IP Adresse eures Raspberrys. Ihr könnt aber auch eine Domain dafür anlegen wenn ihr eine habt ;)
```
$config['base_url'] = 'http://10.10.31.2/';
```

#### Datenbank bekannt machen
In dieser Datei müsst ihr nun eure Zugangsdaten zur Datenbank eintragen:
/opt/opencamper/www/application/config/database.php

Wichtig sind hier folgende Felder:
* hostname (meistens localhost)
* username
* password
* database