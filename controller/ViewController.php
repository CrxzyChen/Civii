<?php
/**
 * Created by PhpStorm.
 * User: Crxzy
 * Date: 2018/7/26
 * Time: 21:43
 */

class ViewController extends ControllerBase
{
    public function index()
    {
        $this->layout('level1')->render('index',array("name"=>'ok'));
    }

    public function player(){
        $this->layout('level2')->render('video',array("name"=>'ok'));
    }
}