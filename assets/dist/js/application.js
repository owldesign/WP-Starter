(function() {
  var Application;

  Application = function() {
    var devNotice;
    console.log('Theme Loaded!');
    if (theme_api.devMode) {
      devNotice = '<div class="dev front-end">DEV</div>';
      return $('body').prepend(devNotice);
    }
  };

  Application();

}).call(this);
