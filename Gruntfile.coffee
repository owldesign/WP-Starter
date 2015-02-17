#
#
# @package blank theme
#
#

module.exports = (grunt) ->
  # configuration
  grunt.initConfig

    # file constants
    publicCss: 'assets/css'
    publicScss: 'assets/scss'
    publicJs: 'assets/js'
    publicCoffee: 'assets/coffee'

    # sass compiling
    sass:
      compile:
        options:
          compress: false
          # sourcemap: 'none'
          style: 'expanded'
        files: 
          '<%= publicCss %>/application.css': '<%= publicScss %>/application.scss'

    # coffee compiling
    coffee:
      compile:
        expand: true
        files:
          '<%= publicJs %>/application.js': ['<%= publicCoffee %>/application.coffee']

    # watch for change
    watch:
      css:
        files: ['<%= publicScss %>/**/*']
        tasks: ['sass']
      scripts:
        files: ['<%= publicCoffee %>/*']
        tasks: ['coffee']
      options:
        livereload: false

    # load plugins
    grunt.loadNpmTasks 'grunt-contrib-sass'
    grunt.loadNpmTasks 'grunt-contrib-coffee'
    grunt.loadNpmTasks 'grunt-contrib-watch'

    # tasks
    grunt.registerTask 'default', ['watch']