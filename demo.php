<?php
require_once("SensorsAnalytics.php");
date_default_timezone_set("Asia/Shanghai");

class demo{
    // 使用 CURL 批量发送数据的 Consumer，当且仅当数据达到指定的量时，才将数据进行发送。
    public function batchConsumer(){
        # 从神策分析配置页面中获取的数据接收的 URL
        $sa_server_url = 'http://sd.sndo.com/p?project=zjxabyor';
        # 初始化一个 Consumer，用于数据发送
        $consumer = new BatchConsumer($sa_server_url);
        # 使用 Consumer 来构造 SensorsAnalytics 对象
        $sa =  new SensorsAnalytics($consumer,'zjxabyor');
        $sa->track('1234', true, 'Test', array('From' => 'Baidu'));
        $sa->track_signup('1234', 'abcd', array('Channel' => 'Hongbao'));
        $sa->profile_delete('1234', true);
        $sa->profile_append('1234', true, array('Gender' => 'Male'));
        $sa->profile_increment('1234', true, array('CardNum' => 1));
        $sa->profile_set('1234', true, array('City' => '北京'));
        $sa->profile_unset('1234', true, array('City'));
        $sa->flush();
        for ($i = 0; $i < 49; $i++) {
            $sa->profile_set('1234', true, array('City' => '北京'));
        }
        $sa->profile_set('1234', true, array('City' => '北京'));
        $sa->close();
    }


    // FileConsumer: 将待发送的数据写入指定的本地文件，后续可以使用 LogAgent 或者 BatchImporter 来进行导入。
    public function FileConsumer(){
        # 初始化一个 Consumer，用于数据发送
        $consumer = new FileConsumer("sa.log." . date('Y-m-d'));
        # 使用 Consumer 来构造 SensorsAnalytics 对象
        $sa = new SensorsAnalytics($consumer);
        $sa->track('1234', true, 'Test', array('From' => 'Baidu'));
        $sa->track_signup('1234', 'abcd', array('Channel' => 'Hongbao'));
        $sa->profile_delete('1234', true);
        $sa->profile_append('1234', true, array('Gender' => 'Male'));
        $sa->profile_increment('1234', true, array('CardNum' => 1));
        $sa->profile_set('1234', true, array('City' => '北京'));
        $sa->profile_unset('1234', true, array('City'));
        $sa->profile_unset('1234', true, array('Province' => true));
        # 程序结束前调用 close() ，通知 Consumer 发送所有缓存数据
        $sa->close();
    }
}

$demo = new demo();
$demo->FileConsumer();










