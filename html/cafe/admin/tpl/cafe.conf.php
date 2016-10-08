;<?/*

name = "{{str_title}}"               ; 게시판 이름
mcode = {{num_mcode}}
skin = "{{str_skin}}"
use_comment = {{chr_comment}}

[option]
listnum = {{num_listnum}}
navnum = {{num_navnum}}
titlelen = {{num_titlelen}}
listtype = {{listtype}}

[colors]
odd = {{chr_oddcolor}}
even = {{chr_evencolor}}

[filtering]
filter_words = {{str_filter}}
spam_ip = {{str_spamip}}

[pds]
preview = {{num_preview}}
downable = {{num_downable}}
frontpage = {{num_frontpage}}

[addition]
use_notice = {{num_usenotice}}
use_category = {{num_usecategory}}
use_editor = {{num_editor}}
use_upload = {{num_upload}}
use_downlist = {{num_downlist}}
use_script = {{num_script}}
use_rss = {{num_rss}}
use_trackback = {{num_trackback}}
use_slide = {{num_slide}}

;; 이하 부분은 아직 결정되지 않았습니다.
[access]
level = 5                       ; 이 레벨보다 높은 유저는 게시판의 owner가 됨
group = wheel,teacher,parent    ; 이 그룹들에 속해있으면 그룹의 권한을 가짐

[permission]
owner = alrcwmd
group = -lrc---
other = -l-----

;*/?>)
