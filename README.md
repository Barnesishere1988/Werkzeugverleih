Ich erstelle dir eine LAP-Übungsaufgabe, die gezielt darauf ausgelegt ist, deine Arbeitsgeschwindigkeit, dein systematisches Vorgehen und deine Selbstständigkeit bei der PHP-Entwicklung zu verbessern.

Die Aufgabe ist bewusst aus Sicht eines Kunden formuliert, der keine Programmierkenntnisse besitzt. Du musst selbstständig die technischen Anforderungen ableiten, die Datenhaltung planen und eine geeignete Projektstruktur entwickeln. JavaScript ist nicht erforderlich.

# **LAP-Übungsaufgabe – Werkzeugverleih**

Bearbeitungszeit

# **6 Stunden**

Angestrebte Fertigstellung

# **4,5–5 Std.**

Schwierigkeitsgrad

**Mittel bis anspruchsvoll**

Programmiersprache

**PHP, HTML, CSS**

Internetrecherche

Erlaubt

KI-Unterstützung

Nicht erlaubt

## **1. Ausgangssituation**

Das Unternehmen **WerkzeugPro GmbH** verleiht Werkzeuge und Maschinen an Privatpersonen und kleinere Handwerksbetriebe.

Derzeit werden sämtliche Werkzeuge, Kunden und Ausleihen in einer Excel-Tabelle verwaltet. Dabei kommt es regelmäßig zu Fehlern, da Mitarbeiter nicht immer wissen, welche Werkzeuge verfügbar sind und welche bereits zurückgegeben werden sollten.

Die Geschäftsführung möchte daher eine interne Webseite, über die Mitarbeiter den gesamten Werkzeugverleih verwalten können.

Die Anwendung soll einfach zu bedienen, übersichtlich und zuverlässig sein.

## **2. Anforderungen des Kunden**

### **2.1 Anmeldung**

Da die Webseite ausschließlich für Mitarbeiter gedacht ist, sollen sich diese mit einem Benutzernamen und einem Passwort anmelden können.

Personen ohne Anmeldung dürfen keine internen Informationen einsehen oder verändern können.

Ein angemeldeter Mitarbeiter soll sich jederzeit wieder abmelden können.

Für die erstmalige Verwendung soll bereits ein Mitarbeiterkonto vorhanden sein.

### **2.2 Startseite**

Nach der Anmeldung möchte die Geschäftsführung auf einen Blick folgende Informationen sehen:

- Anzahl aller Werkzeuge
- Anzahl verfügbarer Werkzeuge
- Anzahl aktuell verliehener Werkzeuge
- Anzahl überfälliger Ausleihen

Zusätzlich sollen die fünf zuletzt erfassten Ausleihen angezeigt werden.

### **2.3 Werkzeugverwaltung**

Die Mitarbeiter sollen neue Werkzeuge erfassen und bestehende Werkzeuge verwalten können.

Zu jedem Werkzeug werden folgende Informationen benötigt:

| Information    | Beispiel                          |
| -------------- | --------------------------------- |
| Inventarnummer | WZ-001                            |
| Bezeichnung    | Akkuschrauber Bosch               |
| Kategorie      | Elektrowerkzeug                   |
| Beschreibung   | Akkuschrauber inklusive Ladegerät |
| Tagespreis     | 12,50 €                           |

Jedes Werkzeug besitzt eine eindeutige Inventarnummer.

Die Mitarbeiter sollen Werkzeuge hinzufügen, bearbeiten und löschen können. Werkzeuge, für die bereits Ausleihen erfasst wurden, dürfen nicht gelöscht werden.

In der Übersicht soll ersichtlich sein, ob ein Werkzeug aktuell verfügbar oder verliehen ist.

Außerdem möchte der Kunde nach der Bezeichnung oder Inventarnummer suchen und die Werkzeuge nach Kategorie filtern können.

### **2.4 Kundenverwaltung**

Damit nachvollzogen werden kann, an wen ein Werkzeug verliehen wurde, sollen Kundendaten verwaltet werden können.

| Information    | Beispiel         |
| -------------- | ---------------- |
| Vorname        | Max              |
| Nachname       | Mustermann       |
| E-Mail-Adresse | max\@example.com |
| Telefonnummer  | 0664 1234567     |

Kunden sollen hinzugefügt, bearbeitet und in einer Übersicht angezeigt werden können.

Über eine Suchfunktion soll es möglich sein, einen Kunden anhand seines Vor- oder Nachnamens zu finden.

### **2.5 Werkzeugverleih**

Wenn ein Kunde ein Werkzeug ausleiht, möchte der Mitarbeiter eine neue Ausleihe erfassen können.

Dabei sollen folgende Informationen festgehalten werden:

| Information             | Beispiel            |
| ----------------------- | ------------------- |
| Kunde                   | Max Mustermann      |
| Werkzeug                | Akkuschrauber Bosch |
| Ausleihdatum            | 01.12.2026          |
| Geplantes Rückgabedatum | 04.12.2026          |

Bei einer neuen Ausleihe dürfen ausschließlich verfügbare Werkzeuge ausgewählt werden.

Das geplante Rückgabedatum darf nicht vor dem Ausleihdatum liegen. Eine neue Ausleihe beginnt spätestens am aktuellen Tag und gilt ab ihrer Erfassung als aktiv.

Der voraussichtliche Gesamtpreis soll automatisch anhand der Ausleihdauer und des Tagespreises berechnet werden. Der Ausleihtag und der geplante Rückgabetag zählen jeweils als voller Tag.

Spätere Änderungen am Tagespreis eines Werkzeuges dürfen bereits erfasste Ausleihen nicht beeinflussen.

### **2.6 Rückgabe**

Sobald ein Kunde ein Werkzeug zurückbringt, möchte der Mitarbeiter die Rückgabe erfassen können.

Dabei wird das tatsächliche Rückgabedatum festgehalten. Dieses darf weder vor dem Ausleihdatum noch in der Zukunft liegen.

Anhand der tatsächlichen Ausleihdauer soll der endgültige Preis berechnet werden.

Nach der Rückgabe muss das Werkzeug wieder für andere Kunden verfügbar sein.

Eine bereits abgeschlossene Ausleihe darf nicht erneut als zurückgegeben markiert werden.

**Beispiel zur Preisberechnung:**

| Information           | Wert       |
| --------------------- | ---------- |
| Tagespreis            | 12,50 €    |
| Ausleihdatum          | 01.12.2026 |
| Geplante Rückgabe     | 04.12.2026 |
| Tatsächliche Rückgabe | 06.12.2026 |
| Geplanter Preis       | 50,00 €    |
| Endgültiger Preis     | 75,00 €    |

### **2.7 Ausleihübersicht**

Die Mitarbeiter sollen alle bisherigen und aktuellen Ausleihen in einer gemeinsamen Übersicht einsehen können.

Folgende Informationen sollen sichtbar sein:

| Kunde          | Werkzeug        | Ausleihe   | Rückgabe geplant | Status        |
| -------------- | --------------- | ---------- | ---------------- | ------------- |
| Max Mustermann | Akkuschrauber   | 01.12.2026 | 04.12.2026       | Aktiv         |
| Anna Bauer     | Bohrmaschine    | 25.11.2026 | 28.11.2026       | Überfällig    |
| Peter Huber    | Schleifmaschine | 20.11.2026 | 23.11.2026       | Zurückgegeben |

*Beispielansicht mit angenommenem Stichtag 02.12.2026.*

Die verschiedenen Zustände sollen farblich unterscheidbar sein.

Aktiv

Überfällig

Zurückgegeben

Eine Ausleihe gilt als überfällig, wenn das geplante Rückgabedatum überschritten wurde und das Werkzeug noch nicht zurückgegeben wurde.

Die Übersicht soll nach diesen drei Zuständen gefiltert werden können.

Bei abgeschlossenen Ausleihen soll zusätzlich der endgültige Preis ersichtlich sein.

### **2.8 Gestaltung**

Die Geschäftsführung wünscht sich eine moderne, aber schlichte Webseite.

Als Unternehmensfarben sollen Dunkelblau, Weiß und Orange verwendet werden.

**Dunkelblau**

\#1e3a5f

**Weiß**

\#ffffff

**Orange**

\#f59e0b

Die Navigation soll auf allen internen Seiten einheitlich sein. Tabellen, Formulare und Schaltflächen sollen ein zusammenpassendes Erscheinungsbild besitzen.

Die Webseite soll sowohl auf einem Computer als auch auf einem Smartphone verwendbar sein.

### **2.9 Allgemeine Anforderungen**

Alle eingegebenen Informationen sollen dauerhaft gespeichert werden und auch nach einem Neustart des Webservers weiterhin verfügbar sein.

Ungültige oder fehlende Eingaben sollen dem Mitarbeiter durch verständliche Fehlermeldungen mitgeteilt werden.

Bei fehlerhaften Eingaben sollen bereits korrekt ausgefüllte Formularfelder nach Möglichkeit erhalten bleiben.

Die Anwendung soll bei gewöhnlichen Fehlbedienungen nicht abstürzen. Vertrauliche Informationen sollen vor unberechtigtem Zugriff geschützt sein.

## **3. Abgabe**

Am Ende der Bearbeitungszeit soll eine vollständig lauffähige Anwendung vorliegen.

Die Abgabe soll den vollständigen Quellcode, alle für die Inbetriebnahme erforderlichen Dateien, eine kurze Installationsanleitung, die Zugangsdaten eines Testbenutzers und ausreichend Beispieldaten zur Überprüfung der Funktionen enthalten.

# **Separater Trainingsbereich**

Dieser Abschnitt ist kein Bestandteil der Kundenanforderungen, sondern dient dazu, deine Arbeitsweise gezielt zu verbessern.

## **4. Dein Zeitbudget**

Versuche, folgende Zwischenziele einzuhalten. Die konkrete Reihenfolge der Implementierung musst du selbst festlegen.

**Anforderungsanalyse**

00:00 – 00:20

20 Min.

**Technische Planung**

00:20 – 00:45

25 Min.

**Kernfunktionen**

00:45 – 03:00

135 Min.

**Weitere Funktionen und Absicherung**

03:00 – 04:00

60 Min.

**Gestaltung**

04:00 – 04:30

30 Min.

**Testen und Abgabe vorbereiten**

04:30 – 05:00

30 Min.

**Sicherheitsreserve**

05:00 – 06:00

60 Min.

## **5. Persönliche Trainingsregeln**

Halte dich während dieser Prüfungssimulation an folgende Regeln:

- Beginne erst mit dem Programmieren, nachdem du einen Arbeitsplan erstellt hast.
- Teste jede Funktion unmittelbar nach ihrer Fertigstellung.
- Verbringe möglichst nicht mehr als 15 Minuten mit einem einzelnen nicht blockierenden Fehler.
- Recherchiere gezielt nach Syntax und konkreten Fehlermeldungen.
- Implementiere keine ungeforderten Zusatzfunktionen.
- Notiere, welche Tätigkeiten besonders viel Zeit beanspruchen.
- Verwende während der gesamten Bearbeitung keine KI.

## **6. Fortschrittskontrolle**

### **Aufgabenfortschritt**

## **0 %**

0 von 19 Aufgaben abgeschlossen

Aufgabenstellung analysiert

Technische Planung abgeschlossen

Projektgrundgerüst erstellt

Anmeldung und Abmeldung

Startseite

Werkzeugverwaltung

Werkzeugsuche und Filter

Kundenverwaltung

Kundensuche

Ausleihe erfassen

Preisberechnung

Rückgabe erfassen

Ausleihübersicht und Filter

Eingabevalidierung

Zugriffsschutz

Gestaltung

Mobile Darstellung

Gesamttest

Installationsanleitung und Beispieldaten

Checkliste zurücksetzen

## **7. Bewertung nach der Fertigstellung**

Nach der Bearbeitung kannst du mir deinen Quellcode zur Bewertung übermitteln. Ich würde dafür folgendes Bewertungsschema verwenden:

Funktionalität

40 Punkte

Datenhaltung und Datenkonsistenz

15 Punkte

Validierung und Sicherheit

15 Punkte

Codequalität und Wartbarkeit

10 Punkte

Gestaltung und Benutzerfreundlichkeit

10 Punkte

Dokumentation und Abgabe

5 Punkte

Arbeitsweise und Zeitmanagement

5 Punkte

**Gesamtpunktzahl**

**100 Punkte**

Das Bewertungsschema ist von mir für dein Training entwickelt worden und entspricht keinem offiziellen LAP-Bewertungsschlüssel. Auch die Bearbeitungsdauer ist eine Einschätzung und wurde nicht durch eine praktische Implementierung überprüft.

## **8. Auswertung deiner Arbeitsgeschwindigkeit**

### **Zeitprotokoll für die Nachbesprechung**

Trage deine tatsächlich benötigte Zeit ein. Erfasse Recherche und Fehlersuche getrennt von der reinen Programmierzeit, damit keine Zeiten doppelt gezählt werden.

Analyse und Planung

Min.

Projekteinrichtung

Min.

Programmierung

Min.

Internetrecherche

Min.

Fehlersuche

Min.

Gestaltung

Min.

Testen und Dokumentation

Min.

Gesamtzeit

# **0 Std. 0 Min.**

Verbleibende Zeit

# **360 Min.**

Wo hast du am meisten Zeit verloren?

Welche Anforderungen konntest du nicht fertigstellen?

Arbeitsweise auswerten

## **Warum ich diese Aufgabe ausgewählt habe**

| Trainingsziel           | Bestandteil der Aufgabe                                |
| ----------------------- | ------------------------------------------------------ |
| Anforderungsanalyse     | Technische Umsetzung aus Kundenwünschen ableiten       |
| Datenmodellierung       | Werkzeuge, Kunden und Ausleihen miteinander verknüpfen |
| Wiederverwendbarer Code | Mehrere ähnliche Verwaltungsfunktionen                 |
| CRUD-Routine            | Werkzeuge und Kunden verwalten                         |
| Authentifizierung       | Anmeldung und Zugriffsschutz                           |
| Geschäftslogik          | Verfügbarkeit und Rückgabe                             |
| Datumsberechnungen      | Ausleihdauer und Überfälligkeit                        |
| Berechnungen            | Geplanter und endgültiger Preis                        |
| Datenkonsistenz         | Doppelte Ausleihen verhindern                          |
| Effiziente Recherche    | Eigenständige Lösung technischer Probleme              |
| Zeitmanagement          | Unterschiedlich komplexe Anforderungen priorisieren    |

Ich habe bewusst keine Datenbanktechnologie, keine Tabellenstruktur, keine Ordnerstruktur, keinen Pseudocode und keine konkreten PHP-Funktionen vorgegeben.

**Bei dieser ersten Trainingseinheit geht es nicht primär darum, einen Geschwindigkeitsrekord aufzustellen.** Viel wichtiger ist es, herauszufinden, wodurch du Zeit verlierst. Die nächste Übungsaufgabe kann ich anschließend gezielt auf deine festgestellten Schwachstellen ausrichten.