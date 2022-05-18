/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!**************************************************************!*\
  !*** ../demo1/src/js/pages/crud/forms/editors/summernote.js ***!
  \**************************************************************/

// Class definition

var KTSummernoteDemo = function () {
    // Private functions
    var demos = function () {
        $('.summernote').summernote({
            height: 300,
            tabsize: 14,
        });

        $('.caegroyTextArea').summernote({
            height:200,
            tabsize: 2,

            toolbar:[

                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['picture', ['picture']]
            ]
        });
    }

    return {
        // public functions
        init: function() {
            demos();
        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    KTSummernoteDemo.init();
});

/******/ })()
;
//# sourceMappingURL=summernote.js.map
