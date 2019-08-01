document.write("<script type=\"text/javascript\" src=\"/js/fl.js\"></script>")
function mm_ads(id){
switch(id){
//头部右边
case "ad01":
document.write("<script type=\"text/javascript\">/*120*270，创建于2012-3-7*/ var cpro_id = \'u796570\';</script><script src=\"http://cpro.baidu.com/cpro/ui/f.js\" type=\"text/javascript\"></script>")
break;
//横幅广告960*90
case "ad02":
document.write("<script type=\"text/javascript\">/*960*90，创建于2011-7-5*/ var cpro_id = \'u529180\';</script><script src=\"http://cpro.baidu.com/cpro/ui/c.js\" type=\"text/javascript\"></script>")
break;
//热点关注条
case "ad03":

break;
//网站底部
case "ad04":
document.write("<script src=\"http://r.qiyou.com/view.php?uid=11387\"></script>")
break;
//内容页分享
case "ad05":
document.write("<div id=\"bdshare\" class=\"bdshare_t bds_tools get-codes-bdshare\"><span class=\"bds_more\">分享到：</span><a class=\"bds_qzone\"></a><a class=\"bds_tsina\"></a><a class=\"bds_tqq\"></a><a class=\"bds_renren\"></a><a class=\"bds_kaixin001\"></a><a class=\"shareCount\"></a></div><script type=\"text/javascript\" id=\"bdshare_js\" data=\"type=tools&amp;mini=1&amp;uid=300979\" ></script><script type=\"text/javascript\" id=\"bdshell_js\"></script><script type=\"text/javascript\">document.getElementById(\"bdshell_js\").src = \"http://bdimg.share.baidu.com/static/js/shell_v2.js?t=\" + new Date().getHours();</script>")
break;
//内容区上
case "ad06":
document.write("<div style=\"text-align:center\"><script type=\"text/javascript\">/*580*90，创建于2012-6-4*/ var cpro_id = 'u927416';</script><script src=\"http://cpro.baidu.com/cpro/ui/c.js\" type=\"text/javascript\"></script></div>");
break;
//内容区下
case "ad07":
var random = {
	ad0:10,
	ad1:20,
	init : function(){
		n = (Math.floor(Math.random()*random.ad1+1));
		if(n <= random.ad0){
document.writeln("<script type=text\/javascript  language=javascript>");
document.writeln("var Xstar_userid=\'400570\';");
document.writeln("var Xstar_subid=\'0\';");
document.writeln("var Xstar_logo=\'true\';");
document.writeln("var Xstar_encode=\'CPsib6lFuSTu%2b43feBj27%2fsMKdBIUpnljfpVaXcJUFknQx6ngWkJkg%3d%3d&ar2s=1\';");
document.writeln("var Xstar_exid=\'0\';");
document.writeln("var Xstar_width=\'300\';");
document.writeln("var Xstar_height=\'240\';");
document.writeln("<\/script><script type=text\/javascript language=javascript src=\'http:\/\/js.Xstar.cc\/code.js\'><\/script>")
	}
		else if(n > random.ad0 && n <= random.ad1){
document.writeln("<script type=text\/javascript  language=javascript>");
document.writeln("var Xstar_userid=\'400570\';");
document.writeln("var Xstar_subid=\'0\';");
document.writeln("var Xstar_logo=\'true\';");
document.writeln("var Xstar_encode=\'AZ1dpajLINkGOgr5NoTURYHrRuRfsVaUKgXgFcJ%2f4vl805XCnsIr%2fw%3d%3d&ar2s=1\';");
document.writeln("var Xstar_exid=\'0\';");
document.writeln("var Xstar_width=\'400\';");
document.writeln("var Xstar_height=\'300\';");
document.writeln("<\/script><script type=text\/javascript language=javascript src=\'http:\/\/js.Xstar.cc\/code.js\'><\/script>")
		}
	}
}
random.init();
break;
//内容区相关阅读上面
case "ad08":
document.write('<iframe src="http://www.dawuge.com/ad/ctext.html" width="650" height="80" frameborder="0" scrolling="no"></iframe>');
document.writeln("<div class=\"uphot top10\"><span>推荐：</span><ul>");
document.writeln("<li><a href=\""+LLSITE[0]+"\" target=\"_blank\">窥视女性隐私（图）<\/a><\/li>");
document.writeln("<li><a href=\""+LLSITE[1]+"\" target=\"_blank\">新婚模仿A片让我欲罢不能<\/a><\/li>");
document.writeln("<li><a href=\""+LLSITE[2]+"\" target=\"_blank\">干露露母女最新“摸奶照”！<\/a><\/li>");
document.writeln("</ul></div>");
document.writeln("<script type=\'text/javascript\'>");
document.writeln("var sogou_param = new Array();");
document.writeln("sogou_param[\"pid\"]  = \'qianyan001com\';");
document.writeln("sogou_param[\"ct\"]  = \'kwd\';");
document.writeln("sogou_param[\"fmt\"]  = \'h_kwd\';");
document.writeln("sogou_param[\"dn\"]  = \'4\';");
document.writeln("sogou_param[\"iw\"]   = \'650\';");
document.writeln("sogou_param[\"ih\"]   = \'86\';");
document.writeln("sogou_param[\"fs\"] = \'14\';");
document.writeln("sogou_param[\"c_bo\"] = \'e6e6e6\';");
document.writeln("sogou_param[\"c_bg\"] = \'e6e6e6\';");
document.writeln("sogou_param[\"c_fg\"] = \'e70808\';");
document.writeln("sogou_param[\"tdw\"] = \'120\';");
document.writeln("sogou_param[\"charset\"] = \'gb2312\';");
document.writeln("sogou_param[\"rn\"] = \'3\';");
document.writeln("sogou_param[\"cn\"] = \'5\';");
document.writeln("sogou_param[\"ul\"] = \'0\';");
document.writeln("</script>");
document.writeln("<script language=\'JavaScript\' type=\'text/javascript\' src=\'http://images.sohu.com/cs/jsfile/js/lu.js\'></script>");
break;
//内容区精彩推荐第一行
case "ad09":
document.write('<script type="text/javascript" src="/d/js/acmsd/hz.js"></script>');
break;
//内容区精彩推荐最后一行
case "ad10":
document.write('<script type="text/javascript" src="/d/js/acmsd/hz1.js"></script>');
break;
//内容区右边顶部
case "ad11":
document.write("<script type=\"text/javascript\">/*300*250，创建于2011-12-31*/ var cpro_id =\"u728863\";</script><script src=\"http://cpro.baidu.com/cpro/ui/c.js\" type=\"text/javascript\"></script>")
break;
//内容区右边视觉焦点上
case "ad12":
document.writeln('<script language="javascript" src="http://u493025.778669.com/fshow.php?id=174837"></script>');
document.writeln("<iframe scrolling=\"no\" height=\"200\" frameborder=\"0\" width=\"300\" src=\"/ad/sogou330.html\"></iframe>");
function yaola_1286790016_78176_28341_1(){
	d  = document.getElementById("div_1286790016_78176_28341");
	dd = (document.compatMode && document.compatMode!="BackCompat")?"document.documentElement":"document.body";
	ddw= dd+'.clientWidth';
	ddl= dd+'.scrollLeft';
	ddt= dd+'.scrollTop';
	ddh= dd+'.clientHeight';
	//d.style.left=eval(ddl)+eval(ddw)-parseInt(d.style.width)+"px";
	d.style.left="0px";
	d.style.top=eval(ddt)+eval(ddh)-parseInt(d.style.height)+"px";
	setTimeout("yaola_1286790016_78176_28341_1()",500);
}
function sui(arr,num){
   var temp_array = new Array();
   for (var index in arr) {
      temp_array.push(arr[index]);
   }
   var return_array = new Array();
   for (var i = 0; i<num; i++) {
      if (temp_array.length>0) {
         var arrIndex = Math.floor(Math.random()*temp_array.length);
         return_array[i] = temp_array[arrIndex];
         temp_array.splice(arrIndex, 1);
      }
	  else {
      break;
      }
   }
   return return_array;
}
var pft = new Array();
pft.push({'title':'<img src="/ad/yl/c1.jpg" width="140" height="100" />','ys':'网传范冰冰酒店激情被拍'});
pft.push({'title':'<img src="/ad/yl/c2.jpg" width="140" height="100" />','ys':'某酒店技师秀场'});
pft.push({'title':'<img src="/ad/yl/c3.jpg" width="140" height="100" />','ys':'空虚寂寞女孩都会这样？'});
pft.push({'title':'<img src="/ad/yl/c4.jpg" width="140" height="100" />','ys':'安全套试用员工作揭秘'});
pft.push({'title':'<img src="/ad/yl/c5.jpg" width="140" height="100" />','ys':'真实诱惑！性感车模写真'});
pft.push({'title':'<img src="/ad/yl/c6.jpg" width="140" height="100" />','ys':'不管你信不信 我被雷到了'});
pft.push({'title':'<img src="/ad/yl/c7.jpg" width="140" height="100" />','ys':'抓拍开放校园情侣野'});

function pftr() {
   var nr="";
   pft=sui(pft,4);
   for (var u=0;u<4;u++){
      var titles=eval("pft")[u]["title"];
      var yss=eval("pft")[u]["ys"];
nr=nr+"<li><a href=\"/htm/dian.php?action=yule&url=www.hao123.com\" target=\"_blank\">"+titles+"</a><a href=\"/htm/dian.php?action=yule&url=www.hao123.com\" target=\"_blank\">"+yss+"</a></p></li>";

   }
   return nr;
}
var turl=encodeURIComponent(top.window.location);
var strsc="<div id=\"news_pic\"><div id='div_1286790016_78176_28341' class=\"bd\" style='overflow:hidden;margin:auto;clear:both;'><ul>";
strsc+=pftr();
/*strsc+="<div class=title11><a id=\"pf1\" href=\"\" name=\'f\' onmousedown=\"gourl(this.id);\" target=\"_blank\" ><font color=red>猖狂男女学生在校园偷吃</font></a></div>";
strsc+="<div class=title11><a id=\"pf10\" href=\"\" name=\'f\' onmousedown=\"gourl(this.id);\" target=\"_blank\" ><font color=blue>11年度MM走光图集锦</font></a></div>";*/
strsc+="</ul></div></div>";
document.write(strsc);
yaola_1286790016_78176_28341_1();
break;
}
}