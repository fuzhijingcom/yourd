<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){

 $pic = array(
           'ar.litpic' => array('neq','') ,
        );
        //status为1才是正常的商品
       $read = M()->table(array('dede_addonarticle'=>'ad','dede_archives'=>'ar'))->field('ar.litpic,ar.id,ar.title,ar.writer,ar.description,ar.pubdate,ar.keywords,ad.aid,ad.typeid,ad.body')->where('ad.aid=ar.id')->where($pic)->select();
        
     
   
    $this->assign('read', $read);



   $this->display();
}
    public function post(){
        //dump($_COOKIE);
       // echo '<script language="javascript">window.location= "http://www.yudw.com/yykddn";</script>';
    $this->display();
  // $this->redirect('http://www.yudw.com/yykddn', array('cate_id' => 2), 1, '页面跳转中...');
    }
}