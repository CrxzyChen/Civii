<?php
/**
 * Created by PhpStorm.
 * User: Crxzy
 * Date: 2018/7/26
 * Time: 21:44
 */

class ApiController
{
    public function get(){
        $vmm = new VideoMsgModel();
        $cid = $_GET['args'][0];
        $data['current_video'] = $vmm->get($cid);
        $data['group_member'] = $vmm->getGroupMember($cid);
        $data['group'] = $vmm->getGroup($cid);
        $this->_json($data);
    }
    private function _json($data){
        header('Content-type:text/json');
        echo json_encode($data);
    }
}