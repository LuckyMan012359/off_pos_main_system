// Cached core static resources
const contentToCache = [
    "uploads/progressive_app_icons/icon-72x72.png",
    "uploads/progressive_app_icons/icon-96x96.png",
    "uploads/progressive_app_icons/icon-128x128.png",
    "uploads/progressive_app_icons/icon-144x144.png",
    "uploads/progressive_app_icons/icon-152x152.png",
    "uploads/progressive_app_icons/icon-192x192.png",
    "uploads/progressive_app_icons/icon-384x384.png",
    "uploads/progressive_app_icons/icon-512x512.png",
    "uploads/progressive_app_icons/apple-touch-icon.png",
    "uploads/progressive_app_icons/apple-touch-icon-57x57.png",
    "uploads/progressive_app_icons/apple-touch-icon-72x72.png",
    "uploads/progressive_app_icons/apple-touch-icon-76x76.png",
    "uploads/progressive_app_icons/apple-touch-icon-114x114.png",
    "uploads/progressive_app_icons/apple-touch-icon-120x120.png",
    "uploads/progressive_app_icons/apple-touch-icon-144x144.png",
    "uploads/progressive_app_icons/apple-touch-icon-152x152.png",
    "uploads/progressive_app_icons/apple-touch-icon-180x180.png",
    "/manifest.json",
];

const cacheName = "js13kPWA-v1-spescho";
self.addEventListener("install",async (e)=>{
   e.waitUntil((async () => {
      const cache = await caches.open(cacheName);
      await cache.addAll(["/"]);
    })());
});

// Fetch resources
self.addEventListener("fetch",(e)=>{
   e.respondWith(
    (async () => {
      const r = await caches.match(e.request);
      if (r) {
        return r;
      }
      const response = await fetch(e.request);
      const cache = await caches.open(cacheName);
      return response;
    })()
  );
});
self.addEventListener("activate", (e) => {
  e.waitUntil(
    caches.keys().then((keyList) => {
      return Promise.all(
        keyList.map((key) => {
          if (key === cacheName) {
            return;
          }
          return caches.delete(key);
        })
      );
    })
  );
});

