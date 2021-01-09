# STROMKONTO
Einbindung des Daten von einem Stromkonto über die [v2.0 REST API](https://corrently.io/). Die native Implementierung des Stromkontos, welche die selbe Schnittstelle nutzt ist unter [stromkonto.net](https://www.stromkonto.net/) zu finden. Das Anlegen und die Nutzung eines Stromkontos ist kostenlos.

### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [WebFront](#6-webfront)
7. [PHP-Befehlsreferenz](#7-php-befehlsreferenz)

### 1. Funktionsumfang

* Abruf der Salden alle 15 Minuten
* Bereitstellen von Soll/Haben/Saldo für Unterkonten
* Implementiert und getestete Kontenarten:
  * GrünstromBonus (WattStunden)
  * Eigenstrom (WattStunden)
  * Erzeugung (WattStunden pro Jahr)
  * CO2 Emission (Gramm)
  * Bäume zur CO2 Kompensierung (Stück)

### 2. Vorraussetzungen

- IP-Symcon ab Version 5.4

### 3. Software-Installation

* Über den Module Store das 'STROMKONTO'-Modul installieren.
* Alternativ über das Module Control folgende URL hinzufügen: https://github.com/energychain/IPS_Stromkonto

### 4. Einrichten der Instanzen in IP-Symcon

 Unter 'Instanz hinzufügen' kann das 'STROMKONTO'-Modul mithilfe des Schnellfilters gefunden werden.  
	- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

__Konfigurationsseite__:

Name     | Beschreibung
-------- | ------------------
account  | Kontonummer/Adresse eines Stromkonto
         |

### 5. Statusvariablen und Profile

Die Statusvariablen/Kategorien werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

### 6. PHP-Befehlsreferenz

`SKO_update(integer $InstanzID);`
Aktualisiert die Daten der Statusvariablen.

Beispiel:
`SKO_update(12345);`
