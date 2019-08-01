var bloghost = "http://www.zhw168.net/";
var cookiespath = "/";
var ajaxurl = "http://www.zhw168.net/zb_system/cmd.php?act=ajax&src=";
var lang_comment_name_error = "名称不能为空或格式不正确";
var lang_comment_email_error = "邮箱格式不正确，可能过长或为空";
var lang_comment_content_error = "评论内容不能为空或过长";

$(function () {var $cpLogin = $(".cp-login").find("a");var $cpVrs = $(".cp-vrs").find("a");SetCookie("timezone", (new Date().getTimezoneOffset()/60)*(-1));var $addoninfo = GetCookie("addinfo");if(!$addoninfo){LoadRememberInfo();return ;}$addoninfo = eval("("+$addoninfo+")");if($addoninfo.chkadmin){$(".cp-hello").html("欢迎 " + $addoninfo.useralias + " (" + $addoninfo.levelname  + ")");if ($cpLogin.length == 1 && $cpLogin.html().indexOf("[") > -1) { $cpLogin.html("[后台管理]");} else {$cpLogin.html("后台管理");};}if($addoninfo.chkarticle){if ($cpLogin.length == 1 && $cpVrs.html().indexOf("[") > -1) {$cpVrs.html("[新建文章]"); } else {$cpVrs.html("新建文章");};$cpVrs.attr("href", bloghost + "zb_system/cmd.php?act=ArticleEdt");}});

var $zbpzanalert = "您已经点过赞了"

document.writeln("<script src='http://www.zhw168.net/zb_users/plugin/UEditor/third-party/prism/prism.js' type='text/javascript'></script><link rel='stylesheet' type='text/css' href='http://www.zhw168.net/zb_users/plugin/UEditor/third-party/prism/prism.css'/>");$(function(){var compatibility={as3:"actionscript","c#":"csharp",delphi:"pascal",html:"markup",xml:"markup",vb:"basic",js:"javascript",plain:"markdown",pl:"perl",ps:"powershell"};if(document.querySelectorAll){var runFunction=function(doms,callback){for(var i=0;i<doms.length;i++){var preDom=doms.item(i);var codeDom=document.createElement("code");if(callback)callback(preDom);codeDom.innerHTML=preDom.innerHTML;codeDom.className="language-"+function(classObject){if(classObject===null)return"markdown";var className=classObject[1];return compatibility[className]?compatibility[className]:className}(preDom.className.match(/prism-language-([0-9a-zA-Z]+)/))+" prism-line-numbers";preDom.innerHTML="";preDom.appendChild(codeDom)}};runFunction(document.querySelectorAll("pre.prism-highlight"));runFunction(document.querySelectorAll('pre[class*="brush:"]'),function(preDom){var original;if((original=preDom.className.match(/brush:([a-zA-Z0-9\#]+);/))!==null){preDom.className="prism-highlight prism-language-"+original[1]}})}});
