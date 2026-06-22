const CACHE_NAME  = "cache-v2";
const assets = [
    "/",
    "/sources/css/global/init.css"
];

if("serviceWorker" in navigator){
    navigator.serviceWorker.register("./serviceWorker.js");
}

self.addEventListener("install", e=>{
    e.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(assets)
        })
    );
});

self.addEventListener("fetch", (event)=>{
    // console.log(event.request);
});