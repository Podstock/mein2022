{
    "name": "Mein Podstock",
    "short_name": "Mein Podstock",
    "icons": [
        {
            "src": "/android-chrome-192x192.png?v=yyL6zP5339",
            "sizes": "192x192",
            "type": "image/png"
        },
        {
            "src": "/android-chrome-512x512.png?v=yyL6zP5339",
            "sizes": "512x512",
            "type": "image/png"
        }
    ],
    "theme_color": "#ffffff",
    "background_color": "#ffffff",
@guest
    "start_url": "{{url('/')}}",
@else
    "start_url": "{{url('/pretix/login/'.auth()->user()->token)}}",
@endguest
    "display": "standalone",
    "scope": "https://mein.podstock.de/"
}
