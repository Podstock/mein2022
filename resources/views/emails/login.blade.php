@component('mail::message')
Hallo {{$user->name}},

unter folgender Adresse kannst du dich in mein.podstock.de:

https://mein.podstock.de/login/{{$user->token}}

einloggen. Das wird dieses Jahr die zentrale Anlaufstelle
vom Event.

Aktuell sind folgenden Funktionen enthalten:

- Profil- und Projektverwaltung (Mein Profil)
- Teilnehmer\*innen Liste
- Fahrgemeinschaften
- Online Chat 

Wir haben auch noch ein paar Funktionen mehr in Planung
und informieren dich sobald diese freigeschaltet sind.

Noch ein Tipp:

Rufe die Login URL am besten schon mal auf deinem Smartphone
auf und lege die Seite mittels: 

- Optionen "Zum Startbildschirm hinzufügen" (Android)

oder

- Teilen "Zum Home-Bildschirm" (iOS)

ab. Dadurch hast du die Seite wie eine App direkt startbereit.

Viele Grüße,

Dein Podstock Orga Team
@endcomponent
