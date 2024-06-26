<?php

namespace mod_apitoken\entities;

class apiToken
{

    private $poApiToken = null;

    public function __construct()
    {
        $this->poApiToken = new \mod_apitoken\plainObjects\apiTokenPO();
    }
    public function getPO()
    {
        return $this->poApiToken;
    }

    public function insert()
    {
        $da = new \aretha\dao\DataAccess();
        $query='';
        switch ($da->getEngine()) {
            case 1:
                $query = sprintf(
                    "INSERT INTO api_tokens(user_id,nickname,site_user,access_token,refresh_token,date_token,date_refresh_token) VALUES (%d,'%s','%s','%s','%s','%s','%s') RETURNING user_id;",
                    $da->escape_string($this->poApiToken->getUser_id()),
                    $da->escape_string($this->poApiToken->getNickname()),
                    $da->escape_string($this->poApiToken->getSite_userId()),
                    $da->escape_string($this->poApiToken->getAcces_token()),
                    $da->escape_string($this->poApiToken->getRefresh_token()),
                    $da->escape_string($this->poApiToken->getDateAcces_token()),
                    $da->escape_string($this->poApiToken->getDateRefresh_token())
                );
                break;
            case 2:
                $query = sprintf(
                    "INSERT INTO api_tokens(user_id,nickname,site_user,access_token,refresh_token,date_token,date_refresh_token) VALUES (%d,'%s','%s','%s','%s','%s','%s');",
                    $da->escape_string($this->poApiToken->getUser_id()),
                    $da->escape_string($this->poApiToken->getNickname()),
                    $da->escape_string($this->poApiToken->getSite_userId()),
                    $da->escape_string($this->poApiToken->getAcces_token()),
                    $da->escape_string($this->poApiToken->getRefresh_token()),
                    $da->escape_string($this->poApiToken->getDateAcces_token()),
                    $da->escape_string($this->poApiToken->getDateRefresh_token())
                );
                break;
        }
        
        // echo $query;
        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            // var_dump($result);
            $da->disconnect();
            if ($result != false) {
                switch ($da->getEngine()) {
                    case 1:
                        return $result[0][0];
                        break;
                    case 2:
                        return $result;
                        break;
                }
            }
            return 0;
        } else {
            return 0;
        }
    }
    public function selectByUserID()
    {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf(
            "SELECT user_id,nickname,site_user,access_token,refresh_token,date_token,date_refresh_token FROM api_tokens WHERE user_id = %d;",
            $da->escape_string($this->poApiToken->getUser_id())
        );

        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            $arrResult = array();
            if ($result != false) {
                switch ($da->getEngine()) {
                    case 1:
                        foreach ($result as $row) {
                            $oBusinessPO = new \mod_apitoken\plainObjects\apiTokenPO();
                            $oBusinessPO->setUser_id($row[0]);
                            $oBusinessPO->setNickname($row[1]);
                            $oBusinessPO->setSite_userID($row[2]);
                            $oBusinessPO->setAcces_token($row[3]);
                            $oBusinessPO->setRefresh_token($row[4]);
                            $oBusinessPO->setDateAcces_token($row[5]);
                            $oBusinessPO->setDateRefresh_token($row[6]);
                            $arrResult[] = $oBusinessPO;
                        }
                        break;
                    case 2:
                        foreach ($result as $row) {
                            $oBusinessPO = new \mod_apitoken\plainObjects\apiTokenPO();
                            $oBusinessPO->setUser_id($row->user_id);
                            $oBusinessPO->setNickname($row->nickname);
                            $oBusinessPO->setSite_userID($row->site_user);
                            $oBusinessPO->setAcces_token($row->access_token);
                            $oBusinessPO->setRefresh_token($row->refresh_token);
                            $oBusinessPO->setDateAcces_token($row->date_token);
                            $oBusinessPO->setDateRefresh_token($row->date_refresh_token);
                            $arrResult[] = $oBusinessPO;
                        }
                        break;
                }
            }
            return $arrResult;
        } else {
            return false;
        }
    }
    public function selectByNickname()
    {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf(
            "SELECT user_id,nickname,site_user,access_token,refresh_token,date_token,date_refresh_token FROM api_tokens WHERE nickname = '%s';",
            $da->escape_string($this->poApiToken->getNickname())
        );

        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            $arrResult = array();
            if ($result != false) {
                switch ($da->getEngine()) {
                    case 1:
                        foreach ($result as $row) {
                            $oBusinessPO = new \mod_apitoken\plainObjects\apiTokenPO();
                            $oBusinessPO->setUser_id($row[0]);
                            $oBusinessPO->setNickname($row[1]);
                            $oBusinessPO->setSite_userID($row[2]);
                            $oBusinessPO->setAcces_token($row[3]);
                            $oBusinessPO->setRefresh_token($row[4]);
                            $oBusinessPO->setDateAcces_token($row[5]);
                            $oBusinessPO->setDateRefresh_token($row[6]);
                            $arrResult[] = $oBusinessPO;
                        }
                        break;
                    case 2:
                        foreach ($result as $row) {
                            $oBusinessPO = new \mod_apitoken\plainObjects\apiTokenPO();
                            $oBusinessPO->setUser_id($row->user_id);
                            $oBusinessPO->setNickname($row->nickname);
                            $oBusinessPO->setSite_userID($row->site_user);
                            $oBusinessPO->setAcces_token($row->access_token);
                            $oBusinessPO->setRefresh_token($row->refresh_token);
                            $oBusinessPO->setDateAcces_token($row->date_token);
                            $oBusinessPO->setDateRefresh_token($row->date_refresh_token);
                            $arrResult[] = $oBusinessPO;
                        }
                        break;
                }
            }
            return $arrResult;
        } else {
            return false;
        }
    }
    public function existId()
    {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf(
            "SELECT COUNT(user_id) FROM api_tokens WHERE user_id = %d;",
            $da->escape_string($this->poApiToken->getUser_id())
        );
        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            if ($result != false) {
                switch ($da->getEngine()) {
                    case 1:
                        if ($result[0][0] > 0) {
                            return true;
                        }
                        break;
                    case 2:
                        if ($result[0]->{"COUNT(user_id)"} > 0) {
                            return true;
                        }
                        break;
                }
            }
            return false;
        } else {
            return false;
        }
    }
    public function existName()
    {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf(
            "SELECT COUNT(nickname) FROM api_tokens WHERE lower(nickname) = lower('%s');",
            $da->escape_string($this->poApiToken->getNickname())
        );
        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            if ($result != false) {
                switch ($da->getEngine()) {
                    case 1:
                        if ($result[0][0] > 0) {
                            return true;
                        }
                        break;
                    case 2:
                        if ($result[0]->{"COUNT(user_id)"} > 0) {
                            return true;
                        }
                        break;
                }
            }
            return false;
        } else {
            return false;
        }
    }
    public function update()
    {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf(
            "UPDATE api_tokens SET nickname='%s',access_token='%s',refresh_token='%s',date_token='%s',date_refresh_token='%s' WHERE  user_id = %d",
            $da->escape_string($this->poApiToken->getNickname()),
            $da->escape_string($this->poApiToken->getAcces_token()),
            $da->escape_string($this->poApiToken->getRefresh_token()),
            $da->escape_string($this->poApiToken->getDateAcces_token()),
            $da->escape_string($this->poApiToken->getDateRefresh_token()),
            $da->escape_string($this->poApiToken->getUser_id())
        );
        if ($da->connect()) {
            $result = $da->execSetQuery($query);
            $da->disconnect();
            return $result;
        } else {
            return false;
        }
    }
}

?>