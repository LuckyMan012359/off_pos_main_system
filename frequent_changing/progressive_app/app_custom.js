$( document ).ready(function() {
    "use strict";
    
    let base_url = $("#base_url_custom").val();  
    window.addEventListener('load', () => {
    registerSW();
    });

    async function registerSW() {
    if ('serviceWorker' in navigator) {
        try {
        await navigator
                .serviceWorker
                .register(base_url+'frequent_changing/progressive_app/sw.js');
                console.log('Service worker registered successfully');

        }
        catch (e) {
        console.log('SW registration failed');
        }
    }
    }

    let staticCacheName = "pwa";
    
    let deferredPrompt = '';
    
    window.addEventListener('beforeinstallprompt', (e) => {
        $('.install-app-btn-container').show();
        deferredPrompt = e;
    });

    self.addEventListener("install", function (e) {
    e.waitUntil(
        caches.open(staticCacheName).then(function (cache) {
        return cache.addAll(["/"]);
        })
    );
    });

    self.addEventListener("fetch", function (event) {
        console.log(event.request.url);
    event.respondWith(
        caches.match(event.request).then(function (response) {
        return response || fetch(event.request);
        })
    );
    });
});
