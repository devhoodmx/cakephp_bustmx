module.exports = function(grunt) {
	var fs = require('fs'),
		prompt = require('prompt'),
		random = require('./lib/random');

	var CONFIG_FILES = {
			config: 'app/Config/config.php',
			core: 'app/Config/core.php',
			email: 'app/Config/email.php',
			database: 'app/Config/database.php'
		};
/*
 * Install Task
 *
 */
	grunt.registerTask('install', 'Default installation', function() {
		var promptSchema = {
			properties: {
				dbHost: {
					description: 'Database host',
					'default': '127.0.0.1'
				},
				dbUser: {
					description: 'Database user',
					'default': 'root'
				},
				dbPassword: {
					description: 'Database password',
					hidden: true
				},
				dbName: {
					description: 'Database name',
					required: true,
					message: 'Field cannot be empty.'
				},
				updateCiphers: {
					description: 'Do you want to assign new random values to Security.salt and Security.cipherSeed? (Y/N)',
					pattern: /^[YN]$/i,
					'default': 'N',
					before: function(value) {
						return value.toUpperCase() == 'Y';
					}
				}
			}
		};

		// Force task into async mode and grab a handle to the "done" function.
		var done = this.async();

		// Start the prompt
		prompt.start();
		prompt.get(promptSchema, function(err, result) {
			let content;

			// Assign new random values to Security.* settings
			if (result.updateCiphers) {
				var salt = random.nextBase64(40),
					cipherSeed = random.nextDecimal(30),
					corePath = CONFIG_FILES.core + '.default',
					coreContent = grunt.file.read(corePath);

				coreContent = coreContent.replace(/('Security.salt',\s+')[^']+'/, "$1" + salt + "'");
				coreContent = coreContent.replace(/('Security.cipherSeed',\s+')[^']+'/, "$1" + cipherSeed + "'");
				grunt.file.write(corePath, coreContent);
			}

			// Copy config. files
			Object.keys(CONFIG_FILES).forEach(function(key) {
				let file = CONFIG_FILES[key];

				grunt.file.copy(file + '.default', file);
			});

			// Configure database connection
			fs.chmodSync(CONFIG_FILES.database, '0660');

			content = grunt.file.read(CONFIG_FILES.database)
			Object.keys(result).forEach(function (key) {
				let value = result[key];

				content = content.replace(new RegExp(`{{${key}}}`, 'g'), value);
			});
			grunt.file.write(CONFIG_FILES.database, content);

			done();
		});
	});
/*
 * Uninstall Task
 *
 */
	grunt.registerTask('uninstall', 'Delete files created by install task', function() {
		Object.keys(CONFIG_FILES).forEach(function(key) {
			let file = CONFIG_FILES[key];

			grunt.file.delete(file);
		});
	});
/*
 * Set debug Task
 *
 * grunt set-debug:[0-2]
 *
 */
	grunt.registerTask('set-debug', 'Set debug', function(debug) {
		if (arguments.length && debug >= 0 && debug < 3) {
			var content = grunt.file.read(CONFIG_FILES.core);

			grunt.log.write('Setting debug mode to ' + debug + '...');
			content = content.replace(/'debug', [0-2]/, "'debug', " + debug);
			grunt.file.write(CONFIG_FILES.core, content);
			grunt.log.ok();
		} else {
			grunt.fail.warn('Invalid debug value.');
		}
	});
};
