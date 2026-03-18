/*global module:false*/
module.exports = function(grunt) {
	var exec = require('child_process').exec,
		prompt = require('prompt');

	grunt.registerTask('namespace', 'Rename namespace', function() {
		var promptSchema = {
			properties: {
				from: {
					description: 'Current namespace',
					required: true
				},
				to: {
					description: 'New namespace',
					required: true
				}
			}
		};

		// Force task into async mode and grab a handle to the "done" function.
		var done = this.async();

		// Start the prompt
		prompt.start();
		prompt.get(promptSchema, function(err, result) {
			var targets,
				cmds;

			cmds = {
				find: 'find . ! \\( -path "./.*" -o -path "./lib/*" -o -path "./node_modules/*" -o -path "./app/tmp/*" -o -path "./app/webroot/js/build/*" \\) -type f -print0',
				grep: `xargs -0 grep -l ${result.from}`,
				perl: `xargs -0 perl -pi -e "s/${result.from}/${result.to}/g"`
			};

			exec(`${cmds.find} | ${cmds.grep}`, function(error, stdout, stderr) {
				var files;

				if (error !== null) {
					grunt.fail.warn(error);
				}

				files = stdout.split('\n').filter(function(el) {
					return el.length;
				}).map(function(el) {
					return el.replace('./', '');
				});

				// Replace content
				exec(`${cmds.find} | ${cmds.perl}`, function(error, stdout, stderr) {
					if (error !== null) {
						grunt.fail.warn(error);
					}

					grunt.log.subhead(`Replace "${result.from}" with "${result.to}" in:`);
					files.forEach(function(file) {
						grunt.log.writeln(`File ${file}`);
					});

					// Uglify js files
					grunt.task.run('terser:dist');

					done();
				});
			});


			// Special replacements
			targets = [
				{
					files: ['app/Config/core.php.default'],
					from: `('cookie' => ')${result.from[0] + 's'}'`,
					to: `$1${result.to[0] + 's'}'`
				},
				{
					files: ['app/Controller/AppController.php', 'app/Plugin/Templates/Controller/TemplatesAppController.php'],
					from: `('name' => ')${result.from[0] + 'c'}'`,
					to: `$1${result.to[0] + 'c'}'`
				}
			];

			targets.forEach(function(target) {
				var files = target.files;

				if (files.length) {
					grunt.log.subhead(`Replace "${target.from}" with "${target.to}" in:`);
					files.forEach(function(file) {
						grunt.log.writeln(`File ${file}`);
						grunt.file.write(
							file,
							grunt.file.read(file).replace(new RegExp(target.from), target.to)
						);
					});
				}
			});
		});
	});
};
