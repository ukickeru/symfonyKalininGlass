"use strict";

/*
 * Custom scripts
 */

$(document).ready(function() {

    window.testApi = function(type, url, data, responseType) {
        $.ajax({
            type: type,
            url: url,
            data: data,
            success: function(response) {
                console.log("Ответ: "+response);
            },
            dataType: responseType
        });
    }

});