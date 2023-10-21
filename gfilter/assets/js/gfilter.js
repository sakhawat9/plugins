/* ---------------------------------------------
 common scripts
 --------------------------------------------- */

(function ($) {
  "use strict"; // use strict to start

  $(document).ready(function () {
    /* ---------------------------------------------
         gfilter filtering
         --------------------------------------------- */

    var $gfilter = $(".gfilter-grid");
    if ($.fn.imagesLoaded && $gfilter.length > 0) {
      imagesLoaded($gfilter, function () {
        $gfilter.isotope({
          itemSelector: ".gfilter-item",
          filter: "*",
        });
        $(window).trigger("resize");
      });
    }

    $(".gfilter-filter").on("click", "a", function (e) {
      e.preventDefault();
      $(this).parent().addClass("active").siblings().removeClass("active");
      var filterValue = $(this).attr("data-filter");
      $gfilter.isotope({ filter: filterValue });
    });

    /*-----------------------------------------------------
         magnific popup init
         ------------------------------------------------------- */

    // $(".gfilter-gallery").each(function () {
    //     $(this).find(".popup-gallery").magnificPopup({
    //         type: "image",
    //         gallery: {
    //             enabled: true
    //         }
    //     });
    // });
  });
})(jQuery);
