<?php
//@session_start();
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/oxwindow.class.php");

helper('changyan');

if(empty($dopost)) $dopost = '';
if(empty($action)) $action = '';
if(empty($nocheck)) $nocheck = '';
if(empty($forward)) $forward = '';

$_SESSION['changyan'] = !empty($_SESSION['changyan'])? $_SESSION['changyan'] : 0;
$_SESSION['user'] = !empty($_SESSION['user'])? $_SESSION['user'] : '';

$appid=$client_id=changyan_get_setting('appid');

if ($cfg_feedback_forbid=='N' AND !empty($client_id)) {
    $dsql->ExecuteNoneQuery("UPDATE `#@__sysconfig` SET `value`='Y' WHERE `varname`='cfg_feedback_forbid';");
    changyan_ReWriteConfig();
    ShowMsg("�Ѿ�����DedeCMSĬ�����ۣ������������ۣ�","?");
    exit();
}

if(empty($_SESSION['user']) AND empty($nocheck))
{
    $db_user = changyan_get_setting('user');
    $db_pwd=changyan_mchStrCode(changyan_get_setting('pwd'), 'DECODE');

    if(!empty($db_user) AND !empty($db_pwd))
    {
        header('Location:?dopost=quick_login&nocheck=yes&forward='.$forward);
        exit();
    } else {
        //header('Location:?dopost=login&nocheck=yes&forward='.$forward);
        //exit();
    }
}
//auto update
$version=changyan_get_setting('version');
if (empty($version)) $version = '0.0.1';
if (version_compare($version, CHANGYAN_VER, '<')) {
    $mysql_version = $dsql->GetVersion(TRUE);

    foreach ($update_sqls as $ver => $sqls) {
        if (version_compare($ver, $version,'<')) {
            continue;
        }
        foreach ($sqls as $sql) {
            $sql = preg_replace("#ENGINE=MyISAM#i", 'TYPE=MyISAM', $sql);
            $sql41tmp = 'ENGINE=MyISAM DEFAULT CHARSET='.$cfg_db_language;
            
            if($mysql_version >= 4.1)
            {
                $sql = preg_replace("#TYPE=MyISAM#i", $sql41tmp, $sql);
            }
            $dsql->ExecuteNoneQuery($sql);
        }
        changyan_set_setting('version', $ver);
        $version=changyan_get_setting('version');
    }
    $isv_app_key = changyan_get_isv_app_key();
}

if ($dopost=='quick_login')
{
    $user = changyan_get_setting('user');
    $pwd=changyan_mchStrCode(changyan_get_setting('pwd'), 'DECODE') ;
    $sign=changyan_gen_sign($user);
    $paramsArr=array(
        'client_id'=>CHANGYAN_CLIENT_ID,
        'user'=>$user,
        'password'=>$pwd,
        'sign'=>$sign);
    $rs=changyan_http_send(CHANGYAN_API_LOGIN,0,$paramsArr);
    $result=json_decode($rs,TRUE);
    if($result['status']==0)
    {
        $isv_id = changyan_get_setting('isv_id');
        $isvs = changyan_get_isvs();
        $isv_in = FALSE;
        if(!empty($isv_id)) {
            foreach($isvs as $isv){
                if($isv['id']==$isv_id)
                    $isv_in=TRUE;
            }
        }
        $_SESSION['changyan']=$result['token'];
        $_SESSION['user']=$user;
        if(!$isv_in)
        {
            ShowMsg("��δ����վ��APP��Ϣ����������á���",'?dopost=change_appinfo');
        } else {
            header('Location:?forward='.$forward);
        }
        exit();
    } else {
        changyan_set_setting('pwd', '');
        ShowMsg("��¼ʧ�ܣ�".$result['msg'],'?');
        exit();
    }
} elseif ($dopost=='login') {
    $user = empty($user)? '' : $user;
    $pwd = empty($pwd)? '' : $pwd;
    $sign=changyan_gen_sign($user);
    $paramsArr=array(
        'client_id'=>CHANGYAN_CLIENT_ID,
        'user'=>$user,
        'password'=>$pwd,
        'sign'=>$sign);
    $rs=changyan_http_send(CHANGYAN_API_LOGIN,0,$paramsArr);
    $result=json_decode($rs,TRUE);
    changyan_set_setting('user', $user);
    if ($result['status']==0)
    {
        changyan_set_setting('user', $user);
        $pwd = changyan_mchStrCode($pwd, 'ENCODE');
        changyan_set_setting('pwd', $pwd);
        $_SESSION['changyan']=$result['token'];
        $_SESSION['user']=$user;
        $login_url=CHANGYAN_API_SETCOOKIE.'?client_id='.CHANGYAN_CLIENT_ID.'&token='.$result['token'];
        echo <<<EOT
<iframe src="{$login_url}" scrolling="no" width="0" height="0" style="border:none"></iframe>
EOT;
        ShowMsg("��δ����վ��APP��Ϣ����������á���",'?dopost=change_appinfo');
        exit();
    }
    else {
        $_SESSION['changyan'] = 0;
        $_SESSION['user'] = '';
        unset($_SESSION['changyan']);
        unset($_SESSION['user']);
        changyan_set_setting('pwd', '');
        ShowMsg("��¼ʧ�ܣ�".$result['msg'],'?');
        exit();
    }
} elseif ($dopost=='change_appinfo') {
    $isvstr="<p> ѡ������Ҫ���õ�APPID��</p>";
    $jquery_src =  CHANGYAN_JQUERY_SRC;
    $isvs_jsonp = changyan_get_isvs_jsonp();
    echo <<<EOT
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$cfg_soft_lang}">
<title>�������۹���</title>
<link rel="stylesheet" type="text/css" href="{$cfg_plus_dir}/img/base.css">
{$jquery_src}
{$isvs_jsonp}
</head>
<body background='{$cfg_plus_dir}/img/allbg.gif' leftmargin="8" topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#DFF9AA">
  <tr>
    <td height="28" style="border:1px solid #DADADA" background='{$cfg_plus_dir}/img/wbg.gif'>&nbsp;<b><a href="?">��������ģ�� </a> ������APP��Ϣ</b></td>
  </tr>
  <tr>
  <td width="100%" height="80" style="padding-top:5px" bgcolor='#ffffff'>
  <script language='javascript'>
function CheckSubmit(){
	return true;
}
</script>
  <form name='myform' method='POST' onSubmit='return CheckSubmit();' action='?'>
  <input type='hidden' name='dopost' value='save_appinfo'>
  <table width='100%'  border='0' cellpadding='3' cellspacing='1' bgcolor='#DADADA'>
    <tr bgcolor='#DADADA'>
      <td colspan='2' background='{$cfg_plus_dir}/img/wbg.gif' height='26'><font color='#666600'><b>�������۹���</b></font></td>
    </tr>
    <tr bgcolor='#FFFFFF'>
      <td colspan='2'  height='100'>
      <table width="98%" border="0" cellspacing="1" cellpadding="1">
        <tbody>
            <tr>
                <td colspan="2" id="isvsContent">
                </td>
            </tr>
        </tbody>
      </table>
      </td>
    </tr>
    <tr>
      <td colspan='2' bgcolor='#F9FCEF'><table width='270' border='0' cellpadding='0' cellspacing='0'>
          <tr align='center' height='28'>
            <td width='90'><input name='imageField1' type='image' class='np' src='{$cfg_plus_dir}/img/button_ok.gif' width='60' height='22' border='0' /></td>
            <td width='90'><a href='?dopost=addsite' style="color:blue">����APP ID</a></td>
            <td><a href='?' style="color:blue">������һҳ</a></td>
          </tr>
        </table></td>
    </tr>
  </table>
  </td>
  </tr>
</table>
<p align="center"> <br>
  <br>
</p>
</body>
</html>
EOT;
} elseif ($dopost=='save_appinfo') {
    if (empty($appInfo)) {
        ShowMsg("��ѡ����ȷ��AppID��Ϣ��", '?dopost=change_appinfo');
        exit();
    }
    list($appid,$isv_app_key)=explode('|',$appInfo);
    changyan_set_setting('appid',$appid);
    changyan_set_setting('isv_app_key',$isv_app_key);
    $user=changyan_get_setting('user');
    $sign=changyan_gen_sign($user);
    $result = changyan_getcode(CHANGYAN_CLIENT_ID, $user, false, $sign,$appid);
    $isv_id = $result['isv_id'];

    changyan_set_setting('isv_id',$isv_id);
    changyan_clearcache();
    $isv_id = intval($isv_id);
    $changge_isv_url = CHANGYAN_API_CHANGE_ISV.$isv_id;
    echo <<<EOT
<iframe src="{$changge_isv_url}" scrolling="no" width="0" height="0" style="border:none"></iframe>
EOT;
    ShowMsg("�ɹ������µ�AppID��APPKEY��",'?',0,3000);
    exit();
} elseif ($dopost=='logout')
{
    echo <<<EOT
<iframe src="http://changyan.kuaizhan.com/logout" scrolling="no" width="0" height="0"></iframe>
EOT;
    $_SESSION['changyan'] = 0;
    $_SESSION['user'] = '';
    unset($_SESSION['changyan']);
    unset($_SESSION['user']);
    if($forward)
    {
        header('Location:?forward='.$forward);
        exit;
    } else {
        changyan_set_setting('pwd', '');
    }
    ShowMsg("�ɹ��˳����ԣ�",'?');
    exit();
} elseif ($dopost=='addsite') {
    $url = $_SERVER['SERVER_NAME'];
    $user=changyan_get_setting('user');
    $sign=changyan_gen_sign($user);
    $paramsArr=array(
        'user'=>$user,
        'client_id'=>CHANGYAN_CLIENT_ID,
        'isv_name'=>'New dedecms site',
        'url'=>$url,
        'sign'=>$sign);
    $rs=changyan_http_send(CHANGYAN_API_ADDSITE,0,$paramsArr);
    $result=json_decode($rs,TRUE);
    if($result['status']==1)
    {
        ShowMsg("�����վ��ʧ��", '?dopost=change_appinfo');
        exit();
    } else {
        changyan_set_setting('appid', $result['appid']);
        changyan_set_setting('id', $result['id']);
        changyan_set_setting('isv_id', $result['isv_id']);
        changyan_set_setting('isv_app_key', $result['isv_app_key']);
        $_SESSION['changyan']=$result['token'];
        changyan_clearcache();
        $isv_id = intval($result['isv_id']);
        $login_url=CHANGYAN_API_SETCOOKIE.'?client_id='.CHANGYAN_CLIENT_ID.'&token='.$result['token'];
        echo <<<EOT
<iframe src="{$login_url}" scrolling="no" width="0" height="0" style="border:none"></iframe>
EOT;
        ShowMsg("�ɹ����վ����Ϣ������վ���л�����",'?dopost=changeisv&isv_id='.$isv_id,0,3000);
        exit;
    }
} elseif ($dopost=='changeisv') {
    $isv_id = intval($isv_id);
    $changge_isv_url = CHANGYAN_API_CHANGE_ISV.$isv_id;
    $isv_app_key = changyan_get_isv_app_key();
    echo <<<EOT
<iframe src="{$changge_isv_url}" scrolling="no" width="0" height="0" style="border:none"></iframe>
EOT;
    ShowMsg("�ɹ��л�վ�㣡",'?');
    exit();
} elseif ($dopost=='manage' OR $dopost=='stat' OR $dopost=='setting'
OR $dopost=="import")
{
    if(!changyan_islogin())
    {
        ShowMsg("����δ��¼���ԣ����ȵ�¼�����ʹ�á�����",'?');
        exit();
    }
    changyan_check_islogin();
    $addstyle='scrolling="no" ';
    $type='audit';
    $appid=changyan_get_setting('appid');
    if($dopost=='manage') $type='audit';
    elseif($dopost=='stat') $type='stat';
    $ptitle = '�������۹���';

    $manage_url="http://s.changyan.kuaizhan.com/audit/comments/TOAUDIT/1";
    $addstr='';
    if($dopost=='setting') 
    {
        $ptitle = "��������";
        $manage_url="http://s.changyan.kuaizhan.com/setting/basic";
        
    } elseif ($dopost=='stat')
    {
        $ptitle = "����ͳ��";
        $manage_url="http://s.changyan.kuaizhan.com/stat-data/comment";
    } elseif ($dopost=='import')
    {
        $ptitle = "���Թ���";
        $export_str=$import_str='';
        $manage_url="?dopost=blank";
        $last_import=changyan_get_setting('last_import');
        $last_export=changyan_get_setting('last_export');
        if (empty($last_export)) {
            $export_str = '<font color="red">��δ���ݣ����鱸�ݣ�</font>';
        } else {
            $export_time = date('Y-m-d H:i:s', $last_export);
            $export_str = '<font color="#666">��󱸷����ڣ�'.$export_time.'</font>';
        }
        if (empty($last_import)) {
            $import_str = '<font color="red">��δ����DedeCMS���۵����ԣ�</font>';
        } else {
            $import_time = date('Y-m-d H:i:s', $last_import);
            $import_str = '<font color="#666">��󵼳����ڣ�'.$import_time.'</font>';
        }
        $addstr=<<<EOT
        <tr bgcolor='#FFFFFF'>
          <td colspan='2' height='30px' style='padding:20px'>
          <script type="text/javascript">
          function isgo(url,msg) {
              if(confirm(msg)) window.location.href=url;
              else return false;
          }
          </script>
          <input type="button" size="14" onclick="return isgo('?dopost=changyan_to_dedecms','�Ƿ񵼳����Ե�DedeCMS���ۣ�');" value="�������Ե�DedeCMS����"> 
           <span style="color:#999">������ģ���е����ݵ������ݵ�DedeCMS���ݿ���</span>  {$export_str}
          <br /><br />
          <input type="button" size="14" onclick="return isgo('?dopost=dedecms_to_changyan','�Ƿ���DedeCMS���۵����ԣ�');" value="����DedeCMS���۵�����">
           <span style="color:#999">��DedeCMS�������ݵ��뵽����ģ����</span> {$import_str}
          </td>
        </tr>
EOT;
    }
    $addstyle='scrolling="auto" ';
    $account_str = preg_match("#@dedecms$#",$_SESSION['user'])? "<a href='?dopost=bind' style='color:blue'>[���˺�]</a>" :
    "<a href='?dopost=logout' style='color:blue'>[�л��˺�]</a>";
    echo <<<EOT
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$cfg_soft_lang}">
<title>{$ptitle}</title>
<link rel="stylesheet" type="text/css" href="css/base.css">
</head>
<body background='images/allbg.gif' leftmargin="8" topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#DFF9AA" height="100%">
  <tr>
    <td height="28" style="border:1px solid #DADADA" background='images/wbg.gif'>
    
    <div style="float:left">&nbsp;<b>��<a href="?">��������ģ��</a> ��{$ptitle}</b></div>
    <div style="float:right;margin-right:20px;">���ã�{$_SESSION['user']} {$account_str}</div>
    </td>
  </tr>
  <tr>
    <td width="100%" height="100%" valign="top" bgcolor='#ffffff' style="padding-top:5px"><table width='100%'  border='0' cellpadding='3' cellspacing='1' bgcolor='#DADADA' height="100%">
        <tr bgcolor='#DADADA'>
          <td colspan='2' background='images/wbg.gif' height='26'><font color='#666600'><b>{$ptitle}</b></font></td>
        </tr>
        {$addstr}
        <tr bgcolor='#FFFFFF'>
          <td colspan='2' height='100%' style='padding:20px'><br/><iframe src="{$manage_url}" {$addstyle} width="100%" height="100%" style="border:none"></iframe></td>
        </tr>
        <tr>
          <td bgcolor='#F5F5F5'>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<p align="center"> <br>
  <br>
</p>
</body>
</html>

EOT;
} elseif ($dopost=='dedecms_to_changyan') {
    if(!changyan_islogin())
    {
        ShowMsg("����δ��¼���ԣ����ȵ�¼�����ʹ�á�����",'?');
        exit();
    }
    $isv_app_key = changyan_get_isv_app_key();
    $start = isset($start)? intval($start) : 0;
    $pagesize=1;
    $sql = "SELECT count(*) as dd FROM `#@__feedback` group by aid order by aid asc limit {$start},{$pagesize}";
    $rr = $dsql->GetOne($sql);
    if($rr['dd']==0)
    {
        changyan_set_setting('last_import', time());
        ShowMsg('ȫ��������ɣ�','javascript:;');
        exit;
    }
    $sql = "SELECT aid FROM `#@__feedback` group by aid order by aid asc limit {$start},{$pagesize}";
    $dsql->SetQuery($sql);
    $dsql->Execute('dd');
    $result=array();
    while($arr = $dsql->GetArray('dd'))
    {
        $feedArr=array();
        $arctRow = $dsql->GetOne("SELECT * FROM `#@__arctiny` WHERE id={$arr['aid']}");
        if($arctRow['channel']==0) $arctRow['channel']=1;
        $cid = $arctRow['channel'];
        $chRow = $dsql->GetOne("SELECT * FROM `#@__channeltype` WHERE id='$cid' ");
        $row=array();
        if ($chRow['issystem']!= -1) {
            $sql = "SELECT arc.*,tp.reid,tp.typedir,tp.typename,tp.isdefault,tp.defaultname,tp.namerule,tp.namerule2,tp.ispart,
            tp.moresite,tp.siteurl,tp.sitepath,ch.addtable
            FROM `#@__archives` arc
                     LEFT JOIN `#@__arctype` tp on tp.id=arc.typeid
                      LEFT JOIN `#@__channeltype` as ch on arc.channel = ch.id
                      WHERE arc.id='{$arr['aid']}' ";
            $row = $dsql->GetOne($sql);
        } else {
            if($chRow['addtable']!='')
            {
                $sql = "SELECT arc.*,tp.typedir,tp.typename,tp.isdefault,tp.defaultname,tp.namerule,tp.namerule2,tp.ispart,
            tp.moresite,tp.siteurl,tp.sitepath FROM `{$chRow['addtable']}` arc  
            LEFT JOIN `#@__arctype` tp ON arc.typeid=tp.id
                WHERE `aid` = '{$arr['aid']}'";
                $addTableRow = $dsql->GetOne($sql);
                if(is_array($addTableRow))
                {
                    $row['id']=$addTableRow['aid'];
                    $row['title']=$addTableRow['title'];
                    $row['typeid']=$addTableRow['typeid'];
                    $row['mid']=$addTableRow['mid'];
                    $row['senddate']=$addTableRow['senddate'];
                    $row['channel']=$addTableRow['channel'];
                    $row['arcrank']=$addTableRow['arcrank'];
                    $row['senddate']=$addTableRow['senddate'];
                    $row['typedir']=$addTableRow['typedir'];
                    $row['isdefault']=$addTableRow['isdefault'];
                    $row['defaultname']=$addTableRow['defaultname'];
                    $row['ispart']=$addTableRow['ispart'];
                    $row['namerule2']=$addTableRow['namerule2'];
                    $row['moresite']=$addTableRow['moresite'];
                    $row['siteurl']=$addTableRow['siteurl'];
                    $row['sitepath']=$addTableRow['sitepath'];
                }
            }
        }
        $row['filename'] = $row['arcurl'] = GetFileUrl($row['id'],$row['typeid'],$row['senddate'],$row['title'],1,
        0,$row['namerule'],$row['typedir'],0,'',$row['moresite'],$row['siteurl'],$row['sitepath']);
        $row['title']=changyan_autoCharset($row['title']);
        
        $feedArr['title']=$row['title'];
        $feedArr['url']=$cfg_basehost.$row['arcurl'];
        $feedArr['ttime']= date('Y-m-d h:m:s',  $row['senddate']);
        $feedArr['sourceid']=$arr['aid'];
        $feedArr['parentid']=0;
        $feedArr['categoryid']=$row['typeid'];
        $feedArr['ownerid']=$row['mid'];
        $feedArr['metadata']='';

        $dsql->SetQuery("SELECT feedback_id FROM `#@__plus_changyan_importids` WHERE aid={$arr['aid']}");
        $dsql->Execute('dd');
        $feedback_ids=array();
        while($farr = $dsql->GetArray('dd'))
        {
            $feedback_ids[] = $farr['feedback_id'];
        }
        
        $squery="SELECT * FROM `#@__feedback` WHERE aid={$arr['aid']} order by dtime asc;";
        $dsql->SetQuery($squery);
        $dsql->Execute('xx');
        while($fRow = $dsql->GetArray('xx'))
        {
            if (in_array($fRow['id'], $feedback_ids)) continue;
            $feedArr['comments'][]=array(
                'cmtid'=>$fRow['id'],
                'ctime'=>date('Y-m-d h:m:s',  $fRow['dtime']),
                'content'=>changyan_Quote_replace(changyan_autoCharset($fRow['msg'])),
                'replyid'=>0,
                'spcount'=>$fRow['good'],
                'opcount'=>$fRow['bad'],
                'user'=>array(
                    'userid'=>$fRow['mid'],
                    'nickname'=>changyan_autoCharset($fRow['username']),
                    'usericon'=>'',
                    'userurl'=>'',
                )
            );
            $inquery = "INSERT INTO `#@__plus_changyan_importids`(`aid`,`feedback_id`) VALUES ('{$arr['aid']}','{$fRow['id']}')";
            $rs = $dsql->ExecuteNoneQuery($inquery);
        }
        if (count($feedArr['comments'])<1) {
            continue;
        }

        $content=json_encode($feedArr);
        $md5 = changyan_hmacsha1($content, $isv_app_key);

        $paramsArr=array(
            'appid'=>$client_id, 
            'md5'=>$md5, 
            'jsondata'=>$content);
        $rs=changyan_http_send(CHANGYAN_API_IMPORT,0,$paramsArr);
    }
    
    $start =$start+$pagesize;
    $end =$start+$pagesize;
    ShowMsg("�ɹ������������ݣ�����������[{$start}-{$end}]����������","?dopost=dedecms_to_changyan&start={$start}");
    //echo json_encode($result);
    exit();
} elseif ($dopost=='changyan_to_dedecms') {
    if(!changyan_islogin())
    {
        ShowMsg("����δ��¼���ԣ����ȵ�¼�����ʹ�á�����",'?');
        exit();
    }
    $last_export=changyan_get_setting('last_export');
    if (empty($last_export)) {
        $start_date='2014-01-01 00:00:00';
    } else {
        $start_date= date('Y-m-d H:i:s',$last_export);
    }
    //$start_date='2014-01-01 00:00:00';
    $recent = changyan_get_recent($client_id, $start_date);
    //var_dump($recent);exit;
    if (count($recent['topics'])<=0) {
        ShowMsg("û�з����µ�����������Ҫ������",-1);
        exit();
    }
    $exports=array();
    foreach ($recent['topics'] as $topic) {
        $exports[]=array(
            'topic_id'=>$topic['topic_id'],
            'aid'=>$topic['topic_source_id'],
            'title'=>$topic['topic_title'],
        );
    }
    foreach ($exports as $export) {
        changyan_insert_comments(changyan_get_comments(changyan_get_setting('appid'),$export['topic_id']),$export['aid'],$export['title']);
    }
    changyan_set_setting('last_export', time());
    ShowMsg("�ɹ����ݳ������۵�DedeCMSϵͳ��","?dopost=import");
    exit();
} elseif ($dopost=='checkupdate')
{
    ShowMsg("<p>��ǰΪ���°汾���������ظ��£�</p> <p><a href='?' >������һҳ</a></p>","javascript:;");
    exit();
} elseif ($dopost=='clearcache')
{
    changyan_clearcache();
    ShowMsg("�ɹ���ձ�ǩ���棡","?");
    exit();
} elseif($dopost=='forget-pwd')
{
    ShowMsg("<p> ����������˳������� </p> <p><a href='http://www.kuaizhan.com/passport/forget-pwd?refer=http://changyan.kuaizhan.com/audit/comments/TOAUDIT/1' >��������һ�</a></p>","javascript:;");
    exit();
} else {
    /* ��¼�������� */

    if(changyan_islogin())
    {
        $changyan_ver = CHANGYAN_VER;
        $login_url=CHANGYAN_API_SETCOOKIE.'?client_id='.CHANGYAN_CLIENT_ID.'&token='.$_SESSION['changyan'];
        $login_str = <<<EOT
<iframe src="{$login_url}" scrolling="no" width="0" height="0" style="border:none"></iframe>
EOT;
        
        $isv_app_key = changyan_get_setting('isv_app_key');
        $isv_id = changyan_get_setting('isv_id');
        $isv_id = intval($isv_id);
        $changge_isv_url = CHANGYAN_API_CHANGE_ISV.$isv_id;
        //$isv_app_key = changyan_get_isv_app_key();
        $change_isv_id = <<<EOT
<div id="change_isv"></div>
<script type="text/javascript">
setTimeout(function(){var change_isv_div = document.getElementById("change_isv");change_isv_div.innerHTML='<iframe src="{$changge_isv_url}" scrolling="no" width="0" height="0" style="border:none"></iframe>';},100);
</script>
EOT;
        if(!empty($forward))
        {
            echo <<<EOT
            <div style="font-size: 12px;padding: 20px;border: 1px solid #DDD;">����ģ���Զ���¼�У������ĵȴ�����</div>
{$login_str}
{$change_isv_id}
<script type="text/javascript">
setTimeout(function(){window.location.href='?dopost={$forward}';},500);
</script>
EOT;
            exit();
        }
        $account_str = preg_match("#@dedecms$#",$_SESSION['user'])? "<a href='?dopost=bind' style='color:blue'>[���˺�]</a> <font color='red'>Ϊ�˱�֤�������۰�ȫ��������˺�</font>" :
        "<a href='?dopost=logout' style='color:blue'>[�л��˺�]</a>";
        $msg = <<<EOT
<table width="98%" border="0" cellspacing="1" cellpadding="1">
  <tbody>
    <tr>
      <td width="16%" height="30">��¼�û���</td>
      <td width="84%" style="text-align:left;">{$_SESSION['user']} {$account_str} <!--<a href='?dopost=logout' style='color:blue'>[�˳�]</a>--></td>
    </tr>
    <tr>
      <td width="16%" height="30">����ģ��汾��</td>
      <td width="84%" style="text-align:left;">v{$changyan_ver} <a href='?dopost=checkupdate' style='color:blue'>[������]</a> </td>
    </tr>
    <tr>
      <td width="16%" height="30">App ID��</td>
      <td width="84%" style="text-align:left;"><input class="input-xlarge" type="text" value="{$appid}" disabled="disabled/" style="width:260px"> <a href='?dopost=change_appinfo' style='color:blue'>[�޸�]</a> <span style="color:#999">&nbsp;APP ID�����л���ͬ��վ��</span></td>
    </tr>
    <tr>
      <td width="16%" height="30">APP Key��</td>
      <td width="84%" style="text-align:left;"><input class="input-xlarge" type="text" value="{$isv_app_key}" disabled="disabled/" style="width:260px">  </td>
    </tr>
    <tr>
      <td height="30" colspan="2">���ѳɹ���¼���ԣ������Խ������²�����</td>
    </tr>
    <tr>
      <td height="30" colspan="2">
      <a href='?dopost=manage' style='color:blue'>[���۹���]</a> 
      <a href='?dopost=stat' style='color:blue'>[����ͳ��]</a> 
      <a href='?dopost=import' style='color:blue'>[���뵼��]</a> 
      <a href='?dopost=clearcache' style='color:blue'>[��ջ���]</a> 
      <a href='?dopost=setting' style='color:blue'>[��������]</a> 
      </td>
    </tr>
<tr>
      <td height="30" colspan="2">
   <hr>
   ʹ��˵����<br>
   �ڶ�Ӧģ����ʹ�ñ�ǩ��<font color="red">{dede:changyan/}</font>��ֱ�ӽ��е��ü��ɣ���ʽ�趨�ɵ��<a href='?dopost=setting' style='color:blue'>[��������]</a> �������á�
  <hr>
  ����˵����<br>
  <b>[���۹���]</b>��ˡ�ɾ��������Ϣ�����дʹ����û����Բ�����<br>
 <b>[����ͳ��]</b>վ��������Ϣ����ȫ��λͳ�ƣ�<br>
 <b>[���뵼��]</b>������Ϣ���ݵ���/�����������û����ڵ������ݣ�<br>
 <b>[��ջ���]</b>��ճ������۱�ǩ���棬������ĵ�¼�˺Ž�����ջ��������ɣ�<br>
 <b>[��������]</b>������������趨��<br><br>
<hr>
    </tr>
    <tr>
      <td height="30" colspan="2" style="color:#999"><strong>����</strong>��һ�����Ѻõ���ữ���ۼ��ۺ�ϵͳ����������ϵͳ���Ա�֤����վ�����۰�ȫ����������վԶ���������ۣ��û�����ʹ���Լ����罻�˻���������վ�������ۣ�����һ��ͬ�����罻���磬Ϊ������վ��������������</td>
    </tr>
  </tbody>
</table>
{$login_str}
{$change_isv_id}
EOT;
        $wintitle = '�������۹���';
        $wecome_info = '��������ģ�� ��';
        $win = new OxWindow();
        $win->AddTitle($wintitle);
        $win->AddMsgItem($msg);
        $winform = $win->GetWindow('hand', '&nbsp;', false);
        $win->Display();
        exit;
    } else {
        unset($_SESSION['changyan']);
        unset($_SESSION['user']);
        $user = changyan_get_setting('user');
        $version = CHANGYAN_VER;
        $changyan_reg_url = CHANGYAN_REG_URL;
        $changyan_forget_pwd_url = CHANGYAN_FORGET_PWD_URL;
        $changyan_update_url = CHANGYAN_UPDATE_URL;
        if(empty($user)) $user='';
        $msg = <<<EOT
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$cfg_soft_lang}">
<title>�������۹���</title>
<link rel="stylesheet" type="text/css" href="{$cfg_plus_dir}/img/base.css">
</head>
<body background='{$cfg_plus_dir}/img/allbg.gif' leftmargin="8" topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#DFF9AA">
  <tr>
    <td height="28" style="border:1px solid #DADADA" background='{$cfg_plus_dir}/img/wbg.gif'>&nbsp;<b>��������ģ�� ��</b></td>
  </tr>
  <tr>

  <td width="100%" height="80" style="padding-top:5px" bgcolor='#ffffff'>

  <script language='javascript'>
function CheckSubmit(){
    return true;
}
</script>
  <form name='myform' method='POST' onSubmit='return CheckSubmit();' action='?'>

  <input type='hidden' name='dopost' value='login'>
  <table width='100%'  border='0' cellpadding='3' cellspacing='1' bgcolor='#DADADA'>
    <tr bgcolor='#DADADA'>
      <td colspan='2' background='{$cfg_plus_dir}/img/wbg.gif' height='26'><font color='#666600'><b>�������۹���</b></font></td>
    </tr>
    <tr bgcolor='#FFFFFF'>
      <td colspan='2'  height='100'><table width="98%" border="0" cellspacing="1" cellpadding="1">
          <tbody>
            <tr>
              <td width="16%" height="30">���䣺</td>
              <td width="84%" style="text-align:left;"><input name="user" type="text" id="user" size="16" style="width:200px" value="{$user}" />
                <a href="$changyan_reg_url" style="color:blue">���ע��</a> ����ȡרҵ�����۷���</td>
            </tr>
            <tr>
              <td height="30">���룺</td>
              <td style="text-align:left;"><input name="pwd" type="password" id="pwd" size="16" style="width:200px">
               <a href="$changyan_forget_pwd_url" style="color:blue">��������</a> &nbsp; </td>
            </tr>
            <tr>
              <td height="30">����汾��</td>
              <td style="text-align:left;"><input name="ver" type="text" id="ver" size="16" style="width:200px" value="{$version}" readonly />
               <a href="$changyan_update_url" style="color:blue">�����°���</a> &nbsp; </td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    <tr>
      <td colspan='2' bgcolor='#F9FCEF'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
          <tr align='center' height='28'>
            <td width='16%'></td>
            <td width='84%' style="text-align: left;"><input name='imageField1' type='image' class='np' src='{$cfg_plus_dir}/img/button_ok.gif' width='60' height='22' border='0' /></td>
            <td></td>
          </tr>
        </table></td>
    </tr>
  </table>
  </td>
  </tr>
</table>
</body>
</html>
EOT;
        echo $msg;
    }
}
?>
