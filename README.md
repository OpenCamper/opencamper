# opencamper

Vor ein paar Wochen haben wir uns einen Wohnwagen zugelegt und natürlich auch angefangen eine wenig Technik einzubauen.
Hierbei ist doch schon ein wenig was zusammengekommen, weshalb ich mich dazu entschlossen habe, das ganze Projekt der Allgemeinheit freizugeben.
Klar ist hier noch lange nicht alles fertig und vieles sicher auch nicht perfekt. Dafür ist aber auch OpenSource da. Wenn euch etwas auffällt, freue ich mich auf einen PR oder ein Issue ;)

Jeder ist eingeladen sich hieran zu beteiligen und das ganze nach zu bauen.
Ich werde auch eine Liste mit der genutzten Hardware zusammen stellen für die die sich nicht so gut auskennen.
Prinzipiell sollte jedoch jeder das ganze, ohne größere Probleme nachbauen können.

**[Neu ist jetzt auch eine kleine Anleitung zur Installation ;)](https://github.com/mcules/opencamper/blob/master/INSTALL.md)**

So, jetzt will ich euch nicht länger auf die Folter spannen, hier eine Liste mit den Sachen die bereits funktionieren oder verbaut wurden:

| Gerät/Script    | Funktion                                                                     | Status | Link |
| -------------   |:---------------------------------------------------------------------------:| ------:| -----:|
| Gyro Sensor     | Digitale Wasserwage (Ausrichten des Campers                                  |  100% |https://amzn.to/2mFJRla(*)|
| GPS             | Wo steht der Camper, fährt er gerade? Wie schnell? (Alarmanlage)             | 100% |https://amzn.to/2uvKEJ1(*)|
| Netzwerk        | Auslesen der Verbindungen                                                    |  95% ||
| BMV             | Batterie Monitor (sowie Lade/Entlade Strom/Spannung)                         | 100% |https://amzn.to/2mgoxm0(*)|
| Router          | Internes Netz / WLAN Client / LTE                                            |  75% |https://amzn.to/2unNpwz(*)|
| LTE Stick       | Dieser baut die Verbindung ins Internet auf wenn kein WLAN in Reichweite ist | 100% |https://amzn.to/2uoR8dc(*)|
| TPMS            | Reifendruck / Temperatur Sensoren                                            |  70% |https://amzn.to/2mi9R61(*)|
| Lüftersteuerung | Hierüber werden die Lüfter für den PC Teil sowie den Kühlschrank gesteuert.  |  90% |https://amzn.to/2mmPFQx(*)|
| VPN Client      | Remote den Camper in einen VPN Server einwählen lassen wenn man ihn braucht (Hierfür braucht der Camper eine Internet-Verbindung, kann WLAN oder auch LTE sein) |   30% ||
| Spannungswandler | Nachdem ich ein 24v System im Camper habe, hab ich mir hier was gegönnt. 2x70A Wandler von 24v auf 12v. Können über die Software an und abgeschalten werden. | 100% |https://amzn.to/2uu54So(*)|
| Sicherungskasten | Irgendwie sollte man die Geräte ja absichern. Ich empfehle hier für jedes Gerät eine eigene Sicherung | --- | https://amzn.to/2A2VCLR(*) |
| Raspberry PI | Das Herz des ganzen Projektes | --- | https://amzn.to/2Lewg2Z(*) |
| Step Down | Eine kleine Platine die euch aus euren 12-24v 5v für den PI macht. Hierfür gibt es auch eine kleine Haöterung zum selbst drucken (https://github.com/mcules/opencamper/blob/master/3D%20Models/XY-3606.stl)| --- | https://amzn.to/2uJ2EjN(*) |
| Gehäuse | Hier habe ich den PI usw. verbaut damit alles ein wenig seine Ordnung hat und nicht beschädigt werden kann. | --- | https://amzn.to/2A4BMQo(*) |
| RJ45 Buchse | Die braucht man vielleicht nicht umbedingt, jedoch wollte ich alle Verbindungen Steckbar haben damit ich das komplette Gehäuse auch einfach einmal abnehmen kann ohne zu viel gefrickel | --- | https://amzn.to/2uK1IvM(*) |
| USB Buchse | Das gleiche wie bei der RJ45 Buchse ;) | --- | https://amzn.to/2A4JQkj(*) |
| 40mm Lüfter | Von diesen Lüftern habe ich zwei in das Gehäuse eingebaut um die Wärme ab zu transportieren | --- | https://amzn.to/2uJff6C(*) |
| Staubfilter | Abdeckung und Staubfilter für die beiden 40mm Lüfter | --- | https://amzn.to/2A0FRFt(*) |

Für die Lüftersteuerung habe ich folgende Lüfter genommen: https://amzn.to/2LfjA7H(*) Die sind schön leise, fast unhörbar. Das war mir die ca 14€ pro Lüfter doch wert.

Ein neues Webinterface, das bisherige läuft noch auf Node-Red was mir für diese Spielereien jedoch zu viel Ressourcen verbraucht.
Hier kommt mit Sicherheit noch einiges mehr dazu, mal schauen was die Zukunft noch so bringt :D
Mit dem Script für den Batteriemonitor kann man die meisten Produkte von Victron Energy auslesen, das ist nicht auf den einen BMV beschränkt.

Die Daten werden alle an einen MQTT Server gesendet und von dort dann abgerufen und verarbeitet. Das hat den Vorteil das das System mit (nahezu) allen Geräten und Betriebssystemen genutzt werden kann.

Im Moment läuft das Ganze auf einem Raspberry 3B. Der ist eigentlich die meiste Zeit damit beschäftigt sich zu langweilen ^^

Hier mal noch ein Bild wie es z.Z. unter Node-Red ausschaut:
![alt text](https://github.com/mcules/opencamper/raw/master/screenshots/Dashboard.JPG)

Die mit Sternchen (*) gekennzeichneten Links sind sogenannte Affiliate-Links. Hier bin ich gaaanz unverschämt. Wenn du über diesen Link etwas kaufst, erhalte ich eine kleine Provision. Dieses Geld verwende ich für neue Hardware etc. um die Entwicklung ein wenig günstiger werden zu lassen (meine Regierung steigt mir sonst bald aufs Dach ;) ). Aber keine Angst, der Preis ändert sich für dich absolut nicht. Du zahlst mit oder ohne Link den selben Preis.
