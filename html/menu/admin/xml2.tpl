<tree>
	<!--{@ ITEM}-->
	<tree icon="{.icon}" text="{.str_title}" action="javascript:detail('{.num_mcode}','{.chr_type}')" {.submenu} />
	<!--{/}-->
	<!--{? enable_add}-->
		<tree icon="image/icon/wizard.gif" action="javascript:add_menu('{parent}')" text="&lt;메뉴생성&gt;" /><!--{/}-->
</tree>
