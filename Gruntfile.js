module.exports = function( grunt ) {

	'use strict';

	// Project configuration
	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		addtextdomain: {
			options: {
				textdomain: 'digitalkm',
			},
			update_all_domains: {
				options: {
					updateDomains: true
				},
				src: [ '*.php', '**/*.php', '!\.git/**/*', '!bin/**/*', '!node_modules/**/*', '!tests/**/*' ]
			}
		},

		wp_readme_to_markdown: {
			your_target: {
				files: {
					'README.md': 'readme.txt'
				}
			},
		},

		makepot: {
			target: {
				options: {
					domainPath: '/languages',
					exclude: [ '\.git/*', 'bin/*', 'node_modules/*', 'tests/*' ],
					mainFile: 'digitalkm.php',
					potFilename: 'digitalkm.pot',
					potHeaders: {
						poedit: true,
						'x-poedit-keywordslist': true
					},
					type: 'wp-plugin',
					updateTimestamp: true
				}
			}
		},

		postcss: {
			options: {
				map: {
					inline: false,
					annotation: 'assets/css/',
				},

				processors: [
					require('cssnano')() // minify the result
				]
			},
			dist: {
				src: 'assets/css/*.css',
			}
		},

		uglify: {
			options: {
				sourceMap: true
			},
			custom: {
				files: {
					'assets/js/coordinates-map.min.js': ['src/js/coordinates-map.js'],
					'assets/js/leaflet.min.js': ['src/js/leaflet-src.js'],
				},
			},
		},

		watch: {
			javascript: {
				files: ['src/js/*.js'],
				tasks: ['uglify'],
			},
			styles: {
				files: ['src/css/*.css'],
				tasks: ['postcss'],
			},
			readme: {
				files: ['readme.txt'],
				tasks: ['readme'],
			}
		},

		browserSync: {
			dev: {
				bsFiles: {
					src : ['assets/**/*.css', '**/*.php', 'assets/**/*.js', '!node_modules'],
				},
				options: {
					watchTask: true,
					proxy: "https://digitalkm.wordpress.dev",
					open: "external",
					host: "andrews-macbook-pro.local",
					https: {
						key: "/Users/andrew/github/dotfiles/local-dev.key",
						cert: "/Users/andrew/github/dotfiles/local-dev.crt",
					}
				},
			},
		},
	} );

	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-postcss' );
	grunt.loadNpmTasks( 'grunt-browser-sync' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
	grunt.registerTask( 'i18n', ['addtextdomain', 'makepot'] );
	grunt.registerTask( 'readme', ['wp_readme_to_markdown'] );
	grunt.registerTask( 'default', [
		'browserSync',
		'watch',
	]);

	grunt.util.linefeed = '\n';

};
