'use strict'

var doc = document;
var win = window;

var scribeEditor = require('scribe-editor');
var scribePluginToolbar = require('scribe-plugin-toolbar');
var scribePluginSmartLists = require('scribe-plugin-smart-lists');
var scribePluginHeadingCommand = require('scribe-plugin-heading-command');
var scribePluginSanitizer = require('scribe-plugin-sanitizer');
var scribePluginContentCleaner = require('./third/scribe-plugin-content-cleaner');


module.exports = function(wysiwygTextArea, toolbar){
	
	var scribe = new scribeEditor(wysiwygTextArea);  

	scribe.use(scribePluginSmartLists());
	scribe.use(scribePluginHeadingCommand(2));
	scribe.use(scribePluginContentCleaner());
	scribe.use(scribePluginSanitizer({ 
		tags: {
			p: {},
			b: {},
			i: {},
			br: {},
			h2: {},
			a: {},
			ol: {},
			ul: {},
			li: {},
			blockquote: {}
			}}));

	scribe.use(scribePluginToolbar(toolbar));
	
	scribe.on('content-changed', function(){
		wysiwygTextArea.parentNode.querySelector('textarea').value = scribe.getHTML();
		//wysiwygTextArea.value = scribe.getHTML();
	});	
}
