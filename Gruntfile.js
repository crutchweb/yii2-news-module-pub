module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            all: {
                files: [{
                        expand: true,
                        src: ['**/*.js', '!**/*.min.js'],
                        dest: '',
                        cwd: '',
                        ext: '.min.js',
                        filter: function (filepath) {
                            return (grunt.file.isFile(filepath) && filepath.indexOf('node_modules') < 0);
                        }
                    }]
            },
        },
        cssmin: {
            all: {
                files: [{
                        expand: true,
                        cwd: '',
                        src: ['**/*.css', '!**/*.min.css'],
                        dest: '',
                        ext: '.min.css',
                        filter: function (filepath) {
                            return (grunt.file.isFile(filepath) && filepath.indexOf('node_modules') < 0);
                        }
                    }]
            },
        }
    });


    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.registerTask('default', ['uglify']);
    grunt.registerTask('default', ['cssmin']);
};