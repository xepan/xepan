
(function($) {
    // Attrs
    $.fn.attrs = function(attrs) {
        var t = $(this);
        if (attrs) {
            // Set attributes
            t.each(function(i, e) {
                var j = $(e);
                for (var attr in attrs) {
                    j.attr(attr, attrs[attr]);
                };
            });
            return t;
        } else {
            // Get attributes
            var a = { },
                r = t.get(0);
            if (r) {
                r = r.attributes;
                for (var i in r) {
                    var p = r[i];
                    if (typeof p.nodeValue !== 'undefined') a[p.nodeName] = p.nodeValue;
                }
            }
            return JSON.stringify(a);
        }
    };

    jQuery.fn.visible = function() {
        return this.css('visibility', 'visible');
    };

    jQuery.fn.invisible = function() {
        return this.css('visibility', 'hidden');
    };

    jQuery.fn.visibilityToggle = function() {
        return this.css('visibility', function(i, visibility) {
            return (visibility == 'visible') ? 'hidden' : 'visible';
        });
    };

    jQuery.fn.center = function (parent) {
        // this.parent().css("position","absolute");
        this.css("position","absolute");
        this.css("top", (($(parent).height() - this.height()) / 2) );
        this.css("left", (($(parent).width() - this.width()) / 2) );
        return this;
    }
    
})(jQuery);

$.widget("ui.xtooltip", $.ui.tooltip, {
    options: {
        content: function () {
            return $(this).prop('title');
        },
        position: { my: "center top+15", at: "center center" }
    }
});

function parseDate(str) {
    var mdy = str.split('/')
    return new Date(mdy[2], mdy[0]-1, mdy[1]);
}

function daydiff(first, second) {
    return (second-first)/(1000*60*60*24);
}
