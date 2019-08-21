/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	// Kcfinder

	config.height = 250;
	config.extraPlugins = 'letterspacing,justify,lineutils,youtube';
	config.entities = false;
	config.allowedContent = true;
	config.toolbarGroups = [
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'others' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'about' }
	];

	config.skin = 'moono';
	config.filebrowserBrowseUrl = BASE_URL+'plugins/kcfinder-master/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl = BASE_URL+'plugins/kcfinder-master/browse.php?opener=ckeditor&type=images';
	config.filebrowserFlashBrowseUrl = BASE_URL+'plugins/kcfinder-master/browse.php?opener=ckeditor&type=flash';
	config.filebrowserUploadUrl = BASE_URL+'plugins/kcfinder-master/upload.php?opener=ckeditor&type=files';
	config.filebrowserImageUploadUrl = BASE_URL+'plugins/kcfinder-master/upload.php?opener=ckeditor&type=images';
	config.filebrowserFlashUploadUrl = BASE_URL+'plugins/kcfinder-master/upload.php?opener=ckeditor&type=flash';

};
