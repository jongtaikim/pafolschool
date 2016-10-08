

	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		skin_variant : "silver",
		language : "ko",

		//plugins : "-example,layer,table,save,advhr,advimage,advlink,inlinepopups,media,print,contextmenu,paste,fullscreen,noneditable,visualchars",
		plugins : "layer,table,save,advhr,advimage,advlink,inlinepopups,media,print,contextmenu,paste,fullscreen,noneditable,visualchars",


		// Theme options

		

		theme_advanced_buttons1 : "code,cleanup,image,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect,|,bold,italic,underline,strikethrough,forecolor,backcolor,|,table,|,link,unlink,",

		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",

		theme_advanced_fonts : "±¼¸²=±¼¸²;±Ã¼­=±Ã¼­;µ¸¿ò=µ¸¿ò;¹ÙÅÁ=¹ÙÅÁ;HY°­M=HY°­M;HY°­B=HY°­B;HY°­L=HY°­L;»êµ¹±¤¼öM=»êµ¹±¤¼öM;HY°ß°íµñ=HY°ß°íµñ;",


		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resize_horizontal : false,
		theme_advanced_resizing : true,
	valid_elements : '@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|name|href|target|title|class|onfocus|onblur],strong/b,em/i,strike,u,#p[align],-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,div[width|height|id|cid|style|name|class|onload|onclick],-span,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],object[id|classid|width|height|codebase|*],param[name|value|_value],embed[type|width|height|src|url|*],script[src|type],map[name],area[shape|coords|href|alt|target],wa:applet[module|code|width|height],col[width|align],input[type|width|height|src|style|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup]',


		visual : 1,
		accessibility_focus : 1,		
		table_inline_editing :1,
		forced_root_block : '',
		hidden_input : 0,
		padd_empty_editor : 0,
			convert_urls : 0,
			relative_urls : 0,

/*			// 2008-04-30 Á¾ÅÂ ¿¡µðÅÍ ±âº»¼¼ÆÃ
				id : id,
				language : 'en',
				docs_language : 'en',
				theme : 'simple',
				skin : 'default',
				delta_width : 0,
				delta_height : 0,
				popup_css : '',
				plugins : '',
				document_base_url : tinymce.documentBaseURL,
				add_form_submit_trigger : 1,
				submit_patch : 1,
				add_unload_trigger : 1,
				convert_urls : 1,
				relative_urls : 1,
				remove_script_host : 1,
				table_inline_editing : 0,
				object_resizing : 1,
				cleanup : 1,
				accessibility_focus : 1,
				custom_shortcuts : 1,
				custom_undo_redo_keyboard_shortcuts : 1,
				custom_undo_redo_restore_selection : 1,
				custom_undo_redo : 1,
				doctype : '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">',
				visual_table_class : 'mceItemTable',
				visual : 1,
				inline_styles : true,
				convert_fonts_to_spans : true,
				font_size_style_values : 'xx-small,x-small,small,medium,large,x-large,xx-large',
				apply_source_formatting : 1,
				directionality : 'ltr',
				forced_root_block : 'p',
				valid_elements : '@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|name|href|target|title|class|onfocus|onblur],strong/b,em/i,strike,u,#p[align],-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,-span,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target]',
				hidden_input : 1,
				padd_empty_editor : 1,
				render_ui : 1,
				init_theme : 1,
				force_p_newlines : 1,
				indentation : '30px'*/




		plugin_preview_width : "600",
		 plugin_preview_height : "600",
		 //dialog_type : "modal",
		force_br_newlines : false,
		use_native_selects : false,


		// Example content CSS (should be your site CSS)
		content_css : "/css/edit.css"

		// Drop lists for link/image/media/template dialogs
		
		

		// Replace values for the template plugin

	});






<!-- /TinyMCE -->
