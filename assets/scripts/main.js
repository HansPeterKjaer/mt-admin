'use strict'

var doc = document;
var win = window;

win.MT = {};
win.MT.BasePath = (location.hostname  == 'localhost') ? '/mt' : '';

var ajaxPanel = require('./modules/ajaxPanel.js');
var imageUploader = require('./modules/uploadImage.js');
var alertMsg = require('./modules/alertMsg.js');
var autocomplete = require('./modules/autocomplete.js');
var ajax = require('./modules/ajax.js');
var findAncestor = require('./modules/utils/findAncestor.js');
var ajaxFormSubmit = require('./modules/ajaxFormSubmit.js');
var wysiwygEditor = require('./modules/wysiwyg');

// text editor areas init:
var wysiwygTextArea = doc.querySelector('.wysiwyg');
var toolbar = doc.querySelector('.toolbar');
if (wysiwygTextArea && toolbar){
	wysiwygEditor(wysiwygTextArea, toolbar);
}

// ajax panels init
var ajaxPanels = doc.querySelectorAll('.ajax-panel');
for (var i = 0; i < ajaxPanels.length; ++i) {
	ajaxPanel(ajaxPanels[i]);
}

// Ajax forms init:
var ajaxForms = doc.querySelectorAll('.ajax-form');
for (var i = 0; i < ajaxForms.length; ++i) {
	ajaxFormSubmit(ajaxForms[i]);
}

// delet buttons init:
var deletBtns = doc.querySelectorAll('a.ajax-delete');
var ajaxDeleteBtn = require('./modules/ajaxDeleteBtn.js');
for (var i = 0; i < deletBtns.length; ++i) {
	ajaxDeleteBtn.init(deletBtns[i]);
}

// autocomplete init:
var autoCompleteInputs = doc.querySelectorAll('input.autocomplete');

for (var i = 0; i < autoCompleteInputs.length; ++i){
	var url = autoCompleteInputs[i].getAttribute('data-url');
	var subQuery = autoCompleteInputs[i].classList.contains('sub-query');
	var thumbs = autoCompleteInputs[i].classList.contains('autocomplete-thumb');
	autocomplete.init(autoCompleteInputs[i], url, subQuery, thumbs);
	//console.log("init" + subQuery + thumbs+url);
}

// image upload init:
var imgUploadCB = function(status, data){
	data = JSON.parse(data);

	if(data.status == true){
		var imagePanel = doc.querySelector('.ajax-panel');
		
		imagePanel.insertAdjacentHTML('afterBegin', data.markup);
		var lastChild = imagePanel.querySelector('.itemcontainer:last-child');
		lastChild.remove();
	}
	else{
		alertMsg.init(data.msg, doc.querySelector('.upload-status')); 
	}
}

var uploadBtns = doc.querySelectorAll('.btn-upload-image');
for (var i = 0; i < uploadBtns.length; ++i) {
	imageUploader.init(uploadBtns[i], imgUploadCB);
}

// Create exercise: upload image callback
var exImgUploadCB = function(status, data){
	data = JSON.parse(data);

	if(data.status == true){
		var imageContainer = doc.querySelector('#exercise-images');
		imageContainer.insertAdjacentHTML('beforeend', data.markup);
		imageContainer.querySelector('.itemplaceholder') && imageContainer.querySelector('.itemplaceholder').remove();
	}
	else{
		alertMsg.init(data.msg, doc.querySelector('.upload-status'));		
	}
}

var exUploadBtns = doc.querySelectorAll('.btn-ex-upload');
for (var i = 0; i < exUploadBtns.length; ++i) {
		imageUploader.init(exUploadBtns[i], exImgUploadCB);
}

// Create exercise: add image from medialibrary
var imgImportSubmits = doc.querySelectorAll('.btn-import-image');
for (var i = 0; i < imgImportSubmits.length; ++i){
	var submitBtn = imgImportSubmits[i];
	var input = doc.querySelector('#' + submitBtn.getAttribute('for'));
	if (!input) continue;

	submitBtn.addEventListener('click', function(){
		var url = submitBtn.getAttribute('data-url') + input.value + '&controls=true';
		ajax.get(url, exImgUploadCB);
	});
}

// Create workout: add exercise 
var exImportSubmits = doc.querySelectorAll('.btn-import-exercise');

for (var i = 0; i < exImportSubmits.length; ++i){
	var submitBtn = exImportSubmits[i];
	var input = doc.querySelector('#' + submitBtn.getAttribute('for'));
	var baseUrl = submitBtn.getAttribute('data-url');
	
	if (!input) continue;

	submitBtn.addEventListener('click', function(){
		var url = baseUrl + '&exerciseName=' + input.value;
		if (input.value != ''){
			ajax.get(url, exImportCB);  
		}
		else{
			alertMsg.init("Ingen øvelse valgt!", doc.querySelector('.import-status'), 'alert-danger', 'after');
		}
		
	});

	// listen for event to enable / disable button:
	autoCompleteInputs[0].addEventListener('awesomplete-close', function(obj){
		if(obj.reason == 'select'){  // submit?
			submitBtn.disabled = false;
		}
		else{
			submitBtn.disabled = true;
		}
	});

	function exImportCB(status, data){
		data = JSON.parse(data);
		if(data.status == true){
			var itemContainer = doc.querySelector('#workout-exercises');
			itemContainer.insertAdjacentHTML('beforeend', data.markup);
			itemContainer.querySelector('.itemplaceholder') && itemContainer.querySelector('.itemplaceholder').remove();
		}
		else{
			alertMsg.init(data.msg, doc.querySelector('.import-status'), 'alert-danger', 'after'); 
		}
	}
}

// exercise images controls
//doc.querySelector('.exercise-image-composer') && doc.querySelector('.exercise-image-composer').addEventListener('click', itemComposer, false);
doc.querySelector('.item-composer') && doc.querySelector('.item-composer').addEventListener('click', itemComposer, false);

function itemComposer (evt) {
	evt.preventDefault();

	//var that = this; // wtf?
	var selectElm = doc.querySelector(this.getAttribute('data-select-elm')); 
	var targetBtn = evt.target.classList.contains('btn') ? evt.target : findAncestor(evt.target, 'btn');
	var targetWrapper = findAncestor(targetBtn, 'itemcontainer');

	if (targetBtn.classList.contains('btn-move-left') && targetWrapper.previousElementSibling) {
		targetWrapper.parentNode.insertBefore(targetWrapper, targetWrapper.previousElementSibling);
	}
	if (targetBtn.classList.contains('btn-move-right') && targetWrapper.nextElementSibling) {
		targetWrapper.parentNode.insertBefore(targetWrapper, targetWrapper.nextElementSibling.nextElementSibling);
	}
	if (targetBtn.classList.contains('btn-remove')) {
		targetWrapper.remove();
	}
}

var target = document.querySelector('.item-composer');

if (target) {
	var observer = new MutationObserver(function(mutations) {
		var items = target.querySelectorAll('[data-id]');
		var selectElm = doc.querySelector(target.getAttribute('data-select-elm'));

		while (selectElm.firstChild) { 
			selectElm.removeChild(selectElm.firstChild); 
		}
		
		for(var i = 0; i < items.length; ++i){
			var option = doc.createElement('option');
			option.setAttribute('value', items[i].getAttribute('data-id'));
			option.setAttribute('selected', 'selected');
			selectElm.appendChild(option);
		}
			/*mutations.forEach(function(mutation) {
					console.log(mutation.type);
			});*/
	});

	observer.observe(target, {childList: true});  
}

// Mobile menu toggler
var navbarToggle = doc.querySelector('.navbar-toggle');
if(navbarToggle){
	navbarToggle.addEventListener('click', function(evt){
		this.classList.toggle('collapsed');
		doc.querySelector('body').classList.toggle('mobile-menu-visible');
	});
}