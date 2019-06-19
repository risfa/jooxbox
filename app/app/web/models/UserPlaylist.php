<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserPlaylist extends CI_Model {
    public function addPlaylist($name,$user_id){
        $data=array(
            'playlist_name'=>$name,
            'user_id'=>$user_id,
        );
        $insert=$this->db->insert('tbl_user_playlist',$data);
        if($insert){
            return true;
        }else{
            return false;
        }
    }
    public function deletePlaylist($playlist_id){
        $this->db->where('playlist_id',$playlist_id);
        $delete=$this->db->delete('tbl_user_playlist');
        if($delete){
            return true;
        }else{
            return false;
        }
    }
    public function updatePlaylist($data,$playlist_id){
        $this->db->where('playlist_id',$playlist_id);
        $update=$this->db->update('tbl_user_playlist',$data);
        if($update){
            return true;
        }else{
            return false;
        }
    }
    public function addPlaylistItem($data){
        $insert=$this->db->insert('tbl_user_playlist_item',$data);
        if($insert){
            return true;
        }else{
            return false;
        }
    }
    public function deletePlaylistItem($link,$playlist_id){
        $this->db->where('playlist_id',$playlist_id);
        $this->db->where('link',$link);
        $delete=$this->db->delete('tbl_user_playlist_item');
        if($delete){
            return true;
        }else{
            return false;
        }
    }
    public function getPlaylist($user_id){
        $this->db->where('user_id',$user_id);
        $userDataPlaylist=$this->db->get('tbl_user_playlist');
        if($userDataPlaylist->num_rows()>0){
            return $userDataPlaylist->result();
        }else{
            return false;
        }
    }
    public function getPlaylistItem($playlist_id){
        $this->db->where('playlist_id',$playlist_id);
        $userDataPlaylistItem=$this->db->get('tbl_user_playlist_item');
        if($userDataPlaylistItem->num_rows()>0){
            return $userDataPlaylistItem->result();
        }else{
            return false;
        }
    }
}
