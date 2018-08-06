<?php
/**
 * Created by PhpStorm.
 * User: Crxzy
 * Date: 2018/8/5
 * Time: 23:08
 */

class VideoMsgModel extends Model
{
    public function get($cid)
    {
        return $this->query("select * from `video_msg` where `cid`=:cid", array('cid' => $cid))[0];
    }

    public function getGroupMember($cid)
    {
        return $this->query("SELECT * from `video_msg` where group_id=(select group_id FROM civii.video_msg where cid=:cid)", array('cid' => $cid));
    }

    public function getGroup($cid)
    {
        return $this->query("SELECT * FROM `video_group` where group_id = (select `group_id` from `video_msg` where `cid`=:cid) ", array('cid' => $cid))[0];
    }
}