CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'align', 'list', 'indent', 'blocks', 'bidi', 'paragraph' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		'/',
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Save,PasteText,PasteFromWord,Flash,Smiley,PageBreak,Iframe,Anchor,Unlink,Link,BidiLtr,BidiRtl,Language,Blockquote,CreateDiv,CopyFormatting,RemoveFormat,Strike,Subscript,Superscript,About,ShowBlocks,Styles,Format,BulletedList,NumberedList,Table,Print,NewPage,HiddenField,ImageButton,Button,Select,Textarea,TextField,Radio,Checkbox,Form,Scayt,SelectAll,Find,Replace,SpecialChar';
};
