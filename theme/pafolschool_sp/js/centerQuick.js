/* 가운데 정렬 레이아웃용 퀵메뉴

$(document).ready(function(){
    $('#quick_area').centerQuick(1000, 20, 320, 50); // (가운데 메인영역 넓이, 메인과 퀵메뉴의 좌측 간격, 초기 기본 높이, 스크롤 내렸을 경우 상단 간격)
});
*/
(function($) {
    jQuery.fn.centerQuick = function(m_width, m_left, m_top, s_top) {
        this.each(function() {
            var self = $(this);
            var left = ($(document).width() - m_width) / 2 + m_width + m_left;
            self.css({
                'position' : 'absolute',
                'top' : m_top + 'px',
                'left' : left + 'px'
            });
            $(window).scroll(function() {
                var c_top = $(document).scrollTop();
                var top = 0;
                if (c_top + s_top > m_top) {
                    top = c_top + s_top;
                } else {
                    top = m_top;
                }
                
                self.stop().animate({"top": top+"px"}, 500);
            });
            $(window).resize(function() {
                var w_width = $(window).width();
                var left = (w_width - m_width) / 2 + m_width + m_left;
                if (w_width < m_width) {
                    left = m_width + m_left;
                }
                
                self.css('left', left + 'px');
            });
        });
    }
})(jQuery);