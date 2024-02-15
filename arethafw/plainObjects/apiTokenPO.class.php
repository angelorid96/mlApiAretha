<?php
namespace mod_apitoken\plainObjects;

class apiTokenPO{

    private $user_id;
    private $nickname;
    private $site_user;
    private $acces_token;
    private $refresh_token;
    private $date_acces_token;
    private $date_refresh_token;
    private $queryDinam = "";

    public function getUser_id(){
        return $this->user_id;
    }
    public function getNickname(){
        return $this->nickname;
    }
    public function getSite_userId(){
        return $this->site_user;
    }
    public function getAcces_token(){
        return $this->acces_token;
    }
    public function getRefresh_token(){
        return $this->refresh_token;
    }
    public function getDateAcces_token(){
        return $this->date_acces_token;
    }
    public function getDateRefresh_token(){
        return $this->date_refresh_token;
    }
    public function getQuery_dinam(){
        return $this->queryDinam;
    }
    
    public function setUser_id($user_id){
        $this->user_id=$user_id;
    }
    public function setNickname($nickname){
        $this->nickname=$nickname;
    }
    public function setSite_userID($site_user){
        $this->site_user=$site_user;
    }
    public function setAcces_token($acToken){
        $this->acces_token=$acToken;
    }
    public function setRefresh_token($reToken){
        $this->refresh_token=$reToken;
    }
    public function setDateAcces_token($daAcToken){
        $this->date_acces_token=$daAcToken;
    }
    public function setDateRefresh_token($daReToken){
        $this->date_refresh_token=$daReToken;
    }
    public function setQuery_diam($queryDinam){
        $this->queryDinam=$queryDinam;
    }

}

?>