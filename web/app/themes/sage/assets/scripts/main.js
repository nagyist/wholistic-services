/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
        // See http://stackoverflow.com/questions/12522291/pausing-youtube-iframe-api-in-javascript
        var yt_int, yt_players={},
          initYT = function() {
            $(".testeleven-video").each(function() {
              yt_players[this.id] = new YT.Player(this.id);
            });
          };
        $.getScript("https://www.youtube.com/player_api", function() {
          yt_int = setInterval(function(){
            if(typeof YT === "object"){
              initYT();
              clearInterval(yt_int);
            }
          },500);
        });

        $('.modal').on('hide.bs.modal', function() {
          var player_id = $(this).attr('data-player-id');
          yt_players[player_id].pauseVideo();

        });
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
        //var $highlights = $('#highlights .highlight-box .wrap');
        //var color_classes = ['red', 'orange', 'yellow', 'green', 'blue', 'violet'];
        //var color_len = color_classes.length;
        //$highlights.each(function(index) {
        //  var chosen_color = color_classes[index % color_len];
        //  $(this).addClass(chosen_color);
        //});

      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    },
    'schedule': {
      init: function() {
        // Make the whole schedule entry clickable - not just the link.
        $('.has-class').css({'cursor': 'pointer'}).click(function() {
          window.location.href = $(this).find('a:first').attr('href');
        });
        $('[data-toggle="tooltip"]').tooltip();
      },
      finalize: function() {

      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
