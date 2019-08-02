<?php
namespace app\read\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $pic = array(
            'ar.litpic' => array('neq', ''),
        );
        //status为1才是正常的商品
        $read = M('dede_addonarticle')
        ->alias('ad')
        ->join('dede_archives ar','ad.aid=ar.id')
        ->field('ar.litpic,ar.id,ar.title,ar.writer,ar.description,ar.pubdate,ar.keywords,ad.aid,ad.typeid,ad.body')
        ->where($pic)
        ->limit(10)
        ->select();

        $this->assign('read', $read);

        return $this->fetch();
    }


    public function post()
    {
        
        return $this->fetch();
    }
}