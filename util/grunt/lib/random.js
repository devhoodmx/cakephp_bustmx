var crypto = require('crypto');

var DEC_SET = '0123456789',
	DEC_SET_SIZE = 10;

exports.nextDecimal = function(length) {
	var	randomNumber,
		string = '';

	for (var index = 0; index < length; index++) {
		randomNumber = Math.floor(Math.random() * DEC_SET_SIZE);
		string += DEC_SET[randomNumber];
	}
  
	return string;
};

exports.nextBase64 = function(length) {
	var size = Math.ceil(length * 6 / 8),
		buf = crypto.randomBytes(size);

	return buf.toString('base64').substring(0, length);
};