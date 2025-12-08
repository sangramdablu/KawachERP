(function($) {
  'use strict';
  $(function() {
    // Selectors
    var navbar_classes = "navbar-danger navbar-success navbar-warning navbar-dark navbar-light navbar-primary navbar-info navbar-pink";
    var sidebar_classes = "sidebar-light sidebar-dark";
    var $body = $("body");

    /* ------------------------------------------------------------------
     * Load saved theme settings from localStorage on page load
     * ------------------------------------------------------------------ */
    var savedSidebarTheme = localStorage.getItem("sidebarTheme");
    var savedNavbarTheme = localStorage.getItem("navbarTheme");

    if (savedSidebarTheme) {
      $body.removeClass(sidebar_classes).addClass(savedSidebarTheme);
      $(".sidebar-bg-options").removeClass("selected");
      $("#" + savedSidebarTheme.replace("sidebar-", "sidebar-") + "-theme").addClass("selected");
    }

    if (savedNavbarTheme) {
      $(".navbar").removeClass(navbar_classes).addClass(savedNavbarTheme);
      $(".tiles").removeClass("selected");
      $(".tiles." + savedNavbarTheme.replace("navbar-", "")).addClass("selected");
    }

    /* ------------------------------------------------------------------
     * Sidebar theme switching (light / dark)
     * ------------------------------------------------------------------ */
    $("#sidebar-light-theme").on("click", function() {
      $body.removeClass(sidebar_classes).addClass("sidebar-light");
      $(".sidebar-bg-options").removeClass("selected");
      $(this).addClass("selected");
      localStorage.setItem("sidebarTheme", "sidebar-light"); // Save user choice
    });

    $("#sidebar-dark-theme").on("click", function() {
      $body.removeClass(sidebar_classes).addClass("sidebar-dark");
      $(".sidebar-bg-options").removeClass("selected");
      $(this).addClass("selected");
      localStorage.setItem("sidebarTheme", "sidebar-dark"); // Save user choice
    });

    /* ------------------------------------------------------------------
     * Navbar color tiles switching
     * ------------------------------------------------------------------ */
    $(".tiles").on("click", function() {
      var colorClass = $(this).attr("class").split(" ")[1]; // e.g. "success", "dark", etc.
      $(".navbar").removeClass(navbar_classes);

      if (colorClass !== "default") {
        $(".navbar").addClass("navbar-" + colorClass);
        localStorage.setItem("navbarTheme", "navbar-" + colorClass);
      } else {
        localStorage.removeItem("navbarTheme");
      }

      $(".tiles").removeClass("selected");
      $(this).addClass("selected");
    });

    $("#reset-theme").on("click", function() {
      localStorage.removeItem("sidebarTheme");
      localStorage.removeItem("navbarTheme");
      location.reload(); // Reload page to reset
    });


    /* ------------------------------------------------------------------
     * Panel toggles
     * ------------------------------------------------------------------ */
    $(".nav-settings").on("click", function() {
      $("#right-sidebar").toggleClass("open");
    });

    $(".settings-close").on("click", function() {
      $("#right-sidebar,#theme-settings").removeClass("open");
    });

    $("#settings-trigger").on("click", function() {
      $("#theme-settings").toggleClass("open");
    });
  });
})(jQuery);



// (function($) {
//   'use strict';
//   $(function() {
//     $(".nav-settings").on("click", function() {
//       $("#right-sidebar").toggleClass("open");
//     });
//     $(".settings-close").on("click", function() {
//       $("#right-sidebar,#theme-settings").removeClass("open");
//     });

//     $("#settings-trigger").on("click" , function(){
//       $("#theme-settings").toggleClass("open");
//     });


//     //background constants
//     var navbar_classes = "navbar-danger navbar-success navbar-warning navbar-dark navbar-light navbar-primary navbar-info navbar-pink";
//     var sidebar_classes = "sidebar-light sidebar-dark";
//     var $body = $("body");

//     //sidebar backgrounds
//     $("#sidebar-light-theme").on("click" , function(){
//       $body.removeClass(sidebar_classes);
//       $body.addClass("sidebar-light");
//       $(".sidebar-bg-options").removeClass("selected");
//       $(this).addClass("selected");
//     });
//     $("#sidebar-dark-theme").on("click" , function(){
//       $body.removeClass(sidebar_classes);
//       $body.addClass("sidebar-dark");
//       $(".sidebar-bg-options").removeClass("selected");
//       $(this).addClass("selected");
//     });


//     //Navbar Backgrounds
//     $(".tiles.primary").on("click" , function(){
//       $(".navbar").removeClass(navbar_classes);
//       $(".navbar").addClass("navbar-primary");
//       $(".tiles").removeClass("selected");
//       $(this).addClass("selected");
//     });
//     $(".tiles.success").on("click" , function(){
//       $(".navbar").removeClass(navbar_classes);
//       $(".navbar").addClass("navbar-success");
//       $(".tiles").removeClass("selected");
//       $(this).addClass("selected");
//     });
//     $(".tiles.warning").on("click" , function(){
//       $(".navbar").removeClass(navbar_classes);
//       $(".navbar").addClass("navbar-warning");
//       $(".tiles").removeClass("selected");
//       $(this).addClass("selected");
//     });
//     $(".tiles.danger").on("click" , function(){
//       $(".navbar").removeClass(navbar_classes);
//       $(".navbar").addClass("navbar-danger");
//       $(".tiles").removeClass("selected");
//       $(this).addClass("selected");
//     });
//     $(".tiles.light").on("click" , function(){
//       $(".navbar").removeClass(navbar_classes);
//       $(".navbar").addClass("navbar-light");
//       $(".tiles").removeClass("selected");
//       $(this).addClass("selected");
//     });
//     $(".tiles.info").on("click" , function(){
//       $(".navbar").removeClass(navbar_classes);
//       $(".navbar").addClass("navbar-info");
//       $(".tiles").removeClass("selected");
//       $(this).addClass("selected");
//     });
//     $(".tiles.dark").on("click" , function(){
//       $(".navbar").removeClass(navbar_classes);
//       $(".navbar").addClass("navbar-dark");
//       $(".tiles").removeClass("selected");
//       $(this).addClass("selected");
//     });
//     $(".tiles.default").on("click" , function(){
//       $(".navbar").removeClass(navbar_classes);
//       $(".tiles").removeClass("selected");
//       $(this).addClass("selected");
//     });
//   });
// })(jQuery);
