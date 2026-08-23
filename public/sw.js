// Service Worker - E-Survey Deli Serdang
// Versi cache dinaikkan setiap kali ada perubahan pada file statis di bawah,
// supaya klien lama otomatis mengambil ulang isi cache yang baru.
const CACHE_VERSION = 'v1';
const CACHE_NAME = `esurvey-static-${CACHE_VERSION}`;

// Hanya aset statis yang aman di-cache. Halaman HTML (dashboard, form, dsb)
// SENGAJA tidak di-cache karena berisi data pengguna, CSRF token, dan status
// login yang harus selalu didapat langsung dari server (network-only).
const PRECACHE_ASSETS = [
    '/manifest.webmanifest',
    '/icons/icon-192x192.png',
    '/icons/icon-512x512.png',
    '/assets/css/app.css',
    '/assets/js/app.js',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => cache.addAll(PRECACHE_ASSETS))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((keys) => Promise.all(
                keys
                    .filter((key) => key.startsWith('esurvey-static-') && key !== CACHE_NAME)
                    .map((key) => caches.delete(key))
            ))
            .then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    const { request } = event;

    // Hanya tangani request GET dari origin yang sama.
    if (request.method !== 'GET' || new URL(request.url).origin !== self.location.origin) {
        return;
    }

    // Navigasi halaman (HTML): selalu ambil dari network.
    // Kalau offline, tampilkan halaman offline sederhana.
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(() => caches.match('/offline.html'))
        );
        return;
    }

    // Aset statis (css/js/gambar/ikon): cache-first, lalu update di background.
    const isStaticAsset = /\.(?:css|js|png|jpg|jpeg|svg|webp|ico|woff2?)$/.test(new URL(request.url).pathname);
    if (isStaticAsset) {
        event.respondWith(
            caches.match(request).then((cached) => {
                const networkFetch = fetch(request)
                    .then((response) => {
                        if (response && response.status === 200) {
                            const clone = response.clone();
                            caches.open(CACHE_NAME).then((cache) => cache.put(request, clone));
                        }
                        return response;
                    })
                    .catch(() => cached);
                return cached || networkFetch;
            })
        );
    }
    // Selain itu (API, dsb): biarkan lewat network seperti biasa.
});
