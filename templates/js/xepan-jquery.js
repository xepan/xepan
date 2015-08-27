
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

// jQuery IF extenssion .. usefull for ATK style jquery handling if we want some IF in js output

/*﻿  
﻿  IF plugin for jQuery
﻿  Version: 1.0.2
﻿  http://jquery-if.googlecode.com/
﻿  
﻿  Copyright (c) 2011 Todd Northrop
﻿  http://www.speednet.biz/
﻿  
﻿  March 11, 2011
﻿  
﻿  Adds conditional branching to jQuery matched set chaining.
﻿  
﻿  Requires:  jQuery 1.2+
﻿  
﻿  Dual licensed under the MIT or GPL Version 2 licenses.
﻿  See mit-license.txt and gpl2-license.txt in the project root for details.
------------------------------------------------------*/

(function ($) {

$.fn.IF = function (expr) {
﻿  ///﻿  <summary>
﻿  ///﻿  ﻿  Returns a jQuery matched set:  If 'expr' evaluates is 'truthy'
﻿  /// ﻿  ("not falsey") then the original matched set is returned, or if
﻿  /// ﻿  'expr' evaluates to 'false' ("falsy") then an empty matched set
﻿  /// ﻿  is returned.  This has the effect of continuing to execute the
﻿  /// ﻿  subsequent jQuery chained functions (or not), depending on the
﻿  /// ﻿  value of 'expr', just like an 'if' statement in JavaScript --
﻿  /// ﻿  except it can be done mid-chain.  The function chain returns to
﻿  /// ﻿  executing on the original matched set when the next .ENDIF()
﻿  /// ﻿  is encountered.  (Note that .ENDIF() is currently the same thing
﻿  /// ﻿  as calling jQuery's built-in .end() function, but it is
﻿  /// ﻿  recommended to use .ENDIF() in case this changes in the future.)
﻿  /// ﻿  .IF() can also be followed down-chain by an .ELSE() call for
﻿  /// ﻿  further conditional branching mid-chain (see .ELSE() below
﻿  /// ﻿  for more details). It is also possible to nest multiple .IF()
﻿  /// ﻿  and .ELSE() calls, but your brain might lapse into an infinite
﻿  /// ﻿  loop if you try.
﻿  ///﻿  </summary>
﻿  /// <example>
﻿  /// ﻿  This example adds a click handler only if myVar is "yes".
﻿  /// ﻿  The final .css() function demonstrates that we can continue
﻿  /// ﻿  working with #myElement, and the .css() call is always made
﻿  /// ﻿  regardless of the value of myVar, because the .ENDIF() restores
﻿  /// ﻿  the original matched set.
﻿  /// ﻿  
﻿  /// ﻿  $( "#myElement" )
﻿  /// ﻿  ﻿  .IF( myVar == "yes" )
﻿  /// ﻿  ﻿  ﻿  .click( function () { alert( "myVar is yes" ); } )
﻿  /// ﻿  ﻿  .ENDIF()
﻿  /// ﻿  ﻿  .css( "color", "blue" );
﻿  /// </example>
﻿  /// <param name="expr">
﻿  ///﻿  ﻿  If "falsey", then the original jQuery matched set is returned, but
﻿  /// ﻿  with all the elements removed. Otherwise, the original jQuery set
﻿  /// ﻿  is returned so that chaining can continue.
﻿  /// ﻿  If a function is passed for this argument, it is called and the
﻿  /// ﻿  value returned from the function is used to evaluate true or false.
﻿  /// ﻿  The function is called with the matched set as its context (the
﻿  /// ﻿  value of 'this') and with no arguments passed.
﻿  /// </param>
﻿  ///﻿  <returns type="jQuery">
﻿  ///﻿  ﻿  Returns the original jQuery matched set, but if the specified
﻿  /// ﻿  expression is "falsey", all of the elements are removed.
﻿  /// </returns>
﻿  /// <notes>
﻿  /// ﻿  NAMING CONVENTIONS:
﻿  /// ﻿  I wish I could have used the lower-cased '.if()', '.else()' and
﻿  /// ﻿  '.endif()', but unfortunately JavaScript does not allow a dot-
﻿  /// ﻿  notation version of a reserved word.  Interestingly, it does
﻿  /// ﻿  accept an array-indexed version of a reserved word, like:
﻿  /// ﻿  $("#myElement")['if']( ... ).css( ... )...etc.
﻿  /// ﻿  I arrived at using an upper-cased version of 'if' after looking
﻿  /// ﻿  at dozens of alternatives, and disliking them all for various
﻿  /// ﻿  reasons.  On the plus side, all-caps does not match with the
﻿  /// ﻿  camelCase standards in jQuery, but I don't think there is any
﻿  /// ﻿  standard that PROHIBITS its use either.  Also, by making .IF(),
﻿  /// ﻿  .ELSE(), and .ENDIF() upper-case, the branching logic becomes
﻿  /// ﻿  quite visible and clear when examining code.
﻿  /// ﻿  
﻿  /// ﻿  ADAPTED FROM MY PREVIOUS .continueIf() PLUGIN:
﻿  /// ﻿  This plugin is a continuation and extension of my .continueIf()
﻿  /// ﻿  plugin, that I released back in 2009. I was writing some code
﻿  /// ﻿  using the plugin, and came to a point where I wished I could do
﻿  /// ﻿  an 'else'. So I toyed around with it, figured out a pretty simple
﻿  /// ﻿  way to maintain the else condition, and kept refining it until
﻿  /// ﻿  it was stripped of extranious .end() calls and renamed to .IF().
﻿  /// ﻿  (See NAMING CONVENTIONS above.)
﻿  /// ﻿  
﻿  /// ﻿  COMMENT-TO-CODE RATIO:
﻿  /// ﻿  I think I've set a new record.
﻿  /// </notes>
﻿  
﻿  return this.pushStack( (this._ELSE = !($.isFunction( expr )? expr.apply( this ) : expr))? [] : this, "IF", expr );
};

$.fn.ELSE = function (expr) {
﻿  ///﻿  <summary>
﻿  ///﻿  ﻿  Used together with .IF(), .ELSE() returns the original matched
﻿  /// ﻿  set if the previous .IF() was "falsey". .ELSE() can take an
﻿  /// ﻿  optional argument that changes its behavior to 'else if'.
﻿  /// ﻿  See the example below for usage.
﻿  ///﻿  </summary>
﻿  /// <example>
﻿  /// ﻿  This example adds a different click handler depending on the
﻿  /// ﻿  value of "myVar". A forced example, but makes the usage clear.
﻿  /// ﻿  The final .css() function demonstrates that we can continue
﻿  /// ﻿  working with #myElement, and the .css() call is always made
﻿  /// ﻿  regardless of the value of myVar, because it's after .ENDIF().
﻿  /// ﻿  
﻿  /// ﻿  $( "#myElement" )
﻿  /// ﻿  ﻿  .IF( myVar == "yes" )
﻿  /// ﻿  ﻿  ﻿  .click( function () { alert( "Yes" ); } )
﻿  /// ﻿  ﻿  .ELSE( myVar == "maybe" )
﻿  /// ﻿  ﻿  ﻿  .click( function () { alert( "Maybe" ); } )
﻿  /// ﻿  ﻿  .ELSE()
﻿  /// ﻿  ﻿  ﻿  .click( function () { alert( "No" ); } )
﻿  /// ﻿  ﻿  .ENDIF()
﻿  /// ﻿  ﻿  .css( "color", "blue" );
﻿  /// </example>
﻿  /// <param name="expr">
﻿  ///﻿  ﻿  Optional expression. If included, and "truthy", and a previous
﻿  /// ﻿  .IF() or .ELSE() has not evaluated "true", then the original
﻿  /// ﻿  matched set is returned so that chaining can continue. If expr is
﻿  /// ﻿  not passed (undefined), then the original matched set is returned
﻿  /// ﻿  as long as no previous .IF() or .ELSE() has evaluated "true".
﻿  /// ﻿  If a function is passed for this argument, it is called and the
﻿  /// ﻿  value returned from the function is used to evaluate true or false.
﻿  /// ﻿  The function is called with the matched set as its context (the
﻿  /// ﻿  value of 'this') and with no arguments passed.
﻿  /// </param>
﻿  ///﻿  <returns type="jQuery">
﻿  ///﻿  ﻿  Returns the original jQuery matched set, but if a previous .IF()
﻿  /// ﻿  or .ELSE() expression was "truthy", all of the elements are removed.
﻿  /// </returns>
﻿  
﻿  var $set = this.end();
﻿  
﻿  return $set.pushStack( ((!$set._ELSE) || ($set._ELSE = ((typeof( expr ) !== "undefined") && (!($.isFunction( expr )? expr.apply( $set ) : expr)))))? [] : $set, "ELSE", expr );
};

$.fn.ENDIF = function () {
﻿  ///﻿  <summary>
﻿  ///﻿  ﻿  Ends conditional branching started with a call to .IF(). Functions
﻿  /// ﻿  called in the chain after an .ENDIF() will execute on the original
﻿  /// ﻿  matched set that was in effect before the nearest .IF() was called.
﻿  /// ﻿  Even though .ENDIF() is currently the same thing as calling
﻿  /// ﻿  jQuery's built-in .end() function, it is recommended to use
﻿  /// ﻿  .ENDIF() in case it changes in the future.
﻿  ///﻿  </summary>
﻿  ///﻿  <returns type="jQuery">
﻿  ///﻿  ﻿  Returns the original jQuery matched set that was present in
﻿  /// ﻿  the chained set of functions before the nearest .IF() function
﻿  /// ﻿  was called.
﻿  /// </returns>
﻿  
﻿  return this.end();
};

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
