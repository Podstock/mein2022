<!-- PWA -->
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=yyL6zP53391">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=yyL6zP53391">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=yyL6zP53391">
<link rel="manifest" href="/site.webmanifest?v=yyL6zP53391" crossorigin="use-credentials">
<link rel="mask-icon" href="/safari-pinned-tab.svg?v=yyL6zP53391" color="#81a540">
<link rel="shortcut icon" href="/favicon.ico?v=yyL6zP53391">
<meta name="apple-mobile-web-app-title" content="Mein Podstock">
<meta name="application-name" content="Mein Podstock">
<meta name="msapplication-TileColor" content="#81a540">
<meta name="theme-color" content="#ffffff">

<!-- Add to homescreen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="yes">

<!-- Add to homescreen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="#81a540">
<meta name="apple-mobile-web-app-title" content="Mein Podstock">

<script type="text/javascript">
    // Initialize the service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js', {
            scope: '.'
        }).then(function(registration) {
            // Registration was successful
            console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
            // registration failed :(
            console.log('Laravel PWA: ServiceWorker registration failed: ', err);
        });
    }
</script>
