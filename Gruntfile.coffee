# =============================================
#
# @package WP Starter
#
# =============================================

module.exports = (grunt) ->
  # configuration
  grunt.initConfig
    pkg: '<json:package.json>'

    # file constants
    publicScss: 'assets/scss'
    publicCoffee: 'assets/coffee'
    distFolder: 'assets/dist'

    # =============================================
    # watch for change
    # =============================================
    watch:
      css:
        files: ['<%= publicScss %>/**/*']
        tasks: ['sass']
      scripts:
        files: ['<%= publicCoffee %>/*']
        tasks: ['coffee']
      options:
        livereload: false

    # =============================================
    # compile sass files
    # =============================================
    # https://github.com/gruntjs/grunt-contrib-sass
    # =============================================
    sass:
      compile:
        options:
          compress: false
          sourcemap: 'none'
          style: 'expanded'
        files: 
          '<%= distFolder %>/css/application.css': '<%= publicScss %>/application.scss'

    # =============================================
    # compile coffee files
    # =============================================
    # https://github.com/gruntjs/grunt-contrib-coffee
    # =============================================
    coffee:
      compile:
        expand: true
        files:
          '<%= distFolder %>/js/application.js': ['<%= publicCoffee %>/application.coffee']

    # =============================================
    # uglify javascript
    # =============================================
    # https://github.com/gruntjs/grunt-contrib-uglify
    # =============================================
    uglify:
      options:
        mangle: false
        beautify: false
        compress: true
      dist:
        files:
          '<%= distFolder %>/js/application.min.js': ['<%= distFolder %>/js/application.js']

    # =============================================
    # css minifier
    # =============================================
    # https://github.com/gruntjs/grunt-contrib-cssmin
    # =============================================
    cssmin:
      dist:
        files:
          '<%= distFolder %>/css/application.min.css': ['<%= distFolder %>/css/application.css']

    # =============================================
    # load plugins
    # =============================================
    grunt.loadNpmTasks 'grunt-contrib-sass'
    grunt.loadNpmTasks 'grunt-contrib-coffee'
    grunt.loadNpmTasks 'grunt-contrib-watch'
    grunt.loadNpmTasks 'grunt-contrib-uglify'
    grunt.loadNpmTasks 'grunt-contrib-cssmin'

    # tasks
    grunt.registerTask 'default', ['watch']
    grunt.registerTask 'dist', ['cssmin:dist', 'uglify:dist']