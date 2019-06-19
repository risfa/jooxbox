<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GenerateImage extends CI_Controller {
    public function __construct(){
        parent::__construct();
    }
    public function index()
    {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        $text=$this->input->post('text');
        $lineList=array();
//        $temp0=explode(PHP_EOL,$text);
//        $temp1= explode(' ',$temp0[1]);
//        $this->db->order_by('playlist_id','desc');
//        $this->db->where('createby',$temp1[1]);
//        $this->db->limit(1,0);
//        $song=$this->db->get('tbl_playlist');
//        if($song->num_rows()>0) {
//            $row=$song->row();
//            $text.=' \n http://jukebox5d.com \n ';
//            $text .= $row->link;
//        }else{
//            $text.='\n http://jukebox5d.com';
//        }
        $int=0;
        $lineListTemp=explode('\n',$text);
        foreach ($lineListTemp as $t){
            $lineList[]=$t;
            $int++;
        }
        $starting=520;
        $int=substr_count( $text, '\n' );;
        if($int>1){
            $starting=$starting-(($int-1)*30);
        }
        $imagesList=scandir('./assets/templates/',1);
        $randomIndex=rand(0,count($imagesList)-3);
        $image = new Imagick(realpath('./assets/templates/'.$imagesList[$randomIndex]));
        $caption=false;
        foreach ($lineList as $l){
            if(!$caption){
                $draw = new ImagickDraw();
                $draw->setFillColor('white');
                $draw->setFont('./assets/GOTHAM-MEDIUM.TTF');
                $draw->setFontSize(36);
                $draw->setTextAlignment(Imagick::ALIGN_CENTER);
                $image->annotateImage($draw, 540, $starting, 0, $l);
                $starting+=70;
                $caption=true;
            }else{
                $draw = new ImagickDraw();
                $draw->setFillColor('white');
                $draw->setFont('./assets/GOTHAM-MEDIUM.TTF');
                $draw->setFontSize(36);
                $draw->setTextAlignment(Imagick::ALIGN_CENTER);
                $image->annotateImage($draw, 540, $starting, 0, $l);
                $starting+=70;
            }

        }
        $image->setImageFormat('png');
        if(isset($text)) {
            $filename = './assets/screenshots/' . uniqid() . '.png';
            file_put_contents($filename, $image);
            $im = file_get_contents($filename);
            $imdata = base64_encode($im);
            echo 'data:image/png;base64,' . $imdata;
            unlink($filename);
        }
    }
}