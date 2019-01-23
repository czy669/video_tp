<?php
namespace app\admin\command;

use think\console\Command;

use think\console\Input;

use think\console\Output;
use think\Exception;

use app\admin\model\Videos as ModelV;

class Fixvideo extends Command{

    private $basepath = '/home/wwwroot/fvideo/public';
    protected function configure(){
        $this->setName('fixvideo')
            ->setDescription('hello word !');
    }


    public function execute(Input $input, Output $output){
        set_time_limit(0);
        $m_video = new ModelV();
        $video = $m_video->where(['status'=> 1, 'updatetime' => 0])->limit(100)->order('id', 'desc')->select();
        if($video){
            foreach($video as $v){
                $file = $this->basepath . $v->videopath;
                $name = $file. '.jpg';
                $data = $this->getVideoInfo($file);
                $time = intval($data['seconds']/2);
                $re = $this->getVideoPic($file, $time, $name);

                if(file_exists($name)){
                    $update = [];
                    $update['id'] = $v->id;
                    $update['cover'] = $v->videopath. '.jpg';
                    $update['play_time'] = intval($data['seconds']);
                    $update['updatetime'] = time();
                    if($m_video->update($update)){
                        $output->writeln($v->id . ':' . $v->videopath . '   ::down!') ;
                    }
                }
            }

        }
    }

    public function getVideoPic($file, $time, $name){
        if(empty($time)) $time = '1';//默认截取第一秒第一帧
        $str = "ffmpeg -i ".$file." -y -f mjpeg -ss 3 -t ".$time." -s 255x150 ".$name;
        echo $str."</br>";
        return $result = system($str, $retval);
    }

    public function getVideoInfo($file){

        $command = sprintf('ffmpeg -i "%s" 2>&1', $file);

        ob_start();
        passthru($command);
        $info = ob_get_contents();
        ob_end_clean();

        $data = array();
        if (preg_match("/Duration: (.*?), start: (.*?), bitrate: (\d*) kb\/s/", $info, $match)) {
            $data['duration'] = $match[1]; //播放时间
            $arr_duration = explode(':', $match[1]);
            $data['seconds'] = $arr_duration[0] * 3600 + $arr_duration[1] * 60 + $arr_duration[2]; //转换播放时间为秒数
        }
        $data['size'] = filesize($file); //文件大小
        return $data;
    }

}

?>