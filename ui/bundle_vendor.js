//--- Add NPM Packages - JS ----
import './public_path';

// jquery-ui
window.jQuery = window.$ = require('jquery');

// bootstrap
require('bootstrap');

// babel-polyfill
require('babel-polyfill');

// bootbox
window.bootbox = require('bootbox');

// jquery-ui draggable, resizable & sortable
require('jquery-ui/ui/widgets/resizable');
require('jquery-ui/ui/widgets/draggable');
require('jquery-ui/ui/widgets/droppable');
require('jquery-ui/ui/widgets/sortable');

// jquery-validation
require('jquery-validation');

// bootstrap-colorpicker
require('bootstrap-colorpicker');

// momentjs
window.moment = require('moment');

// moment-timezone
require('moment-timezone');

// moment-jalaali
try {
    // Conditional import for the locale variable
    if( calendar_type && calendar_type == "Jalali") {
        window.moment = require('moment-jalaali');
    }
} catch (e) { //Handle variable not set error
    console.warn('[Warning] loading moment-jalaali: Calendar Type not defined!');
}

// select2
require('select2');

try {
    // Conditional import for the locale variable
    if(jsShortLocale && jsShortLocale != "en-GB" ) {
        require('select2/dist/js/i18n/' + jsLocale + '.js');
    }
} catch (e) { //Handle variable not set error
    console.warn('[Warning] loading select2: Locale not defined!');
}

// Default theme for select2
$.fn.select2.defaults.set("theme", "bootstrap");

// ekko-lightbox
require('ekko-lightbox');

// underscore
window._ = require('underscore/underscore-min.js');

// toastr
window.toastr = require('toastr');

// bootstrap-switch
require('bootstrap-switch');

// bootstrap-slider
require('bootstrap-slider');

// bootstrap-tagsinput
require('bootstrap-tagsinput');

// handlebars
window.Handlebars = require('handlebars/dist/handlebars.min.js');

// colors.js
require('colors.js');

// chart.js
require('chart.js');

// timepicker
require('timepicker');

// form-serializer
require('form-serializer');

// datatables.net
var dt_extras = [
         require("datatables.net"),
         require("datatables.net-bs"),
         require("datatables.net-buttons"),
         require("datatables.net-buttons/js/buttons.colVis.min.js"),
         require("datatables.net-buttons/js/buttons.html5.min.js"),
         require("datatables.net-buttons/js/buttons.print.min.js")
     ];
dt_extras.forEach(function(e) {e(window, window.$);});

// bootstrap-tour
require('bootstrap-tourist/bootstrap-tourist.js');

//--- Add Local JS files ---
// jquery-message-queuing
require('./src/vendor/jquery-message-queuing/jquery.ba-jqmq.min.js');

//leaflet
require('leaflet');
require('leaflet-draw');
require('leaflet-search');
window.L = require('leaflet');

