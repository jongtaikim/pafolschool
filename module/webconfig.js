	// Creates a new plugin class and a custom listbox
tinymce.create('tinymce.plugins.ExamplePlugin', {
	createControl: function(n, cm) {
		switch (n) {
			case 'mymenubutton':
				var c = cm.createMenuButton('mymenubutton', {
					title : '�������',
					image : '/tinymce/jscripts/tiny_mce/plugins/example/img/example.gif',
					icons : '/tinymce/jscripts/tiny_mce/plugins/example/img/example.gif'
				});

				c.onRenderMenu.add(function(c, m) {
					var sub;
 
	 			



sub = m.addMenu({title : '���ͳ� ���� ���'});

					sub.add({title : '��������(����߰��ϼ���)', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<table class="table01" style="height: 89px;" border="0" width="497" align="center"  ><tbody><tr><td align="center" height="350">�̰��� ������ ��������</td></tr><tr><td style="padding: 5px;" align="center">&nbsp;���п��ට �����Դϴ�.</td></tr></tbody></table><br><br>');
					}});

sub =  m.add({title : '-------------------------'});

sub = m.addMenu({title : 'Ÿ��Ʋ��'});

					sub.add({title : '��', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<TABLE cellpadding="0" cellspacing="0" border="0" width = 680 height = 52 ><TR><td background="/image/star_title1.gif" width = 42><TD  background="/image/star_title2.gif" style = "padding-left:10px"><b style="font-size:13px;color:#0D518B"> ������ �Է��ϼ���</b></TD><td width = 25 background="/image/star_title3.gif"></td></TR></TABLE><br>');
					}});


					sub.add({title : '������', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<TABLE cellpadding="0" cellspacing="0" border="0" width = 601 height = 66 background = "/image/o_title.gif" ><TR><td  width = 22><TD  valign = top  style = "padding-left:10px;padding-top:13px"><b style="font-size:13px;color:#C79F7C"> ������ �Է��ϼ���</b></TD><td width = 25 ></td></TR></TABLE><br>');
					}});


					sub.add({title : '�ⱸ', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<TABLE cellpadding="0" cellspacing="0" border="0" width = 601 height = 66 background = "/image/g_title.gif" ><TR><td  width = 22><TD  valign = top  style = "padding-left:10px;padding-top:13px"><b style="font-size:13px;color:#C79F7C"> ������ �Է��ϼ���</b></TD><td width = 25 ></td></TR></TABLE><br>');
					}});

					sub.add({title : '�ʷϻ� ������', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<table cellpadding="0" cellspacing="0" border="0" width="680" height="45" background="/html/admin2/images/sub_title_bg.gif" >				<tr>					<td style="padding:0 6 0 2" width="20" align = right  height = 45><img src="/html/admin2/images/icon4.gif" ></td>					<td style="padding:3 0 0 0; color:454545" ><b>������ �Է��Ͻÿ�</b></td>				</tr></table><br>');
					}});


					


sub = m.addMenu({title : '������'});


		sub.add({title : '����/����������', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/hosts/yh.hkedu.co.kr/files//1199070282.img.gm">');
					}});

		sub.add({title : '1�г�', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/hosts/yh.hkedu.co.kr/files//1199071882.img.gm">');
					}});

		sub.add({title : '2�г�', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/hosts/yh.hkedu.co.kr/files//1199070917.img.gm">');
					}});

		sub.add({title : '3�г�', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/hosts/yh.hkedu.co.kr/files//1199071162.img.gm">');
					}});

		sub.add({title : '4�г�', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/hosts/yh.hkedu.co.kr/files//1199071998.img.gm">');
					}});


		sub.add({title : '5�г�', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/hosts/yh.hkedu.co.kr/files//1199072361.img.gm">');
					}});


		sub.add({title : '6�г�', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/hosts/yh.hkedu.co.kr/files//1199072587.img.gm">');
					}});


		sub.add({title : '����', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/hosts/yh.hkedu.co.kr/files//1199072712.img.gm">');
					}});

		sub.add({title : '������', onclick : function() {
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/hosts/yh.hkedu.co.kr/files//1199072922.img.gm">');
					}});

	sub.add({title : '------------------------------', onclick : function() {

					}});


	sub.add({title : '�ٷΰ��� ������', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/img_lay/gogosing.gif" align="absmiddle">');
					}});


	sub.add({title : '12345678910 ������', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/img_lay/n1.gif" align="absmiddle"> <img src = "/img_lay/n2.gif" align="absmiddle"> <img src = "/img_lay/n3.gif" align="absmiddle">				<img src = "/img_lay/n4.gif" align="absmiddle">			<img src = "/img_lay/n5.gif" align="absmiddle">			<img src = "/img_lay/n6.gif" align="absmiddle">			<img src = "/img_lay/n7.gif" align="absmiddle">			<img src = "/img_lay/n8.gif" align="absmiddle">			<img src = "/img_lay/n9.gif" align="absmiddle">			<img src = "/img_lay/n10.gif" align="absmiddle">						');
					}});

	sub.add({title : '�� �� �� �� ������', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/img_lay/arw/up.gif" align="absmiddle"> <img src = "/img_lay/arw/down.gif" align="absmiddle"> <img src = "/img_lay/arw/left.gif" align="absmiddle"> <img src = "/img_lay/arw/right.gif" align="absmiddle">');
					}});


	sub.add({title : '�̺�Ʈ ������', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/image/event.gif" align="absmiddle">');
					}});


	sub.add({title : '�л�� ������', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/image/cap.gif" align="absmiddle">');
					}});

	sub.add({title : '�Խ��� ������', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/image/abc.gif" align="absmiddle">');
					}});


	sub.add({title : '���� ������', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/image/bilding.gif" align="absmiddle">');
					}});


	sub.add({title : 'å ������', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/image/book.gif" align="absmiddle">');
					}});

	sub.add({title : 'ǳ���Խ��� ������', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/image/bousl.gif" align="absmiddle">');
					}});


	sub.add({title : '�Ǳ� ������', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<img src = "/image/truput.gif" align="absmiddle">');
					}});



sub = m.addMenu({title : '����'});

	sub.add({title : '--  ������ �������� �ٷ� ���� --'});

	sub.add({title : '����1', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<table class="table01" style="height: 68px;" border="0" width="200"><tbody><tr><td><p style="TEXT-ALIGN: center"><span style="color: #ffcc00;"><img src="image/bilding.gif" alt="" align="absMiddle" /><strong><span style="color: #00ccff;">&nbsp;</span><span style="color: #666699;">������б� �̺�Ʈ<br /></span></strong><img style="FLOAT: right" src="img_lay/gogosing.gif" alt="" align="absMiddle" />&nbsp;</span><span style="color: #c0c0c0;">06.03 ~ 07.01&nbsp;&nbsp;&nbsp; </span></p></td></tr></tbody></table>');
					}});


	sub.add({title : '����2', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<table class="table01" style="height: 68px;" border="0" width="200"><tbody><tr><td><p style="TEXT-ALIGN: center"><span style="color: #ffcc00;"><strong><span style="color: #00ccff;"><img src="image/truput.gif" alt="" align="absMiddle" />&nbsp;</span><span style="color: #666699;">������б� ��������<br /></span></strong><img style="FLOAT: right" src="img_lay/gogosing.gif" alt="" align="absMiddle" />&nbsp;</span><span style="color: #c0c0c0;">06.03 ~ 07.01&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; </span></p></td></tr></tbody></table>');
					}});


	sub.add({title : '����3', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<table class="table01" style="height: 68px;" border="0" width="200"><tbody><tr><td><p style="TEXT-ALIGN: center"><span style="color: #ffcc00;"><strong><span style="color: #00ccff;"><img src="image/book.gif" alt="" align="absMiddle" />&nbsp;</span><span style="color: #666699;">������б� ������<br /></span></strong><img style="FLOAT: right" src="img_lay/gogosing.gif" alt="" align="absMiddle" />&nbsp;</span><span style="color: #c0c0c0;">09.03&nbsp;OPEN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; </span></p></td></tr></tbody></table>');
					}});



	sub.add({title : '����4', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<table class="table01" style="height: 68px;" border="0" width="200"><tbody><tr><td><p style="TEXT-ALIGN: center"><span style="color: #ffcc00;"><strong><span style="color: #00ccff;"><img src="http://sang.hkedu.co.kr/image/cap.gif" alt="" align="absMiddle" />&nbsp;</span><span style="color: #666699;">������б� ��������<br /></span></strong><img style="FLOAT: right" src="img_lay/gogosing.gif" alt="" align="absMiddle" />&nbsp;</span><span style="color: #c0c0c0;">02.07&nbsp;�ַ���&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></p></td></tr></tbody></table>');
					}});


	sub.add({title : '����5', onclick : function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<table class="table01" style="height: 68px;" border="0" width="200"><tbody><tr><td><p style="TEXT-ALIGN: center"><span style="color: #ffcc00;"><strong><span style="color: #00ccff;"><img src="http://sang.hkedu.co.kr/image/bousl.gif" alt="" width="33" height="43" align="absMiddle" />&nbsp;<br /></span><span style="color: #666699;">������б� �����ڶ��<br />��� ��ȸ<br /></span></strong><img style="FLOAT: right" src="img_lay/gogosing.gif" alt="" align="absMiddle" />&nbsp;<span style="color: #99cc00;">������ :</span> </span><span style="color: #c0c0c0;">09.03&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></p></td></tr></tbody></table>');
					}});


				});

				// Return the new menu button instance
				return c;
		}

		return null;
	}
});

// Register plugin with a short name
tinymce.PluginManager.add('example', tinymce.plugins.ExamplePlugin);


	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		skin_variant : "silver",
		language : "ko",

		//plugins : "-example,layer,table,save,advhr,advimage,advlink,inlinepopups,media,print,contextmenu,paste,fullscreen,noneditable,visualchars",
		plugins : "-example,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",


		// Theme options

		

		theme_advanced_buttons1 : "mymenubutton,|,newdocument,pasteword,|,code,|,search,replace,|,image,media,|,hr,|,insertlayer,moveforward,movebackward,absolute,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,pagebreak,",

		theme_advanced_buttons2 : "styleprops,|,formatselect,|,fontselect,fontsizeselect,|,bold,underline,forecolor,backcolor,|,table",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",

		theme_advanced_fonts : "����=����;�ü�=�ü�;����=����;����=����;HY��M=HY��M;HY��B=HY��B;HY��L=HY��L;�굹����M=�굹����M;HY�߰��=HY�߰��;",


		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resize_horizontal : false,
		theme_advanced_resizing : true,
		valid_elements : '@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|name|href|target|title|class|onfocus|onblur],strong/b,em/i,strike,u,#p[align],-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,-span,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width|height|src|url|*],script[src|type],map[name],area[shape|coords|href|alt|target],fieldset[style],legend,style[rel|type|href]',

		visual : 1,
		accessibility_focus : 0,		
		table_inline_editing :1,
		forced_root_block : '',
		hidden_input : 0,
		padd_empty_editor : 0,

/*			// 2008-04-30 ���� ������ �⺻����
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
		content_css : "/css/edit.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "/tinymce/examples/lists/template_list.js",
		external_link_list_url : "/tinymce/examples/lists/link_list.js",
		external_image_list_url : "/tinymce/examples/lists/image_list.js",
		media_external_list_url : "/tinymce/examples/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});






<!-- /TinyMCE -->
