'use strict'

MT.BasePath = (location.hostname  == 'localhost') ? '/mt' : '';

var doc = document;
var win = window;

var ajaxPanel = require('./modules/ajaxPanel.js');
var imageUploader = require('./modules/uploadImage.js');
var alertMsg = require('./modules/alertMsg.js');
var autocomplete = require('./modules/autocomplete.js');
var ajax = require('./modules/ajax.js');
var findAncestor = require('./modules/utils/findAncestor.js');
var ajaxFormSubmit = require('./modules/ajaxFormSubmit.js');


var ajaxPanels = doc.querySelectorAll('.ajax-panel');
for (var i = 0; i < ajaxPanels.length; ++i) {
	ajaxPanel(ajaxPanels[i]);
}


var uploadBtns = doc.querySelectorAll('.btn-upload-image');
for (var i = 0; i < uploadBtns.length; ++i) {
	imageUploader.init(uploadBtns[i]);
}


var deletBtns = doc.querySelectorAll('a.ajax-delete');
var ajaxDeleteBtn = require('./modules/ajaxDeleteBtn.js');
for (var i = 0; i < deletBtns.length; ++i) {
  ajaxDeleteBtn.init(deletBtns[i]);
}


var autoCompleteInputs = doc.querySelectorAll('input.autocomplete');

for (var i = 0; i < autoCompleteInputs.length; ++i){
  var url = autoCompleteInputs[i].getAttribute('data-url');
  var subQuery = autoCompleteInputs[i].classList.contains('sub-query');
  var thumbs = autoCompleteInputs[i].classList.contains('autocomplete-thumb');
  autocomplete.init(autoCompleteInputs[i], url, subQuery, thumbs);
  console.log("init" + subQuery + thumbs+url);
}

// Create exercise: upload image
var exImgUploadCB = function(status, data){
	data = JSON.parse(data);
  console.log(data);
	if(data.status == 1){
		var imageContainer = doc.querySelector('#exercise-images');
		imageContainer.insertAdjacentHTML('beforeend', data.markup);
		imageContainer.querySelector('.imageplaceholder') && imageContainer.querySelector('.imageplaceholder').remove();
    
    /*var select = doc.querySelector('select.images');
    var opt = doc.createElement('option');
    opt.value = data.id ? data.id : data.data.id;
    opt.setAttribute('selected', 'selected');
    select.appendChild(opt);*/
	}
	else{
		alertMsg.init(data.msg, doc.querySelector('.btn.btn-info'));	 // improve selector!	
	}
}


// imageUpload on create/update exercise page
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
    var url = MT.BasePath + '/media/getImageJSON?imageName=' + input.value + '&controls=true';
    ajax.get(url, exImgUploadCB);
  });
}

// Create workout: add exercise 
var exImportSubmits = doc.querySelectorAll('.btn-import-exercise');
for (var i = 0; i < exImportSubmits.length; ++i){
  var submitBtn = exImportSubmits[i];
  var input = doc.querySelector('#' + submitBtn.getAttribute('for'));
  console.log(submitBtn);
  var baseUrl = submitBtn.getAttribute('data-url');
  
  if (!input) continue;

  submitBtn.addEventListener('click', function(){
    var url = baseUrl + '&exerciseName=' + input.value;
    ajax.get(url, exImportCB);
  });

  function exImportCB(status, data){
    data = JSON.parse(data);
    console.log(data);
    if(data.status == true){
      var itemContainer = doc.querySelector('#workout-exercises');
      itemContainer.insertAdjacentHTML('beforeend', data.markup);
      itemContainer.querySelector('.placeholder') && itemContainer.querySelector('.placeholder').remove();
    }
    else{
      alertMsg.init(data.msg, submitBtn);   // improve selector! 
    }
  }
}

// exercise images controls
//doc.querySelector('.exercise-image-composer') && doc.querySelector('.exercise-image-composer').addEventListener('click', itemComposer, false);
doc.querySelector('.item-composer') && doc.querySelector('.item-composer').addEventListener('click', itemComposer, false);

function itemComposer (evt) {
  evt.preventDefault();

  var that = this; // wtf?
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


var ajaxForms = doc.querySelectorAll('.ajax-form');
for (var i = 0; i < ajaxForms.length; ++i) {
  ajaxFormSubmit(ajaxForms[i]);
}
