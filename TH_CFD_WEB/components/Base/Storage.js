'use strict'
var Storage = {
    setItem: function(k, v) {
        localStorage.setItem(k, v);
        var se = document.createEvent("StorageEvent");
        se.initStorageEvent('storage', false, false, k, null, v);
        window.dispatchEvent(se);
    },
    removeItem: function(k) {
        localStorage.removeItem(k);
        var se = document.createEvent("StorageEvent");

        se.initStorageEvent('storage', false, false);
        window.dispatchEvent(se);

    },
    getItem: function(k) {

        return localStorage.getItem(k);
        // var se = document.createEvent("StorageEvent");
        // se.initStorageEvent('storage', false, false);
        // window.dispatchEvent(se);
    }
}
module.exports = Storage;
