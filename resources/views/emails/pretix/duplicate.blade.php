@component('mail::message')
Hallo,

du hast bei der Bestellung die E-Mail Adresse "{{$email}}" für
mein.podstock.de doppelt hinterlegt.

Bitte prüfe einmal die Angaben und hinterlege für jede\*n
Teilnehmer\*in eine eigene E-Mail Adresse.

Hier dein Login zum Ticketsystem:

https://tickets.podstock.de/podstock/2022/order/{{$order['code']}}/{{$order['secret']}}/

Wo du die Änderung vornehmen kannst. Für Kindertickets (bis 14 Jahre) ist das nicht erforderlich.

Viele Grüße,

Dein Podstock Orga Team
@endcomponent
