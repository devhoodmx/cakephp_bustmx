/*global module:false*/
'use strict';

module.exports = function(grunt) {
	var targets = {
		stylesheets: {
			dist: [
				'app/webroot/css/src/**/*.scss',
				'!app/webroot/css/src/**/_*.scss',
				'!app/webroot/css/src/site/component/bootstrap-4.scss',
				'!app/webroot/css/src/admin/module/bootstrap.scss',
				'!app/webroot/css/src/vendor/**/*.scss'
			],
			fontawesome: [
				'app/webroot/css/src/component/font-awesome-5/*.scss',
				'app/webroot/css/src/admin/component/fontawesome.scss'
			]
		},
		scripts: {
			dist: ['app/webroot/js/src/**/*.js', '!app/webroot/js/src/vendor/**/*.js', '!app/webroot/js/src/template/**/*.js']
		},
		images: {
			dist: ['**/*.{png,jpg}']
		}
	};

	// Tasks configuration
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		sass: {
			options: {
				style: 'expanded',
				precision: 10,
				sourcemap: 'none'
			},
			dist: {
				expand: true,
				cwd: 'app/webroot/css/src/',
				src: ['**/*.scss', '!vendor/**/*.scss'],
				dest: 'app/webroot/css/build/',
				ext: '.css'
			},
			'bootstrap-4': {
				files: {
					'app/webroot/css/build/site/component/bootstrap-4.css': 'app/webroot/css/src/site/component/bootstrap-4.scss'
				}
			}
		},
		sassUnicode: {
			dist: {}
		},
		'string-replace': {
			options: {
				saveUnchanged: false
			},
			unicode: {
				options: {
					replacements: [
						{
							pattern: /^@charset .*\n?/mi,
							replacement: ''
						}
					]
				}
			}
		},
		compass: {
			dist: {},
			build: {
				options: {
					specify: targets.stylesheets.dist
				}
			},
			bootstrap: {
				options: {
					specify: 'app/webroot/css/src/admin/module/bootstrap.scss'
				}
			}
		},
		postcss: {
			options: {
				map: false,
				processors: [
					require('autoprefixer')({
						cascade: false
					})
				]
			},
			dist: {},
			'bootstrap-4': {
				src: 'app/webroot/css/build/site/component/bootstrap-4.css'
			}
		},
		cssmin: {
			dist: {},
			'bootstrap-4': {
				files: {
					'app/webroot/css/build/site/component/bootstrap-4.css': 'app/webroot/css/build/site/component/bootstrap-4.css'
				}
			}
		},
		terser: {
			dist: {
				expand: true,
				cwd: 'app/webroot/js/src/',
				src: ['**/*.js', '!vendor/**/*.js'],
				dest: 'app/webroot/js/build/'
			}
		},
		eslint: {
			dist: {
				src: targets.scripts.dist
			}
		},
		imagemin: {
			dist: {
				expand: true,
				cwd: 'app/webroot/img/',
				src: targets.images.dist,
				dest: 'app/webroot/img/'
			}
		},
		handlebars: {
			dist: {
				expand: true,
				cwd: 'app/webroot/tpl/',
				src: ['**/*.hbs'],
				dest: 'app/webroot/js/src/template/',
				ext: '.js',
				options: {
					namespace: '<%= pkg.name %>.template',
					processName: function(filename) {
						return filename.replace(grunt.config('handlebars.dist.cwd'), '').replace('/', '.').replace(/.hbs$/, '');
					}
				}
			}
		},
		watch: {
			options: {
				spawn: false
			},
			stylesheets: {
				files: targets.stylesheets.dist,
				tasks: ['sass:dist', 'postcss:dist', 'cssmin:dist'],
				options: {
					event: ['added', 'changed']
				}
			},
			scripts: {
				files: targets.scripts.dist,
				tasks: ['eslint', 'terser'],
				options: {
					event: ['added', 'changed']
				}
			},
			images: {
				files: targets.images.dist,
				tasks: ['imagemin'],
				options: {
					event: ['added', 'changed']
				}
			},
			grunt: {
				files: ['Gruntfile.js']
			},
			'bootstrap': {
				files: ['app/webroot/css/src/admin/module/bootstrap.scss', 'app/webroot/css/src/admin/module/bootstrap/*.scss'],
				tasks: ['compass:bootstrap']
			},
			'bootstrap-4': {
				files: ['app/webroot/css/src/site/component/bootstrap-4.scss', 'app/webroot/css/src/site/component/bootstrap-4/*.scss'],
				tasks: ['sass:bootstrap-4', 'postcss:bootstrap-4', 'cssmin:bootstrap-4']
			}
		}
	});

	// Events
	grunt.event.on('watch', function(action, file) {
		var relative;
		var build;
		var files = {};

		if (grunt.file.isMatch(targets.stylesheets.dist, file)) {
			relative = file.replace(grunt.config('sass.dist.cwd'), '');
			build = grunt.config('sass.dist.dest') + relative.replace(/\.scss$/, '.css');
			files[build] = build;

			grunt.config('sass.dist.src', [relative]);
			grunt.config('postcss.dist.src', build);
			grunt.config('cssmin.dist.files', files);

			// Font Awesome
			if (grunt.file.isMatch(targets.stylesheets.fontawesome, file)) {
				grunt.config('sassUnicode.dist.files', files);
				grunt.config('string-replace.unicode.files', files);

				grunt.config('watch.stylesheets.tasks', ['sass:dist', 'sassUnicode:dist', 'string-replace:unicode', 'postcss:dist', 'cssmin:dist']);
			} else {
				grunt.config('watch.stylesheets.tasks', ['sass:dist', 'postcss:dist', 'cssmin:dist']);
			}
		}

		if (grunt.file.isMatch(grunt.config('watch.scripts.files'), file)) {
			relative = file.replace(grunt.config('terser.dist.cwd'), '');

			grunt.config('eslint.dist.src', [file]);
			grunt.config('terser.dist.src', [relative]);
		}

		if (grunt.file.isMatch(grunt.config('watch.images.files'), file)) {
			relative = file.replace(grunt.config('imagemin.dist.cwd'), '');

			grunt.config('imagemin.dist.src', [relative]);
		}
	});

	// Load tasks
	grunt.loadTasks('util/grunt');

	// Load vendors tasks
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);
	grunt.loadNpmTasks('@lodder/grunt-postcss');

	// Default task
	grunt.registerTask('default', ['compass:build', 'handlebars', 'eslint', 'terser']);
};
