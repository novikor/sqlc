(function ($) {
    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
            return null;
        }
        else {
            return decodeURI(results[1]) || 0;
        }
    };

    $.getPredefinedConnection = function () {
        return connections[$.urlParam("predefined")];
    };

    $.triggerEnter = function (selector, interval) {
        selector = selector || 'body';
        interval = interval || 500;
        setTimeout(function () {
            var e = $.Event('keydown');
            e.keyCode = 13; // Enter
            $(selector).trigger(e);
        }, interval);
    };
})(jQuery);