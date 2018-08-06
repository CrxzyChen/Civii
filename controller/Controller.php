<?php
/**
 * Created by PhpStorm.
 * User: Crxzy
 * Date: 2018/7/26
 * Time: 22:46
 */

class Controller
{
    public $view = '';
    public $is_layout = False;
    private $_layout = '';
    private $_view = '';

    public function layout($layout)
    {
        $this->_layout = file_get_contents(LAYOUT_PATH . $layout . '.html');
        $this->is_layout = True;
        return $this;
    }

    public function render($temp = '', $data = [])
    {
        if ($temp == '') {//获取渲染模板
            $backtrace = debug_backtrace();
            $view = file_get_contents(VIEW_PATH . $backtrace[1]['function'] . '.html');
        } else {
            $view = file_get_contents(VIEW_PATH . $temp . '.html');
        }

        if ($this->is_layout) {//渲染布局样式
            $this->_view = $this->_layout;
            $this->_view = str_replace('__CONTENT__', $view, $this->_view);//渲染模板
            while (preg_match_all('/\$\{([\s\S]+?)\}/i', $this->_view, $match)) {
                $components = [];
                foreach ($match[1] as $value) {
                    $components[] = file_get_contents(COMPONENT_PATH . $value . '.html');
                }
                foreach ($match[0] as $key => $value) {
                    $this->_view = str_replace($value, $components[$key], $this->_view);
                }
            }
        } else {
            $this->_view = $view;
        }


        if (preg_match_all('/\{__([\s\S]+?)__\}/i', $this->_layout, $match)) {//渲染常量
            $constants = [];
            foreach ($match[1] as $value) {
                $constants[] = constant($value);
            }
            foreach ($match[0] as $key => $value) {
                $this->_view = str_replace($value, $constants[$key], $this->_view);
            }
        }

        if ($data != []) {
            foreach ($data as $key => $value) {
                $this->_view = preg_replace("/\{[\s]*\\\${$key}[\s]*\}/i", $value, $this->_view);
            }
        }
        print($this->_view);
    }
}