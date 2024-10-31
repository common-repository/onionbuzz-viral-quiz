<?php
namespace OBVQ_WpPluginAutoload\Core;

class OBVQ_User{

    private $current_user;

    public function __construct()
    {
        $this->current_user = wp_get_current_user();

        return 1;
    }
    public function userLogin(){
        return $this->current_user->user_login;
    }
    public function userEmail(){
        return $this->current_user->user_email;
    }
    public function userFirstname(){
        return $this->current_user->user_firstname;
    }
    public function userLastname(){
        return $this->current_user->user_lastname;
    }
    public function userName(){
        return $this->current_user->display_name;
    }
    public function userID(){
        return $this->current_user->ID;
    }
    public function userInfo(){
        return $this->current_user;
    }
}