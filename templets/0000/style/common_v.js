$(function(){

/*list tab*/
function clicktabs(tit_id,box_id,cur){
		var g_tags=$(tit_id),
			g_conts=$(box_id),
			g_current=cur;
		g_tags.mouseover(function(){
			var g_index=g_tags.index(this);
			$(this).addClass(g_current).siblings().removeClass(g_current);
			g_conts.eq(g_index).show().siblings().hide();
		})
	}

	clicktabs("#labels_id li","#labels_con>div","current");
	clicktabs("#labels_id01 li","#labels_con01>div","current");
	clicktabs("#labels_id02 li","#labels_con02>div","current");
	clicktabs("#labels_id03 li","#labels_con03>div","current");
	clicktabs("#labels_id04 li","#labels_con04>ol","current");

	/*fav*/
	$("#fav").click(function() { 
		var ctrl = (navigator.userAgent.toLowerCase()).indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL'; 
		if (document.all){ 
		  window.external.addFavorite('http://www.dawuge.com/?fav','大吴哥娱乐网，中国娱乐八卦网站'); 
		  }else if (window.sidebar){ 
		 window.sidebar.addPanel('大吴哥娱乐网，中国娱乐八卦网站',  'http://www.dawuge.com/?fav', ""); 
	   }else { 
			   alert('您可以尝试通过快捷键' + ctrl + ' + D 加入到收藏夹!'); 
	   } 
	});




});
