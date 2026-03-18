/*global module:false*/
module.exports = function(grunt) {
/*
 * CakePHP version Task
 *
 */
	grunt.registerTask('cakephp', 'CakePHP version', function() {
		var filename = 'lib/Cake/VERSION.txt',
			data = grunt.file.read(filename),
			regExp = /\/+\n((?:\d+\.){2}\d+)/gi,
			match = regExp.exec(data.toString());

		grunt.log.writeln('CakePHP version: ' + (match ? match[1] : '-'));
	});
};