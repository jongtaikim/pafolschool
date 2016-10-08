<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
- <channel>
  <title>{HOST_NAME}-{board_title}</title> 
  <link><![CDATA[ http://{HOST}/board.list?mcode={mcode}]]> </link> 
- <description>
- <![CDATA[  {HOST_NAME}-{board_title}   ]]> 
  </description>
  <language>ko</language> 
{@ LIST}
- <item>
  <title><![CDATA[ {.str_title} ]]> </title> 
  <link><![CDATA[ http://{HOST}/board.read?mcode={.num_mcode}&id={.num_serial}&num={.num_serial}]]> </link> 
- <description>
- <![CDATA[ 
 
{.content}


  ]]> 
  </description>
  <dc:subject></dc:subject> 
  <pubDate>{.dt_date}</pubDate> 
  <author>{.str_user}</author> 
  </item>
{/}
  </channel>
  </rss>