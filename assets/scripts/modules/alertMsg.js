'use strict'

var doc = document;
var win = window;

exports.init = function(message, targetElm, style, position){
	var style = (typeof style !== 'undefined') ? style : 'alert-danger';
	var errorWrapper = document.createElement('div');
	var button = document.createElement('button');
	var rect;

	errorWrapper.classList.add('errormsg', 'alert', 'alert-dismissible', 'margin-top', style);
	button.classList.add('close');
	button.setAttribute('aria-label', 'Close');
	button.textContent = 'x';

	errorWrapper.textContent = message;
	errorWrapper.appendChild(button);

	button.addEventListener('click', function cb(evt){ errorWrapper.remove(); }, false)
	win.setTimeout(function(){ errorWrapper.remove(); }, 5000);

	if (position == 'before') {
		targetElm.parentNode.insertBefore(errorWrapper, targetElm);
	}
	else if(position == 'after') {
		targetElm = targetElm.nextSibling;
		targetElm.parentNode.insertBefore(errorWrapper, targetElm);
	}
	else{
		targetElm.appendChild(errorWrapper);
	}

	rect = errorWrapper.getBoundingClientRect();
	
	if(rect.top < 0 ){
		errorWrapper.scrollIntoView({block: "start", behavior: "smooth"});
	}
	else if (rect.bottom > (window.innerHeight || document.documentElement.clientHeight)){
		errorWrapper.scrollIntoView({block: "end", behavior: "smooth"});
	}
}
