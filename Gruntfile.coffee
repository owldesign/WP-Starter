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
    publicCss: 'assets/css'
    publicScss: 'assets/scss'
    publicJs: 'assets/js'
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
        tasks: ['coffee', 'uglify']
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
          '<%= publicCss %>/application.css': '<%= publicScss %>/application.scss'

    # =============================================
    # compile coffee files
    # =============================================
    # https://github.com/gruntjs/grunt-contrib-coffee
    # =============================================
    coffee:
      compile:
        expand: true
        files:
          '<%= publicJs %>/application.js': ['<%= publicCoffee %>/application.coffee']

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
          '<%= distFolder %>/application.min.js': ['<%= publicJs %>/application.js']
          '<%= distFolder %>/plugins.min.js': ['<%= publicJs %>/plugins.js']

    # =============================================
    # css minifier
    # =============================================
    # https://github.com/gruntjs/grunt-contrib-cssmin
    # =============================================
    cssmin:
      dist:
        files:
          '<%= distFolder %>/application.min.css': ['<%= publicCss %>/application.css']

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