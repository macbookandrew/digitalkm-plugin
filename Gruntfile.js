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

		uglify: {
			options: {
				sourceMap: true
			},
			custom: {
				files: {
					'assets/js/coordinates-map.min.js': ['src/js/coordinates-map.js'],
				},
			},
		},

		watch: {
			javascript: {
				files: ['src/js/*.js'],
				tasks: ['uglify'],
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
