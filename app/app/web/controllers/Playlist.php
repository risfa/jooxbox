<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlist extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model("UserPlaylist");
    }
    public function index() {

    }
    public function add(){
        $status=array();
        $name=$this->input->post('name');
        $user_id=$this->session->userdata('user_id');
        $addPlaylist=$this->UserPlaylist->addPlaylist($name,$user_id);
        if($addPlaylist){
            $status['status']=true;
            $status['message']="playlist added";
        }else{
            $status['status']=false;
            $status['message']="playlist not added";
        }
        echo json_encode($status);
    }
    public function getPlaylistUser(){
        $id=$this->session->userdata('user_id');
        $getPlaylist=$this->UserPlaylist->getPlaylist($id);
        if($getPlaylist){
            $status['status']=true;
            $status['data']=$getPlaylist;
        }else{
            $status['status']=false;
            $status['message']="no playlist found";
        }
        echo json_encode($status);
    }

    public function delete(){
        $status=array();
        $id=$this->input->post('playlist_id');
        $del=$this->UserPlaylist->deletePlaylist($id);
        if($del){
            $status['status']=true;
            $status['message']="playlist deleted";
        }else{
            $status['status']=false;
            $status['message']="playlist not deleted";
        }
        echo json_encode($status);
    }
    public function update(){
        $status=array();
        $id=$this->input->post('playlist_id');
        $data=array(
            'playlist_name'=>$this->input->post('name')
        );
        $up=$this->UserPlaylist->updatePlaylist($data,$id);
        if($up){
            $status['status']=true;
            $status['message']="playlist updated";
        }else{
            $status['status']=false;
            $status['message']="playlist not updated";
        }
        echo json_encode($status);
    }
    public function addItem(){
        $status=array();
        $data=array(
          'track_id'=>$this->input->post('track_id'),
          'link'=>$this->input->post('link'),
          'title'=>$this->input->post('title'),
          'playlist_id'=>$this->input->post('playlist_id')
        );
        $addPlaylistItem=$this->UserPlaylist->addPlaylistItem($data);
        if($addPlaylistItem){
            $status['status']=true;
            $status['message']="playlist item added";
        }else{
            $status['status']=false;
            $status['message']="playlist item not added";
        }
        echo json_encode($status);
    }
    public function deleteItem(){
        $status=array();
        $playlist_id=$this->input->post('playlist_id');
        $link=$this->input->post('link');
        $deletePlaylistItem=$this->UserPlaylist->deletePlaylistItem($link,$playlist_id);
        if($deletePlaylistItem){
            $status['status']=true;
            $status['message']="playlist item deleted";
        }else{
            $status['status']=false;
            $status['message']="playlist item not deleted";
        }
        echo json_encode($status);
    }
    public function getPlaylistUserItem($id){
        $getPlaylistItem=$this->UserPlaylist->getPlaylistItem($id);
        if($getPlaylistItem){
            $status['status']=true;
            $status['data']=$getPlaylistItem;
        }else{
            $status['status']=false;
            $status['message']="no playlist item found";
        }
        echo json_encode($status);
    }
}