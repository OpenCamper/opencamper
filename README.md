# opencamper

Vor ein paar Wochen haben wir uns einen Wohnwagen zugelegt und natürlich auch angefangen eine wenig Technik einzubauen.
Hierbei ist doch schon ein wenig was zusammengekommen, weshalb ich mich dazu entschlossen habe, das ganze Projekt der Allgemeinheit freizugeben.
Klar ist hier noch lange nicht alles fertig und vieles sicher auch nicht perfekt. Dafür ist aber auch OpenSource da. Wenn euch etwas auffällt, freue ich mich auf einen PR oder ein Issue ;)

Jeder ist eingeladen sich hieran zu beteiligen und das ganze nach zu bauen.
Ich werde auch eine Liste mit der genutzten Hardware zusammen stellen für die die sich nicht so gut auskennen.
Prinzipiell sollte jedoch jeder das ganze, ohne größere Probleme nachbauen können.

So, jetzt will ich euch nicht länger auf die Folter spannen, hier eine Liste mit den Sachen die bereits funktionieren:

| Gerät           | Funktion                                                                    | Status |
| -------------   |:---------------------------------------------------------------------------:| ------:|
| Gyro Sensor     | Digitale Wasserwage (Ausrichten des Campers                                 |  95% |
| GPS             | Wo steht der Camper, fährt er gerade? Wie schnell? (Alarmanlage)            | 100% |
| Netzwerk        | Auslesen der Verbindungen                                                   |  90% |
| BMV712          | Batterie Monitor (sowie Lade/Entlade Strom/Spannung)                        |  95% |
| Router          | Internes Netz / WLAN Client / LTE                                           |  70% |
| TPMS            | Reifendruck / Temperatur Sensoren                                           |  70% |
| Lüftersteuerung | Hierüber werden die Lüfter für den PC Teil sowie den Kühlschrank gesteuert. |  90% |

Ein neues Webinterface, das bisherige läuft noch auf Node-Red was mir für diese Spielereien jedoch zu viel Ressourcen verbraucht.
Hier kommt mit Sicherheit noch einiges mehr dazu, mal schauen was die Zukunft noch so bringt :D
Mit dem Script für den Batteriemonitor kann man die meisten Produkte von Victron Energy auslesen, das ist nicht auf den einen BMV beschränkt.

Die Daten werden alle an einen MQTT Server gesendet und von dort dann abgerufen und verarbeitet. Das hat den Vorteil das das System mit (nahezu) allen Geräten und Betriebssystemen genutzt werden kann.

Im Moment läuft das Ganze auf einem Raspberry 3B. Der ist eigentlich die meiste Zeit damit beschäftigt sich zu langweilen ^^

Hier mal noch ein Bild wie es z.Z. unter Node-Red ausschaut:
![alt text](https://github.com/mcules/opencamper/raw/master/screenshots/Dashboard.JPG)
