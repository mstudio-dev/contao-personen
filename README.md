# Mstudio Contao Personen

Erweitert Contao CMS um eine professionelle Personen-Verwaltung mit Frontend-Modulen zur Ausgabe.

## Funktionen

- 👤 **tl_member Erweiterung** - Zusätzliche Felder für Personen
- 📋 **Frontend-Module** - Personenliste und Detail-Reader
- 🎯 **Mitgliedergruppen-Filter** - Kategorisierung über tl_member_group
- 🎨 **Twig & HTML5 Templates** - Moderne, anpassbare Templates
- 🖼️ **Bildintegration** - Profilbild und Hero-Bild
- 📱 **Responsive** - Mobile-optimiert
- 🔄 **Sortierung & Pagination** - Flexible Ausgabeoptionen

## Systemanforderungen

- PHP 8.1 oder höher
- Contao 5.6 oder höher

## Installation

### Via Composer (empfohlen)

```bash
composer require mstudio/contao-personen
```

### Via Contao Manager

1. Suchen Sie im Contao Manager nach `mstudio/contao-personen`
2. Installieren Sie die Erweiterung
3. Führen Sie die Datenbankaktualisierung durch

## Nutzung

### Backend: Personen verwalten

Die Erweiterung nutzt das Contao-Standard-Modul **Mitglieder** (tl_member) und fügt folgende Felder hinzu:

**Personal-Legende:**
- Akademischer Titel (z.B. Dr., Prof.)
- Vorname, Nachname (Standard-Felder, angepasst)
- Qualifikation (z.B. Tierarzt, Fachtierarzt)
- Position (z.B. Geschäftsführer, Leiter)

**Extras-Legende:**
- Profilbild (JPG, PNG, WebP)
- Hero-Bild (Großes Bild für Detailseite)
- Intro (Einleitungstext mit TinyMCE)
- Vita (Lebenslauf mit TinyMCE)

**Kategorisierung:**
Nutzen Sie **Mitgliedergruppen** (tl_member_group) um Personen zu kategorisieren (z.B. "Tierärzte", "Verwaltung", "Team").

### Frontend: Personen anzeigen

#### 1. Personenliste-Modul

**Layout → Module → Neues Modul → Personenliste**

Einstellungen:
- **Mitgliedergruppen**: Wählen Sie eine oder mehrere Gruppen aus
- **Sortierung**: Nach Name, Vorname oder Erstellungsdatum
- **Elemente pro Seite**: 0 = keine Pagination, > 0 = Anzahl pro Seite
- **Template**: Standard oder eigenes Template (mod_person_list)

Ausgabe:
- Grid-Layout mit Profilbildern
- Akademischer Titel + Name
- Qualifikation
- Link zur Detailseite

#### 2. Personen-Reader-Modul

**Layout → Module → Neues Modul → Personen-Reader**

Zeigt die vollständige Detailansicht:
- Hero-Bild (falls vorhanden)
- Profilbild
- Akademischer Titel + Name
- Position und Qualifikation
- Intro-Text
- Vita
- E-Mail-Adresse (falls vorhanden)

**URL-Parameter:** `?show=123` (ID des Mitglieds)

### Template-Anpassung

Die Templates können überschrieben werden:

**Twig-Templates (empfohlen):**
- `templates/mod_person_list.html.twig`
- `templates/mod_person_reader.html.twig`

**HTML5-Templates (Fallback):**
- `templates/mod_person_list.html5`
- `templates/mod_person_reader.html5`

## Technische Details

**Erweiterte tl_member Felder:**
- academicTitle (varchar 64)
- qualification (varchar 255)
- position (varchar 255)
- profileImage (binary 16 - UUID)
- heroImage (binary 16 - UUID)
- intro (mediumtext)
- vita (mediumtext)

**Frontend-Controller:**
- `PersonListController` - SQL-Abfrage mit Mitgliedergruppen-Filter
- `PersonReaderController` - Einzelansicht mit allen Feldern

**Vorteile:**
- ✅ Keine eigenen Tabellen - nutzt Contao-Standard tl_member
- ✅ Zugriffsrechte über Mitgliedergruppen steuerbar
- ✅ Integration mit bestehendem Mitglieder-System
- ✅ Minimaler Footprint

## Lizenz

MIT License

## Autor

**Markus Schnagl**  
✉️ [mail@mstudio.de](mailto:mail@mstudio.de)  
🌐 [mstudio.de](https://mstudio.de)

## Support

Bei Fragen oder Problemen können Sie:

- Ein Issue auf GitHub erstellen
- Eine E-Mail an [mail@mstudio.de](mailto:mail@mstudio.de) senden

## Changelog

### Version 2.0.0
- **BREAKING**: Frontend-Module statt Auflistungs-Modul
- PersonListController mit Mitgliedergruppen-Filter
- PersonReaderController für Detailansicht
- Twig-Templates (mod_person_list.html.twig, mod_person_reader.html.twig)
- Sortierung und Pagination
- Position-Feld hinzugefügt
- Optimierte Backend-Darstellung (w25 für Felder)

### Version 1.0.0
- Initiales Release
- tl_member Erweiterung mit 7 Feldern
- PaletteManipulator Integration
- Deutsche Übersetzung

---

Entwickelt mit 🤖 von [mstudio](https://mstudio.de)
