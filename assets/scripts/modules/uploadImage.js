'use strict'

var ajax = require('./ajax.js');
var url, callback,
	id = null;

exports.init = function(fileInput, cb){
	url = fileInput.getAttribute('data-target-url');
	id = fileInput.getAttribute('data-target-id');
	callback = cb;
	fileInput.addEventListener('change', upload);
}

function upload(evt){
	evt.preventDefault();

	if(evt.target.files.length == 0) return;
	
	var fd = new FormData();
	
	fd.append('image', evt.target.files[0]);
	if(id) fd.append('id', id);
	fd.append('controls', true);

	if (callback === undefined){
		callback = function(status, response){
			console.log(status);
			console.log(response);
		}
	}
	
	ajax.post(url, fd, callback);
}

