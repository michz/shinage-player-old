module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        resourcesPath: 'src/ShinagePlayerBundle/Resources',
        clean: {
            css: ['web/css/*'],
            js: ['web/js/*']
        },
        copy: {
            js: {
                expand: true,
                cwd: '<%= resourcesPath %>/public/js/',
                src: 'lib/**',
                dest: 'web/assets/js/'
            }
        },
        concat: {
            options: {
                stripBanners: true
            },
            css: {
                src: [
                    '<%= resourcesPath %>/public/css/reset.css',
                    '<%= resourcesPath %>/public/css/**'
                ],
                dest: 'web/assets/css/shp.css'
            },
            js : {
                src : [
                    '<%= resourcesPath %>/public/js/*.js'
                ],
                dest: 'web/assets/js/shp.js'
            }
        },
        cssmin : {
            "shp":{
                src: 'web/assets/css/shp.css',
                dest: 'web/assets/css/shp.min.css'
            }
        },
        uglify : {
            js: {
                files: {
                    'web/assets/js/shp.min.js': ['web/assets/js/shp.js']
                }
            }
        }
    });

    // Load the plugins.
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // Default task(s).
    grunt.registerTask('default', ['clean', 'copy', 'concat', 'cssmin', 'uglify']);
    //grunt.registerTask('default', ['clean', 'copy']);
};
