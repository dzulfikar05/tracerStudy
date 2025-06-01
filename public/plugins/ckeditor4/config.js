CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	config.extraPlugins = 'font,colorbutton';

	config.fontSize_sizes = '8/8px;10/10px;12/12px;14/14px;16/16px;18/18px;24/24px;36/36px;';
	config.format_tags = 'p;h1;h2;h3;pre';

	config.removeButtons = 'Underline,Subscript,Superscript';
	config.removeDialogTabs = 'image:advanced;link:advanced';

	// Tambahkan warna khusus
	config.colorButton_colors = '1a3c8f,FF0000,00FF00,0000FF,FFFF00,FF00FF,00FFFF,000000,FFFFFF';
	// ↑ kamu bisa tambah warna lainnya di sini jika dibutuhkan

	// (Opsional) Izinkan pengguna memilih warna kustom
	config.colorButton_enableMore = true;
};
