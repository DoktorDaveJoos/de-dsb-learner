<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Module;
use App\Models\Question;
use Illuminate\Database\Seeder;

class IsbModule1QuestionsSeeder extends Seeder
{
    public function run(): void
    {
        $module = Module::firstOrCreate(
            ['slug' => 'm1-informationssicherheitsbeauftragter'],
            [
                'name' => 'M1 - Informationssicherheitsbeauftragter',
                'description' => 'Fragen rund um die Rolle des Informationssicherheitsbeauftragten (ISB): Managementsysteme, Informationssicherheit, ISO 27001 & BSI IT-Grundschutz, Risikomanagement, Führung, Dokumentation, KVP, Betrieb, Audits sowie Notfallmanagement und Business Continuity.',
            ]
        );

        $questions = [
            // === 21.1 - Managementsysteme ===
            [
                'text' => 'Welche Rollen sind in der Zusammenfassung der taktischen Ebene einer Organisation zugeordnet?',
                'explanation' => 'Die taktische (mittlere) Ebene umfasst ISB/ISO, Risk- und Compliance-Manager sowie Abteilungsleiter. Vorstand und Geschäftsführung gehören zur strategischen Ebene („oberste Leitung"), Fachkräfte und Endanwender zur operativen Ebene.',
                'quote' => 'Taktische Ebene: ISB / ISO (Information Security Officer), Risk- / Compliance-Manager, Abteilungsleiter.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.1 – Managementsysteme, Folie 3',
                'answers' => [
                    ['text' => 'ISB / ISO (Information Security Officer)', 'is_correct' => true],
                    ['text' => 'Risk- / Compliance-Manager', 'is_correct' => true],
                    ['text' => 'Abteilungsleiter', 'is_correct' => true],
                    ['text' => 'Vorstand / Geschäftsführung', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Um welchen Zyklus dreht sich im Kern jedes Managementsystem?',
                'explanation' => 'Jedes Managementsystem basiert im Kern auf dem PDCA-Zyklus (Plan-Do-Check-Act) – einem fortlaufenden Kreislauf aus Planen, Umsetzen, Überprüfen und Verbessern.',
                'quote' => 'Im Kern dreht sich alles um den… Plan – Do – Check – Act.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.1 – Managementsysteme, Folie 8',
                'answers' => [
                    ['text' => 'PDCA (Plan-Do-Check-Act)', 'is_correct' => true],
                    ['text' => 'OODA (Observe-Orient-Decide-Act)', 'is_correct' => false],
                    ['text' => 'DMAIC (Define-Measure-Analyze-Improve-Control)', 'is_correct' => false],
                    ['text' => 'IPO (Input-Process-Output)', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Aufgaben ordnet die Zusammenfassung der „Plan"-Phase des PDCA-Zyklus zu?',
                'explanation' => 'In der Plan-Phase liegt die Verantwortung beim Top-Management; es werden Risikovorgaben festgelegt und Beauftragte ernannt. Interne Audits gehören dagegen zur Check-Phase.',
                'quote' => 'Plan: Verantwortung des Top-Managements, Risikovorgaben festlegen, Beauftragten ernennen.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.1 – Managementsysteme, Folie 9',
                'answers' => [
                    ['text' => 'Verantwortung des Top-Managements', 'is_correct' => true],
                    ['text' => 'Risikovorgaben festlegen', 'is_correct' => true],
                    ['text' => 'Beauftragten ernennen', 'is_correct' => true],
                    ['text' => 'Interne Audits durchführen', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Tätigkeiten gehören laut PDCA-Darstellung zur „Check"-Phase?',
                'explanation' => 'Die Check-Phase umfasst Überprüfung und Analyse, Korrektur- und Vorbeugemaßnahmen sowie interne Audits. Die Bereitstellung der notwendigen Ressourcen erfolgt dagegen in der Do-Phase.',
                'quote' => 'Check: Überprüfung und Analyse, Korrekturmaßnahmen, Vorbeugemaßnahmen, Interne Audits.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.1 – Managementsysteme, Folie 9',
                'answers' => [
                    ['text' => 'Überprüfung und Analyse', 'is_correct' => true],
                    ['text' => 'Korrekturmaßnahmen', 'is_correct' => true],
                    ['text' => 'Interne Audits', 'is_correct' => true],
                    ['text' => 'Bereitstellung der notwendigen Ressourcen', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Aus welchen Bestandteilen besteht laut Zusammenfassung ein Managementsystem?',
                'explanation' => 'Ein Managementsystem setzt sich aus Prozessen, Assets, Richtlinien, Verfahren und Maßnahmen zusammen. Gewinnmargen sind kein Bestandteil eines Managementsystems.',
                'quote' => 'Ein Managementsystem besteht aus… Prozessen, Assets, Richtlinien, Verfahren, Maßnahmen.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.1 – Managementsysteme, Folie 7',
                'answers' => [
                    ['text' => 'Prozessen', 'is_correct' => true],
                    ['text' => 'Assets', 'is_correct' => true],
                    ['text' => 'Richtlinien', 'is_correct' => true],
                    ['text' => 'Verfahren und Maßnahmen', 'is_correct' => true],
                    ['text' => 'Gewinnmargen', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Informationen werden benötigt, um das Management von Assets wirksam und effizient zu gestalten?',
                'explanation' => 'Für wirksames Asset-Management werden Kürzel, Name und Beschreibung, Standort, Verantwortlicher sowie Sicherheitsbewertung und Klassifizierung benötigt. Je nach Asset ist dafür der ISB oder der IT-Abteilungsleiter verantwortlich.',
                'quote' => 'Um das Management der Assets wirksam und effizient zu gestalten, benötigen Sie folgende Informationen: Kürzel, Name und Beschreibung, Standort des Assets, Verantwortlicher des Assets, Sicherheitsbewertung und Klassifizierung.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.1 – Managementsysteme, Folie 12',
                'answers' => [
                    ['text' => 'Kürzel', 'is_correct' => true],
                    ['text' => 'Name und Beschreibung', 'is_correct' => true],
                    ['text' => 'Standort des Assets', 'is_correct' => true],
                    ['text' => 'Verantwortlicher des Assets', 'is_correct' => true],
                    ['text' => 'Sicherheitsbewertung und Klassifizierung', 'is_correct' => true],
                    ['text' => 'Anschaffungsrabatt des Lieferanten', 'is_correct' => false],
                ],
            ],

            // === 21.2 - Informationssicherheit ===
            [
                'text' => 'Wie wird der Begriff „Information" in der Zusammenfassung knapp definiert?',
                'explanation' => 'Eine Information ist im Kern „ein Datum mit Bedeutung" – Daten, die in einem bestimmten Kontext zu Wissen werden und Handlungsmöglichkeiten eröffnen. Informationen kommen dabei immer mit einem Trägermedium.',
                'quote' => 'Information: „Daten mit Bedeutung".',
                'source' => 'ISB-Lehrgang, Abschnitt 21.2 – Informationssicherheit, Folie 14',
                'answers' => [
                    ['text' => 'Daten mit Bedeutung', 'is_correct' => true],
                    ['text' => 'Zufällige Zeichenfolgen ohne Kontext', 'is_correct' => false],
                    ['text' => 'Ausschließlich digital gespeicherte Dateien', 'is_correct' => false],
                    ['text' => 'Hardware-Komponenten eines IT-Systems', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Kernschutzziele umfasst die Informationssicherheit?',
                'explanation' => 'Die drei Kernschutzziele (Grundprinzipien) der Informationssicherheit sind Vertraulichkeit, Integrität und Verfügbarkeit. Wirtschaftlichkeit ist kein Schutzziel der Informationssicherheit.',
                'quote' => 'Informationssicherheit: Bewahrung der Vertraulichkeit, Integrität und Verfügbarkeit von Informationen (Grundprinzipien bzw. Schutzziele).',
                'source' => 'ISB-Lehrgang, Abschnitt 21.2 – Informationssicherheit, Folie 14',
                'answers' => [
                    ['text' => 'Vertraulichkeit', 'is_correct' => true],
                    ['text' => 'Integrität', 'is_correct' => true],
                    ['text' => 'Verfügbarkeit', 'is_correct' => true],
                    ['text' => 'Wirtschaftlichkeit', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Merkmale treffen laut Zusammenfassung auf Informationen zu?',
                'explanation' => 'Informationen sind ein immaterielles Gut: mehrfach nutzbar, nicht verbrauchbar, leicht kopierbar und einfach zu transportieren. Sie verbrauchen sich gerade nicht durch ihre Nutzung.',
                'quote' => 'Informationen haben noch weitere Merkmale: Immaterielles Gut, Mehrfach nutzbar, Nicht verbrauchbar, Leicht kopierbar, Rechte der Nutzung erwerbbar, Einfach zu transportieren.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.2 – Informationssicherheit, Folie 16',
                'answers' => [
                    ['text' => 'Immaterielles Gut', 'is_correct' => true],
                    ['text' => 'Mehrfach nutzbar', 'is_correct' => true],
                    ['text' => 'Nicht verbrauchbar', 'is_correct' => true],
                    ['text' => 'Leicht kopierbar', 'is_correct' => true],
                    ['text' => 'Verbraucht sich bei jeder Nutzung', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Maßnahmen dienen laut Zusammenfassung dem Schutz der Integrität?',
                'explanation' => 'Integrität (Unversehrtheit) bedeutet, dass Informationen richtig und vollständig sind. Schutzmaßnahmen sind u.a. die korrekte Verteilung und Kontrolle von Dokumentenrechten, Hash-Funktionen/Prüfsummen sowie Kryptografie. Datenbackups schützen dagegen primär die Verfügbarkeit.',
                'quote' => 'Beispiele von Maßnahmen zum Schutz der Integrität: Dokumentenrechte korrekt verteilen und regelmäßig kontrollieren, Hash-Funktionen oder Prüfsummen, auch hier relevant: Kryptografie.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.2 – Informationssicherheit, Folie 20',
                'answers' => [
                    ['text' => 'Hash-Funktionen oder Prüfsummen', 'is_correct' => true],
                    ['text' => 'Dokumentenrechte korrekt verteilen und kontrollieren', 'is_correct' => true],
                    ['text' => 'Kryptografie', 'is_correct' => true],
                    ['text' => 'Datenbackups', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Was beschreibt das Schutzziel der Verfügbarkeit?',
                'explanation' => 'Verfügbarkeit bedeutet, dass Informationen befugten Nutzern zum richtigen Zeitpunkt zur Verfügung stehen. Typische Maßnahmen sind Datenbackups und die Wartung von Geräten.',
                'quote' => 'Informationen müssen für befugte Nutzer in den richtigen Momenten abrufbar sein.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.2 – Informationssicherheit, Folie 19',
                'answers' => [
                    ['text' => 'Informationen müssen für befugte Nutzer in den richtigen Momenten abrufbar sein', 'is_correct' => true],
                    ['text' => 'Informationen dürfen niemandem zugänglich sein', 'is_correct' => false],
                    ['text' => 'Informationen müssen unveränderbar archiviert werden', 'is_correct' => false],
                    ['text' => 'Informationen müssen ausschließlich verschlüsselt übertragen werden', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Wie entsteht laut Zusammenfassung aus einer Bedrohung und einer Schwachstelle eine konkrete Gefährdung?',
                'explanation' => 'Eine Schwachstelle ist eine Eigenschaft eines Wertes, die durch eine Bedrohung ausgenutzt werden kann. Erst das Zusammentreffen von Bedrohung und Schwachstelle ergibt eine konkrete Gefährdung (Bedrohung + Schwachstelle = Gefährdung). Eine Schwachstelle allein ist noch keine Gefährdung.',
                'quote' => 'Eine Schwachstelle ist eine Eigenschaft eines Wertes, welche durch eine Bedrohung ausgenutzt werden kann. Somit entsteht eine konkrete Gefährdung.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.2 – Informationssicherheit, Folie 22',
                'answers' => [
                    ['text' => 'Eine Bedrohung nutzt eine Schwachstelle (Eigenschaft eines Wertes) aus – daraus entsteht eine Gefährdung', 'is_correct' => true],
                    ['text' => 'Eine Gefährdung entsteht ausschließlich durch höhere Gewalt', 'is_correct' => false],
                    ['text' => 'Bedrohung und Schwachstelle sind Synonyme', 'is_correct' => false],
                    ['text' => 'Eine Schwachstelle allein ist bereits eine Gefährdung', 'is_correct' => false],
                ],
            ],

            // === 21.3 - ISO & BSI IT-Grundschutz ===
            [
                'text' => 'Welche ISO-Norm enthält die Anforderungen an ein Informationssicherheits-Managementsystem (ISMS)?',
                'explanation' => 'ISO 27001 definiert die Anforderungen an ein ISMS (inkl. Annex A mit den IS-Maßnahmen). ISO 27000 liefert Überblick und Terminologie, ISO 27002 die Anleitung zu den Annex-A-Maßnahmen und ISO 27005 die Handhabung von IS-Risiken.',
                'quote' => 'ISO 27001: Informationssicherheitsmanagementsystem – Anforderungen (mit Annex A – IS-Maßnahmen).',
                'source' => 'ISB-Lehrgang, Abschnitt 21.3 – ISO & BSI IT-Grundschutz, Folie 25',
                'answers' => [
                    ['text' => 'ISO 27001', 'is_correct' => true],
                    ['text' => 'ISO 27000', 'is_correct' => false],
                    ['text' => 'ISO 27002', 'is_correct' => false],
                    ['text' => 'ISO 27005', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Wie unterscheidet die Zusammenfassung „Standards" und „Kompendium" des BSI IT-Grundschutz?',
                'explanation' => 'Die BSI-Standards bilden das Fundament für die Informationssicherheit, während das IT-Grundschutz-Kompendium das konkrete Arbeitswerkzeug für jedes Thema ist – mit elementaren Gefährdungen sowie Prozess- und Systembausteinen.',
                'quote' => 'Standards: Fundament für Informationssicherheit. Kompendium: Arbeitswerkzeug für jedes Thema.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.3 – ISO & BSI IT-Grundschutz, Folie 27',
                'answers' => [
                    ['text' => 'Die Standards bilden das Fundament für Informationssicherheit, das Kompendium ist das Arbeitswerkzeug für jedes Thema', 'is_correct' => true],
                    ['text' => 'Das Kompendium bildet das Fundament, die Standards sind das Arbeitswerkzeug', 'is_correct' => false],
                    ['text' => 'Standards und Kompendium sind inhaltlich identisch', 'is_correct' => false],
                    ['text' => 'Die Standards betreffen nur Behörden, das Kompendium nur Unternehmen', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Wie lassen sich die High-Level-Kapitel der ISO 27001 dem PDCA-Zyklus zuordnen?',
                'explanation' => 'Die ISO-27001-Kapitel folgen dem PDCA-Muster: Kapitel 4–6 (Kontext, Führung, Planung) = Plan, 7–8 (Unterstützung, Betrieb) = Do, 9 (Bewertung der Leistung) = Check, 10 (Verbesserung) = Act.',
                'quote' => '4. Kontext der Organisation, 5. Führung, 6. Planung → Plan; 7. Unterstützung, 8. Betrieb → Do; 9. Bewertung der Leistung → Check; 10. Verbesserung → Act.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.3 – ISO & BSI IT-Grundschutz, Folie 26',
                'answers' => [
                    ['text' => 'Kapitel 4–6 (Kontext, Führung, Planung) → Plan', 'is_correct' => true],
                    ['text' => 'Kapitel 7–8 (Unterstützung, Betrieb) → Do', 'is_correct' => true],
                    ['text' => 'Kapitel 9 (Bewertung der Leistung) → Check', 'is_correct' => true],
                    ['text' => 'Kapitel 10 (Verbesserung) → Plan', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'In wie viele Maßnahmen ist Annex A der ISO 27001 gegliedert und in welche Kategorien?',
                'explanation' => 'Laut Zusammenfassung umfasst Annex A der ISO 27001 93 Maßnahmen, unterteilt in vier Kategorien: organisatorische, personenbezogene, physische und technologische Maßnahmen.',
                'quote' => 'Annex A – 93 Maßnahmen, unterteilt in organisatorische, personenbezogene, physische und technologische Maßnahmen.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.3 – ISO & BSI IT-Grundschutz, Folie 26',
                'answers' => [
                    ['text' => '93 Maßnahmen in organisatorische, personenbezogene, physische und technologische Maßnahmen', 'is_correct' => true],
                    ['text' => '114 Maßnahmen in 14 Domänen', 'is_correct' => false],
                    ['text' => '35 Maßnahmen in 4 Schichten', 'is_correct' => false],
                    ['text' => '200 Maßnahmen in 10 Bausteine', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Zuordnungen der BSI-Standards der 200er-Reihe sind korrekt?',
                'explanation' => 'Die BSI-Standards bilden das Fundament: 200-1 (ISMS-Anforderungen), 200-2 (IT-Grundschutz-Methodik), 200-3 (Risikomanagement) und 200-4 (Business Continuity Management). Einen „BSI-Standard 200-5: Datenschutz" gibt es in dieser Aufzählung nicht.',
                'quote' => 'BSI-Standard 200-1: Managementsysteme für Informationssicherheit (ISMS) – Anforderungen; BSI-Standard 200-2: IT-Grundschutz Methodik; BSI-Standard 200-3: Risikomanagement; BSI-Standard 200-4: Business Continuity Management.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.3 – ISO & BSI IT-Grundschutz, Folie 28',
                'answers' => [
                    ['text' => 'BSI-Standard 200-1: Managementsysteme für Informationssicherheit (ISMS) – Anforderungen', 'is_correct' => true],
                    ['text' => 'BSI-Standard 200-2: IT-Grundschutz-Methodik', 'is_correct' => true],
                    ['text' => 'BSI-Standard 200-3: Risikomanagement', 'is_correct' => true],
                    ['text' => 'BSI-Standard 200-4: Business Continuity Management', 'is_correct' => true],
                    ['text' => 'BSI-Standard 200-5: Datenschutz', 'is_correct' => false],
                ],
            ],

            // === 21.4 - Risikomanagement ===
            [
                'text' => 'Aus welchen Schritten besteht laut Überblick die Risikobeurteilung?',
                'explanation' => 'Die Risikobeurteilung besteht aus Risiko-Identifikation, Risiko-Analyse und Risiko-Bewertung. Die Risiko-Behandlung schließt sich daran an, ist aber nicht Teil der Risikobeurteilung.',
                'quote' => 'Risikobeurteilung: Risiko-Identifikation, Risiko-Analyse, Risiko-Bewertung. [Danach folgt die] Risiko-Behandlung.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.4 – Risikomanagement, Folie 31',
                'answers' => [
                    ['text' => 'Risiko-Identifikation', 'is_correct' => true],
                    ['text' => 'Risiko-Analyse', 'is_correct' => true],
                    ['text' => 'Risiko-Bewertung', 'is_correct' => true],
                    ['text' => 'Risiko-Behandlung', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Aussagen zu Risikokriterien sind laut Zusammenfassung korrekt?',
                'explanation' => 'Risikokriterien sind bei jeder Organisation anders. Qualitative Kriterien kommen ohne Zahlen aus und sind schnell umsetzbar; quantitative Kriterien arbeiten mit Zahlen, erfordern mehr Vorarbeit, sind dafür aber genauer.',
                'quote' => 'Dementsprechend gibt es Quantitative sowie Qualitative Risikokriterien. Qualitativ → Keine Zahlen, schnell umzusetzen. Quantitativ → Zahlen, benötigt mehr Vorarbeit, dafür genauer.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.4 – Risikomanagement, Folie 33',
                'answers' => [
                    ['text' => 'Es gibt quantitative und qualitative Risikokriterien', 'is_correct' => true],
                    ['text' => 'Qualitativ: keine Zahlen, schnell umzusetzen', 'is_correct' => true],
                    ['text' => 'Quantitativ: mit Zahlen, mehr Vorarbeit, dafür genauer', 'is_correct' => true],
                    ['text' => 'Risikokriterien sind für alle Organisationen gesetzlich einheitlich vorgeschrieben', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Anhand welcher beiden Dimensionen wird ein Risiko in der Risikomatrix bewertet?',
                'explanation' => 'Die Risikomatrix kombiniert die Auswirkungen/Schadenshöhe (von vernachlässigbar bis existenzbedrohend) mit der Eintrittshäufigkeit (von selten bis sehr häufig) und ergibt daraus die Risikostufen gering, mittel, hoch und sehr hoch.',
                'quote' => 'Risikobewertung anhand der Risikomatrix: Auswirkungen / Schadenshöhe gegen Eintrittshäufigkeit.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.4 – Risikomanagement, Folie 34',
                'answers' => [
                    ['text' => 'Auswirkungen / Schadenshöhe', 'is_correct' => true],
                    ['text' => 'Eintrittshäufigkeit', 'is_correct' => true],
                    ['text' => 'Anzahl der betroffenen Mitarbeiter', 'is_correct' => false],
                    ['text' => 'Alphabetische Sortierung der Assets', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Optionen der Risikobehandlung nennt die Zusammenfassung?',
                'explanation' => 'Die vier Strategien der Risikobehandlung sind Vermeidung (z.B. Umstrukturierung von Prozessen), Reduktion (höherwertige/weitere Maßnahmen), Transfer (Haftungsübertragung, Auslagerung) und Akzeptanz. „Ignorieren" ist keine anerkannte Behandlungsoption.',
                'quote' => 'Risikobehandlung: Vermeidung, Reduktion, Transfer, Akzeptanz.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.4 – Risikomanagement, Folie 35',
                'answers' => [
                    ['text' => 'Vermeidung', 'is_correct' => true],
                    ['text' => 'Reduktion', 'is_correct' => true],
                    ['text' => 'Transfer', 'is_correct' => true],
                    ['text' => 'Akzeptanz', 'is_correct' => true],
                    ['text' => 'Ignorieren', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Wann ist laut Zusammenfassung die Risikobehandlung „Akzeptanz" sinnvoll?',
                'explanation' => 'Akzeptanz kommt z.B. bei speziellen Bedingungen in Frage – etwa wenn der Aufwand zur Risikovermeidung höher wäre als der potenzielle Schaden oder wenn keine wirksamen Gegenmaßnahmen existieren.',
                'quote' => 'Akzeptanz: z.B. bei speziellen Bedingungen, Aufwand zur Risikovermeidung höher als potenzieller Schaden, keine wirksamen Gegenmaßnahmen.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.4 – Risikomanagement, Folie 35',
                'answers' => [
                    ['text' => 'Wenn der Aufwand zur Risikovermeidung höher ist als der potenzielle Schaden oder keine wirksamen Gegenmaßnahmen existieren', 'is_correct' => true],
                    ['text' => 'Immer, da Akzeptanz die günstigste Variante ist', 'is_correct' => false],
                    ['text' => 'Nur wenn das Risiko existenzbedrohend ist', 'is_correct' => false],
                    ['text' => 'Ausschließlich bei gesetzlich vorgeschriebenen Risiken', 'is_correct' => false],
                ],
            ],

            // === 21.5 - Führung und Verantwortung ===
            [
                'text' => 'Wofür ist laut Zusammenfassung die Geschäftsführung / oberste Leitung verantwortlich?',
                'explanation' => 'Die oberste Leitung trägt die Verantwortung für die strategische Ausrichtung, Zielsetzung, das Risikomanagement, die Priorisierung von Sicherheitsmaßnahmen, die Förderung einer angemessenen Sicherheitskultur, die Informationssicherheitsleitlinie sowie die Compliance. Die technische Administration ist eine operative Aufgabe.',
                'quote' => 'Verantwortlich für die Festlegung der strategischen Ausrichtung der Informationssicherheit … Verantwortlich für die Entwicklung und Verabschiedung der Informationssicherheitsleitlinie … Verantwortlich für die Einhaltung von gesetzlichen, regulatorischen und branchenspezifischen Anforderungen.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.5 – Führung und Verantwortung, Folie 37',
                'answers' => [
                    ['text' => 'Festlegung der strategischen Ausrichtung der Informationssicherheit', 'is_correct' => true],
                    ['text' => 'Entwicklung und Verabschiedung der Informationssicherheitsleitlinie', 'is_correct' => true],
                    ['text' => 'Einhaltung gesetzlicher, regulatorischer und branchenspezifischer Anforderungen', 'is_correct' => true],
                    ['text' => 'Förderung einer angemessenen Sicherheitskultur durch Vorleben', 'is_correct' => true],
                    ['text' => 'Die technische Administration der Firewalls', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Wodurch fördert die Geschäftsführung laut Zusammenfassung die Informationssicherheit?',
                'explanation' => 'Die Geschäftsführung fördert die Informationssicherheit, indem sie strategische Sicherheitsziele festlegt, Ressourcen bereitstellt, die Sicherheitskultur vorlebt und unterstützt und wichtige Aspekte wie das Risikomanagement bewertet.',
                'quote' => 'Strategische Sicherheitsziele festlegen, Ressourcen bereitstellt, Sicherheitskultur vorlebt und unterstützt, wichtige Aspekte wie z.B. das Risikomanagement bewertet.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.5 – Führung und Verantwortung, Folie 38',
                'answers' => [
                    ['text' => 'Strategische Sicherheitsziele festlegen', 'is_correct' => true],
                    ['text' => 'Ressourcen bereitstellen', 'is_correct' => true],
                    ['text' => 'Sicherheitskultur vorleben und unterstützen', 'is_correct' => true],
                    ['text' => 'Wichtige Aspekte wie das Risikomanagement bewerten', 'is_correct' => true],
                    ['text' => 'Selbst alle Sicherheitsvorfälle technisch bearbeiten', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Für welche Aufgaben ist das mittlere Management bzw. der ISB verantwortlich?',
                'explanation' => 'Der ISB entwickelt und überwacht die Umsetzung von Sicherheitsrichtlinien, berichtet an die Führungsebene, stellt die Einhaltung gesetzlicher Anforderungen sicher und managt Vorfälle. Für die Durchführung von Audits ist er nicht zuständig.',
                'quote' => 'Aber auch das mittlere Management, wie eben der ISB, ist für einige Aufgaben verantwortlich: Entwickeln und Überwachung der Umsetzung von Sicherheitsrichtlinien, Berichten an die Führungsebene, Sicherstellung der Einhaltung gesetzlicher Anforderungen, Management von Vorfällen.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.5 – Führung und Verantwortung, Folie 39',
                'answers' => [
                    ['text' => 'Entwickeln und Überwachung der Umsetzung von Sicherheitsrichtlinien', 'is_correct' => true],
                    ['text' => 'Berichten an die Führungsebene', 'is_correct' => true],
                    ['text' => 'Sicherstellung der Einhaltung gesetzlicher Anforderungen', 'is_correct' => true],
                    ['text' => 'Management von Vorfällen', 'is_correct' => true],
                    ['text' => 'Durchführung von Audits', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Warum ist der ISB laut Zusammenfassung NICHT für die Durchführung von Audits zuständig?',
                'explanation' => 'Der ISB ist nicht für die Durchführung von Audits zuständig, weil bei Audits die Unabhängigkeit gewährleistet sein muss – man darf seine eigene Arbeit nicht selbst auditieren.',
                'quote' => 'Sie ist NICHT zuständig für die Durchführung von Audits, da Unabhängigkeit gewährleistet werden muss.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.5 – Führung und Verantwortung, Folie 39',
                'answers' => [
                    ['text' => 'Weil die Unabhängigkeit gewährleistet werden muss', 'is_correct' => true],
                    ['text' => 'Weil er dafür fachlich nicht qualifiziert ist', 'is_correct' => false],
                    ['text' => 'Weil Audits ausschließlich der Geschäftsführung obliegen', 'is_correct' => false],
                    ['text' => 'Weil Audits gesetzlich verboten sind', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Aussagen zur Abgrenzung von ISO und CISO sind korrekt?',
                'explanation' => 'Der ISO (Informationssicherheitsbeauftragter) konzentriert sich auf operative Aspekte (Einhaltung der Richtlinien, Umsetzung von Maßnahmen, regelmäßige Audits, Schulung, Incident Response) auf der taktisch/operativen Ebene. Der CISO ist in der Regel ein leitender Angestellter auf strategischer Ebene (Vision, Programm, Planung, Budgetierung).',
                'quote' => 'Informationssicherheitsbeauftragter (ISO): … Taktische / Operative Ebene. Chief Information Security Officer (CISO): … Strategische Ebene.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.5 – Führung und Verantwortung, Folie 40',
                'answers' => [
                    ['text' => 'Der ISO (Informationssicherheitsbeauftragter) agiert auf der taktischen/operativen Ebene', 'is_correct' => true],
                    ['text' => 'Der CISO agiert auf der strategischen Ebene', 'is_correct' => true],
                    ['text' => 'Der CISO ist in der Regel ein leitender Angestellter, verantwortlich für strategische Vision, Planung und Budgetierung', 'is_correct' => true],
                    ['text' => 'Der ISO ist dem CISO grundsätzlich übergeordnet', 'is_correct' => false],
                ],
            ],

            // === 21.6 - Dokumentation und Aufzeichnungen ===
            [
                'text' => 'Wofür sorgt laut Zusammenfassung eine gute Dokumentation?',
                'explanation' => 'Dokumentation ist das Fundament jedes Managementsystems. Eine gute Dokumentation schafft Nachvollziehbarkeit von Entscheidungen, Bewertungen und Sicherheitsmaßnahmen, sichert die Einhaltung gesetzlicher/regulatorischer Anforderungen und liefert Nachweise für Audits.',
                'quote' => 'Eine gute Dokumentation sorgt für: Nachvollziehbarkeit von getroffenen Entscheidungen, Bewertungen und Sicherheitsmaßnahmen, Einhaltung gesetzlicher und regulatorischer Anforderungen, Nachweise für Audits.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.6 – Dokumentation und Aufzeichnungen, Folie 42',
                'answers' => [
                    ['text' => 'Nachvollziehbarkeit von Entscheidungen, Bewertungen und Sicherheitsmaßnahmen', 'is_correct' => true],
                    ['text' => 'Einhaltung gesetzlicher und regulatorischer Anforderungen', 'is_correct' => true],
                    ['text' => 'Nachweise für Audits', 'is_correct' => true],
                    ['text' => 'Automatische Beseitigung aller Risiken', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Reihenfolge bildet der Dokumentenlebenszyklus korrekt ab?',
                'explanation' => 'Der Dokumentenlebenszyklus verläuft von der Erstellung über Entwurf, Überarbeitung, Abstimmung, Freigabe und Verteilung bis hin zu Ungültigkeit, Archivierung und schließlich Löschung.',
                'quote' => 'Erstellung → Entwurf → Überarbeitung → In Abstimmung → Freigegeben → Verteilt → Ungültig → Archiviert → Gelöscht.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.6 – Dokumentation und Aufzeichnungen, Folie 43',
                'answers' => [
                    ['text' => 'Erstellung → Entwurf → Überarbeitung → In Abstimmung → Freigegeben → Verteilt → Ungültig → Archiviert → Gelöscht', 'is_correct' => true],
                    ['text' => 'Erstellung → Freigegeben → Entwurf → Verteilt → Gelöscht', 'is_correct' => false],
                    ['text' => 'Entwurf → Erstellung → Archiviert → Freigegeben → Verteilt', 'is_correct' => false],
                    ['text' => 'Freigegeben → Verteilt → Erstellung → Entwurf → Archiviert', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Dokumente werden laut Zusammenfassung in einem ISMS gebraucht?',
                'explanation' => 'Gebraucht werden u.a. die Leitlinie/Informationssicherheitspolitik, Sicherheitsrichtlinien, Prozessdokumentation, Dokumente aus dem Risikomanagement, die SoA (Statement of Applicability / Erklärung der Anwendbarkeit) sowie Aufzeichnungen.',
                'quote' => 'Leitlinie / Informationssicherheitspolitik, Sicherheitsrichtlinien, Prozessdokumentation, Dokumente aus dem Risikomanagement, SoA / Erklärung der Anwendbarkeit, Aufzeichnungen.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.6 – Dokumentation und Aufzeichnungen, Folie 44',
                'answers' => [
                    ['text' => 'Leitlinie / Informationssicherheitspolitik', 'is_correct' => true],
                    ['text' => 'Sicherheitsrichtlinien', 'is_correct' => true],
                    ['text' => 'SoA / Erklärung der Anwendbarkeit', 'is_correct' => true],
                    ['text' => 'Aufzeichnungen', 'is_correct' => true],
                    ['text' => 'Marketing-Broschüren', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welchen Zweck erfüllen Sicherheitsrichtlinien laut Zusammenfassung?',
                'explanation' => 'Sicherheitsrichtlinien bieten einen klaren Rahmen, sind einfach zu kommunizieren und zu benutzen, dienen dazu gesetzliche Anforderungen zu gewährleisten und sorgen vor allem dafür, dass Mitarbeiter einheitlich handeln können.',
                'quote' => 'Sicherheitsrichtlinien sind dafür da, einen klaren Rahmen zu bieten. … Sie dienen weiterhin dazu, gesetzliche Anforderungen zu gewährleisten. Insbesondere stellen sie jedoch sicher, dass Mitarbeiter einheitlich handeln können.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.6 – Dokumentation und Aufzeichnungen, Folie 45',
                'answers' => [
                    ['text' => 'Sie bieten einen klaren Rahmen', 'is_correct' => true],
                    ['text' => 'Sie stellen sicher, dass Mitarbeiter einheitlich handeln können', 'is_correct' => true],
                    ['text' => 'Sie dienen dazu, gesetzliche Anforderungen zu gewährleisten', 'is_correct' => true],
                    ['text' => 'Sie ersetzen die Geschäftsführung', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Über welche Methoden können Sicherheitsrichtlinien laut Zusammenfassung wirksam kommuniziert werden?',
                'explanation' => 'Die Kommunikationsmethode hängt von Zielgruppe und Intention ab. Möglich sind u.a. formelle Dokumente, Schulungen, das Intranet, E-Mail und Plakate.',
                'quote' => 'Einige Möglichkeiten sind: Formelle Dokumente, Schulungen, Intranet, E-Mail, Plakate, etc.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.6 – Dokumentation und Aufzeichnungen, Folie 46',
                'answers' => [
                    ['text' => 'Formelle Dokumente', 'is_correct' => true],
                    ['text' => 'Schulungen', 'is_correct' => true],
                    ['text' => 'Intranet', 'is_correct' => true],
                    ['text' => 'E-Mail und Plakate', 'is_correct' => true],
                    ['text' => 'Heimliche Beobachtung der Mitarbeiter', 'is_correct' => false],
                ],
            ],

            // === 21.7 - KVP ===
            [
                'text' => 'Was beinhaltet der kontinuierliche Verbesserungsprozess (KVP)?',
                'explanation' => 'Der KVP umfasst die stetige Weiterentwicklung des Managementsystems und der Prozesse, die fortlaufende Optimierung der ISMS-Prozesse inkl. der Sicherheitsprozesse sowie die regelmäßige Überprüfung und Anpassung der Sicherheitsmaßnahmen. Ein ISMS ist nie „fertig".',
                'quote' => 'Dieser beinhaltet: Die stetige Weiterentwicklung des Managementsystems und der Prozesse, Fortlaufende Optimierung der ISMS-Prozesse inkl. der Sicherheitsprozesse, Regelmäßige Überprüfung und Anpassung der Sicherheitsmaßnahmen.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.7 – KVP, Folie 48',
                'answers' => [
                    ['text' => 'Die stetige Weiterentwicklung des Managementsystems und der Prozesse', 'is_correct' => true],
                    ['text' => 'Fortlaufende Optimierung der ISMS-Prozesse inkl. der Sicherheitsprozesse', 'is_correct' => true],
                    ['text' => 'Regelmäßige Überprüfung und Anpassung der Sicherheitsmaßnahmen', 'is_correct' => true],
                    ['text' => 'Einmalige Einrichtung des ISMS ohne weitere Änderungen', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Warum ist eine kontinuierliche Verbesserung laut Zusammenfassung notwendig?',
                'explanation' => 'Da sich Risiken nie vollständig beseitigen lassen, müssen sie regelmäßig überprüft werden – genau dafür sorgt der kontinuierliche Verbesserungsprozess.',
                'quote' => 'Es ist nämlich nie möglich, alle Risiken zu beseitigen. Daher ist es nötig, sie regelmäßig zu überprüfen!',
                'source' => 'ISB-Lehrgang, Abschnitt 21.7 – KVP, Folie 48',
                'answers' => [
                    ['text' => 'Weil es nie möglich ist, alle Risiken zu beseitigen, und sie daher regelmäßig überprüft werden müssen', 'is_correct' => true],
                    ['text' => 'Weil Risiken nach der Ersteinrichtung dauerhaft verschwinden', 'is_correct' => false],
                    ['text' => 'Weil Audits dadurch überflüssig werden', 'is_correct' => false],
                    ['text' => 'Weil dadurch keine Dokumentation mehr nötig ist', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Wie gewährleisten Managementbewertungen laut Zusammenfassung den KVP?',
                'explanation' => 'Managementbewertungen bewerten die Wirksamkeit des ISMS, tragen zur Identifizierung von Verbesserungsmöglichkeiten bei und stellen die Konformität an Compliance-Anforderungen sicher. Damit kann die Geschäftsführung fundierte Entscheidungen treffen.',
                'quote' => 'Managementbewertungen gewährleisten den KVP, indem sie… Die Wirksamkeit des ISMS bewerten, Der Identifizierung von Verbesserungsmöglichkeiten beitragen, Die Konformität an Compliance-Anforderungen sicherstellen.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.7 – KVP, Folie 49',
                'answers' => [
                    ['text' => 'Sie bewerten die Wirksamkeit des ISMS', 'is_correct' => true],
                    ['text' => 'Sie tragen zur Identifizierung von Verbesserungsmöglichkeiten bei', 'is_correct' => true],
                    ['text' => 'Sie stellen die Konformität an Compliance-Anforderungen sicher', 'is_correct' => true],
                    ['text' => 'Sie ersetzen den IT-Grundschutz-Check', 'is_correct' => false],
                ],
            ],

            // === 21.8 - Betrieb, Kommunikation und Lieferanten ===
            [
                'text' => 'Was steht laut Zusammenfassung bei der Betriebssicherheit an oberster Stelle?',
                'explanation' => 'Bei der Betriebssicherheit geht es zuallererst darum, die Betriebsfähigkeit sicherzustellen und Betriebsunterbrechungen zu minimieren. Eine der häufigsten Fehlerquellen sind dabei die Mitarbeiter – daher sind regelmäßige Schulungen besonders wichtig.',
                'quote' => 'Betriebssicherheit: An oberster Stelle muss die Betriebsfähigkeit sichergestellt werden.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.8 – Betrieb, Kommunikation und Lieferanten, Folie 51',
                'answers' => [
                    ['text' => 'Die Betriebsfähigkeit sicherzustellen', 'is_correct' => true],
                    ['text' => 'Die Vertraulichkeit von Kommunikation', 'is_correct' => false],
                    ['text' => 'Die Auswahl neuer Lieferanten', 'is_correct' => false],
                    ['text' => 'Die Erstellung von Marketingmaterial', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Was wird in der Zusammenfassung als eine der häufigsten Fehlerquellen in Unternehmen genannt?',
                'explanation' => 'Mitarbeiter zählen zu den häufigsten Fehlerquellen, weshalb regelmäßige Schulungen an oberster Stelle stehen. Aber auch die Technologie sollte auf einem guten Stand gehalten werden.',
                'quote' => 'Einer der häufigsten Fehlerquellen in Unternehmen sind Mitarbeiter. Daher stehen regelmäßige Schulungen dieser an oberster Stelle.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.8 – Betrieb, Kommunikation und Lieferanten, Folie 51',
                'answers' => [
                    ['text' => 'Die Mitarbeiter', 'is_correct' => true],
                    ['text' => 'Veraltete Gebäude', 'is_correct' => false],
                    ['text' => 'Die Geschäftsführung', 'is_correct' => false],
                    ['text' => 'Externe Auditoren', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Womit befasst sich die Kommunikationssicherheit laut Zusammenfassung?',
                'explanation' => 'Kommunikationssicherheit befasst sich mit der Vertraulichkeit sowie der Integrität und Authentizität der Kommunikation. Verschlüsselung (Kryptografie) ist dabei eines der wichtigsten Werkzeuge.',
                'quote' => 'Die Kommunikationssicherheit befasst sich mit der Vertraulichkeit von Kommunikation. Verschlüsselung (Kryptografie) ist dabei eines der wichtigsten Werkzeuge. Auch kann es hier um die Integrität und Authentizität der Kommunikation gehen.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.8 – Betrieb, Kommunikation und Lieferanten, Folie 51',
                'answers' => [
                    ['text' => 'Mit der Vertraulichkeit von Kommunikation', 'is_correct' => true],
                    ['text' => 'Mit der Integrität und Authentizität der Kommunikation', 'is_correct' => true],
                    ['text' => 'Verschlüsselung (Kryptografie) ist dabei eines der wichtigsten Werkzeuge', 'is_correct' => true],
                    ['text' => 'Mit der physischen Bewachung von Lagerräumen', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Was ist laut Zusammenfassung die beste Methode, um Lieferanten zu kontrollieren?',
                'explanation' => 'Lieferanten kontrolliert man am besten durch regelmäßige Audits ihrer Sicherheitspraktiken. Das reduziert Risiken für die eigene Organisation und kann sogar zu Effizienzsteigerungen führen.',
                'quote' => 'Die beste Methode, um Lieferanten zu kontrollieren, sind regelmäßige Audits derer Sicherheitspraktiken. Dadurch werden Risiken für unsere Organisation reduziert.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.8 – Betrieb, Kommunikation und Lieferanten, Folie 51',
                'answers' => [
                    ['text' => 'Regelmäßige Audits ihrer Sicherheitspraktiken', 'is_correct' => true],
                    ['text' => 'Eine einmalige Vertragsunterschrift', 'is_correct' => false],
                    ['text' => 'Der vollständige Verzicht auf jegliche Zusammenarbeit', 'is_correct' => false],
                    ['text' => 'Ausschließlich mündliche Zusicherungen', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Gesetze muss ein ISB laut Zusammenfassung im Compliance-Management besonders häufig berücksichtigen?',
                'explanation' => 'Im Compliance-Management sind branchenspezifische Gesetze und Standards zu berücksichtigen; als ISB betrachtet man besonders häufig das IT-Sicherheitsgesetz (IT-SiG) und die DSGVO/GDPR.',
                'quote' => 'Einige Gesetze werden als ISB jedoch öfter betrachtet werden müssen, zum Beispiel das IT-Sicherheitsgesetz (IT-SiG) und die DSGVO / GDPR.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.8 – Betrieb, Kommunikation und Lieferanten, Folie 52',
                'answers' => [
                    ['text' => 'Das IT-Sicherheitsgesetz (IT-SiG)', 'is_correct' => true],
                    ['text' => 'Die DSGVO / GDPR', 'is_correct' => true],
                    ['text' => 'Branchenspezifische Gesetze und Standards', 'is_correct' => true],
                    ['text' => 'Das Bundesurlaubsgesetz', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Wie ordnet die Zusammenfassung den Datenschutz im Verhältnis zur Informationssicherheit ein?',
                'explanation' => 'Datenschutz ist eine Unterkategorie der Informationssicherheit und betrifft personenbezogene Daten natürlicher Personen. Die DSGVO fordert u.a. eine Risikobewertung der Informationssysteme und geeignete Schutzmaßnahmen und stärkt Betroffenenrechte (z.B. Auskunft, Löschung).',
                'quote' => 'Der Datenschutz kann als eine Unterkategorie der Informationssicherheit gesehen werden. Hier geht es explizit um Daten von natürlichen Personen, also personenbezogenen Daten.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.8 – Betrieb, Kommunikation und Lieferanten, Folie 53',
                'answers' => [
                    ['text' => 'Als eine Unterkategorie der Informationssicherheit mit Fokus auf personenbezogene Daten', 'is_correct' => true],
                    ['text' => 'Als Oberbegriff, der die gesamte Informationssicherheit umfasst', 'is_correct' => false],
                    ['text' => 'Als völlig unabhängiges Themengebiet ohne Bezug zur Informationssicherheit', 'is_correct' => false],
                    ['text' => 'Als rein technisches IT-Thema ohne rechtlichen Bezug', 'is_correct' => false],
                ],
            ],

            // === 21.9 - Audits und Korrekturmaßnahmen ===
            [
                'text' => 'Wie wird ein Audit in der Zusammenfassung definiert?',
                'explanation' => 'Ein Audit ist ein systematischer, unabhängiger und dokumentierter Prozess zum Erlangen objektiver Nachweise und zu deren objektiver Auswertung, um zu bestimmen, inwieweit Auditkriterien erfüllt sind.',
                'quote' => 'Audits sind ein „Systematischer, unabhängiger und dokumentierter Prozess zum Erlangen von objektiven Nachweisen und zu deren objektiver Auswertung, um zu bestimmen, inwieweit Auditkriterien erfüllt sind."',
                'source' => 'ISB-Lehrgang, Abschnitt 21.9 – Audits und Korrekturmaßnahmen, Folie 55',
                'answers' => [
                    ['text' => 'Ein systematischer, unabhängiger und dokumentierter Prozess zum Erlangen und zur objektiven Auswertung von Nachweisen, um den Erfüllungsgrad von Auditkriterien zu bestimmen', 'is_correct' => true],
                    ['text' => 'Eine spontane, informelle Kontrolle ohne Dokumentation', 'is_correct' => false],
                    ['text' => 'Eine ausschließlich finanzielle Prüfung der Bilanz', 'is_correct' => false],
                    ['text' => 'Eine Schulungsmaßnahme für neue Mitarbeiter', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Zuordnungen der Auditarten sind korrekt?',
                'explanation' => 'Das Erstparteien-Audit (internes Audit) betrifft die eigenen Prozesse, das Zweitparteien-Audit eine andere Organisation (z.B. Lieferanten) und das Drittparteien-Audit eine komplett unabhängige Organisation (Zertifizierungsstelle). Das interne Audit kann theoretisch auch von einer externen Partei übernommen werden.',
                'quote' => 'Erstparteien-Audit: Die Organisation auditiert ihre eigenen Prozesse, wird auch internes Audit genannt. Zweitparteien-Audit: Eine Organisation auditiert direkt eine andere Organisation. Drittparteien-Audit: Eine komplett unabhängige Organisation (Zertifizierungsstelle) auditiert die Organisation.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.9 – Audits und Korrekturmaßnahmen, Folie 56',
                'answers' => [
                    ['text' => 'Erstparteien-Audit = internes Audit (die Organisation auditiert ihre eigenen Prozesse)', 'is_correct' => true],
                    ['text' => 'Zweitparteien-Audit = eine Organisation auditiert direkt eine andere (z.B. Lieferanten)', 'is_correct' => true],
                    ['text' => 'Drittparteien-Audit = eine komplett unabhängige Organisation (Zertifizierungsstelle) auditiert', 'is_correct' => true],
                    ['text' => 'Ein Erstparteien-Audit darf ausschließlich vom BSI durchgeführt werden', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welches ist laut Zusammenfassung das wichtigste Drittparteien-Audit?',
                'explanation' => 'Das wichtigste Drittparteien-Audit (externes Audit) ist das Zertifizierungsaudit, das von einer unabhängigen Zertifizierungsstelle durchgeführt wird.',
                'quote' => 'Das wichtigste Drittparteien-Audit ist das Zertifizierungsaudit.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.9 – Audits und Korrekturmaßnahmen, Folie 56',
                'answers' => [
                    ['text' => 'Das Zertifizierungsaudit', 'is_correct' => true],
                    ['text' => 'Das Follow-up-Audit', 'is_correct' => false],
                    ['text' => 'Das interne Audit', 'is_correct' => false],
                    ['text' => 'Das Produktaudit', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Auditformen nennt die Zusammenfassung?',
                'explanation' => 'Zu den Auditformen zählen Prozessaudits, Systemaudits, Produktaudits, Compliance-Audits und Follow-up-Audits.',
                'quote' => 'Auditformen: Prozessaudits, Systemaudits, Produktaudits, Compliance-Audits, Follow-up-audits.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.9 – Audits und Korrekturmaßnahmen, Folie 57',
                'answers' => [
                    ['text' => 'Prozessaudits', 'is_correct' => true],
                    ['text' => 'Systemaudits', 'is_correct' => true],
                    ['text' => 'Produktaudits', 'is_correct' => true],
                    ['text' => 'Compliance-Audits', 'is_correct' => true],
                    ['text' => 'Follow-up-Audits', 'is_correct' => true],
                    ['text' => 'Marketingaudits', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Art von Auditnachweis gilt laut Zusammenfassung als am zuverlässigsten?',
                'explanation' => 'Die Zuverlässigkeit der Auditnachweise nimmt von Physisch über Mathematisch, Zertifikate, Technisch, Analytisch und Dokumente bis Mündlich ab: Physische Nachweise sind am zuverlässigsten, mündliche am wenigsten.',
                'quote' => 'Zuverlässigkeit von Auditnachweisen [abnehmend]: Physisch, Mathematisch, Zertifikate, Technisch, Analytisch, Dokumente, Mündlich.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.9 – Audits und Korrekturmaßnahmen, Folie 58',
                'answers' => [
                    ['text' => 'Physische Nachweise', 'is_correct' => true],
                    ['text' => 'Mündliche Nachweise', 'is_correct' => false],
                    ['text' => 'Analytische Nachweise', 'is_correct' => false],
                    ['text' => 'Dokumente', 'is_correct' => false],
                ],
            ],

            // === 21.10 - Notfallmanagement und Business Continuity ===
            [
                'text' => 'Welche Grundnormen nennt die Zusammenfassung für das Thema Notfallmanagement und Business Continuity?',
                'explanation' => 'Notfallmanagement und Business Continuity sind oft im BCMS vereint. Die Grundnormen sind ISO 22301 und der BSI-Standard 200-4 (Business Continuity Management).',
                'quote' => 'Die Grundnormen für dieses Thema sind die ISO 22301 und der BSI IT-Grundschutz 200-4.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.10 – Notfallmanagement und BC, Folie 60',
                'answers' => [
                    ['text' => 'ISO 22301', 'is_correct' => true],
                    ['text' => 'BSI IT-Grundschutz 200-4', 'is_correct' => true],
                    ['text' => 'ISO 9001', 'is_correct' => false],
                    ['text' => 'BSI-Standard 200-2', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welches Werkzeug wird im BCMS genutzt, um die Auswirkungen von Unterbrechungen auf das Unternehmen zu bewerten?',
                'explanation' => 'Im Kern geht es im BCMS darum, die Auswirkungen von Unterbrechungen auf das Unternehmen zu bewerten. Dafür wird die Business Impact Analyse (BIA) genutzt.',
                'quote' => 'Im Kern geht es im BCMS darum, die Auswirkungen von Unterbrechungen auf das Unternehmen zu bewerten. Dafür wird die Business Impact Analyse, oder BIA, benutzt.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.10 – Notfallmanagement und BC, Folie 60',
                'answers' => [
                    ['text' => 'Die Business Impact Analyse (BIA)', 'is_correct' => true],
                    ['text' => 'Der IT-Grundschutz-Check', 'is_correct' => false],
                    ['text' => 'Die Risikomatrix', 'is_correct' => false],
                    ['text' => 'Das Penetrationstesting', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Eskalationsreihenfolge bildet das BCMS-Modell korrekt ab?',
                'explanation' => 'Die Eskalation verläuft von der Störung über den Notfall bis zur Krise. Mit jeder Stufe steigen die Schwere der Unterbrechung und die benötigten Maßnahmen.',
                'quote' => 'Störung → [Eskalation] → Notfall → [Eskalation] → Krise.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.10 – Notfallmanagement und BC, Folie 61',
                'answers' => [
                    ['text' => 'Störung → Notfall → Krise', 'is_correct' => true],
                    ['text' => 'Krise → Notfall → Störung', 'is_correct' => false],
                    ['text' => 'Notfall → Störung → Krise', 'is_correct' => false],
                    ['text' => 'Störung → Krise → Notfall', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Was gilt laut Zusammenfassung für die Behandlung von Störungen?',
                'explanation' => 'Eine Störung ist eine betriebliche Unterbrechung, die innerhalb des Normalbetriebs behebbar ist (keine Notfallpläne, keine BAO erforderlich). Ihre Behandlung gehört zum Incidentmanagement, nicht zum BCMS.',
                'quote' => 'Im BCMS geht es nicht um die Behandlung von Störungen! Darum geht es im Incidentmanagement!',
                'source' => 'ISB-Lehrgang, Abschnitt 21.10 – Notfallmanagement und BC, Folie 61',
                'answers' => [
                    ['text' => 'Im BCMS geht es nicht um die Behandlung von Störungen – darum geht es im Incidentmanagement', 'is_correct' => true],
                    ['text' => 'Störungen sind der eigentliche Kern des BCMS', 'is_correct' => false],
                    ['text' => 'Störungen erfordern immer die Ausrufung einer Krise', 'is_correct' => false],
                    ['text' => 'Störungen können nur durch externe Dienstleister behoben werden', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Welche Auflösungen der BCMS-Abkürzungen sind korrekt?',
                'explanation' => 'BIA = Business-Impact-Analyse, RTO = Recovery Time Objective, BAO = Besondere Aufbauorganisation, SPoF = Single Point of Failure. MTPD steht für „Maximum Tolerable Period of Disruption", nicht für „Minimum Tolerable Process Duration".',
                'quote' => 'BIA: Business-Impact-Analyse; BAO: Besondere Aufbauorganisation; SPoF: Single Point of Failure; RTO: Recovery Time Objective; MTPD: Maximum Tolerable Period of Disruption.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.10 – Notfallmanagement und BC, Folie 62',
                'answers' => [
                    ['text' => 'BIA: Business-Impact-Analyse', 'is_correct' => true],
                    ['text' => 'RTO: Recovery Time Objective', 'is_correct' => true],
                    ['text' => 'BAO: Besondere Aufbauorganisation', 'is_correct' => true],
                    ['text' => 'SPoF: Single Point of Failure', 'is_correct' => true],
                    ['text' => 'MTPD: Minimum Tolerable Process Duration', 'is_correct' => false],
                ],
            ],
            [
                'text' => 'Was beschreibt das Recovery Point Objective (RPO) im Notfallmanagement?',
                'explanation' => 'Das RPO (Recovery Point Objective) bezieht sich auf den Zeitpunkt der letzten Datensicherung vor dem Schadensereignis und beschreibt damit den maximal tolerierbaren Datenverlust. Davon zu unterscheiden sind RTO (Recovery Time Objective, Zielzeit der Wiederherstellung), RTA (Recovery Time Actual) und MTPD (maximal tolerierbare Ausfalldauer).',
                'quote' => 'RPO [bezieht sich auf den Zeitpunkt der] letzten Datensicherung [vor dem] Schadensereignis.',
                'source' => 'ISB-Lehrgang, Abschnitt 21.10 – Notfallmanagement und BC, Folie 63',
                'answers' => [
                    ['text' => 'Den maximal tolerierbaren Datenverlust, gemessen am Zeitpunkt der letzten Datensicherung vor dem Schadensereignis', 'is_correct' => true],
                    ['text' => 'Die maximale Zeit bis zur Wiederherstellung des Betriebs', 'is_correct' => false],
                    ['text' => 'Die tatsächlich benötigte Wiederherstellungszeit', 'is_correct' => false],
                    ['text' => 'Die maximal tolerierbare Ausfalldauer insgesamt', 'is_correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $answers = $questionData['answers'];
            unset($questionData['answers']);

            $question = Question::create([
                ...$questionData,
                'module_id' => $module->id,
            ]);

            foreach ($answers as $answerData) {
                Answer::create([
                    ...$answerData,
                    'question_id' => $question->id,
                ]);
            }
        }
    }
}
