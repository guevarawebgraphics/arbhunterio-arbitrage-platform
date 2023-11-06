if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': "<?php echo csrf_token() ?>"
    }
});

$.dashboard = {};

$.dashboard.init = {
    activate: function () {

        
    }
}

$(function () {
    $.dashboard.init.activate();
});
