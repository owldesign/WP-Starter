Application = ->
  console.log 'Theme Loaded!'
  
  # Check if Dev Mode on
  if theme_api.devMode
    devNotice = '<div class="dev front-end">DEV</div>'
    $('body').prepend devNotice

Application()
