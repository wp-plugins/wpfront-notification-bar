(function() {
    var $ = jQuery;

    //displays the notification bar
    window.wpfront_notification_bar = function(data) {
        var bar = $("#wpfront-notification-bar");

        //set the position
        if (data.position == 1) {
            if (data.fixed_position && data.is_admin_bar_showing)
                bar.css("top", "28px");
            else
                bar.css("top", "0px");
            $("body").prepend(bar);
        }
        else {
            $("body").append(bar.css("bottom", "0px"));
        }

        //for static bar
        var spacer = bar.children(":first");
        spacer.insertBefore(bar);

        var height = bar.height();
        if (data.height > 0) {
            height = data.height;
            bar.find("table, tbody, tr").css("height", "100%");
        }

        bar.height(0).css({"display": "block", "position": (data.fixed_position ? "fixed" : "relative"), "visibility": "visible"});

        //function to set bar height based on options
        var closed = false;
        function setHeight(height, callback) {
            callback = callback || $.noop;
            if (height == 0) {
                if (closed)
                    return;
                closed = true;
            }

            if (height > 0) {
                var fn = callback;
                callback = function() {
                    fn();
                    //set height to auto if in case content wraps on resize
                    if (data.height == 0)
                        bar.height("auto");
                };
            }

            //set animation
            if (data.animate_delay > 0) {
                bar.animate({"height": height + "px"}, data.animate_delay * 1000, "swing", callback);
                if (data.fixed_position)
                    spacer.animate({"height": height + "px"}, data.animate_delay * 1000);
            }
            else {
                bar.height(height);
                if (data.fixed_position)
                    spacer.height(height);
                callback();
            }

        }

        if (data.close_button) {
            bar.find(".wpfront-close").click(function() {
                setHeight(0);
            });
        }

        //close button action
        if (data.button_action_close_bar) {
            bar.find(".wpfront-button").click(function() {
                setHeight(0);
            });
        }

        //set open after seconds and auto close seconds.
        setTimeout(function() {
            setHeight(height, function() {
                if (data.auto_close_after > 0) {
                    setTimeout(function() {
                        setHeight(0);
                    }, data.auto_close_after * 1000);
                }
            });
        }, data.display_after * 1000);
    };
})();