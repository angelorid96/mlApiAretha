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
        $query = sprintf(
            "INSERT INTO api_tokens(user_id,nickname,site_user,access_token,refresh_token,date_token,date_refresh_token) VALUES (%d,'%s','%s','%s','%s','%s','%s') returning user_id;",
            $da->escape_string($this->poApiToken->getUser_id()),
            $da->escape_string($this->poApiToken->getNickname()),
            $da->escape_string($this->poApiToken->getSite_userId()),
            $da->escape_string($this->poApiToken->getAcces_token()),
            $da->escape_string($this->poApiToken->getRefresh_token()),
            $da->escape_string($this->poApiToken->getDateAcces_token()),
            $da->escape_string($this->poApiToken->getDateRefresh_token())
        );
        // echo $query;
        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            if ($result != false) {
                return $result[0][0];
            }
            return 0;
        } else {
            return 0;
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
            }
            return $arrResult;
        } else {
            return false;
        }
    }
    public function existId() {
		$da = new \aretha\dao\DataAccess();
		$query = sprintf("SELECT COUNT(user_id) FROM api_tokens WHERE user_id = %d;", 
						$da->escape_string($this->poApiToken->getUser_id())
                    );
		if ($da->connect()) {
			$result = $da->execGetQuery($query);
			$da->disconnect();
			if ($result != false) {
				if ($result[0][0] > 0) {
					return true;
				}
			}
			return false;
		} else {
			return false;
		}
	}
    public function existName() {
		$da = new \aretha\dao\DataAccess();
		$query = sprintf("SELECT COUNT(nickname) FROM api_tokens WHERE lower(nickname) = lower('%s');", 
						$da->escape_string($this->poApiToken->getNickname())
                    );
		if ($da->connect()) {
			$result = $da->execGetQuery($query);
			$da->disconnect();
			if ($result != false) {
				if ($result[0][0] > 0) {
					return true;
				}
			}
			return false;
		} else {
			return false;
		}
	}
    public function update() {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf("UPDATE api_tokens SET access_token='%s',refresh_token='%s',date_token='%s',date_refresh_token='%s' WHERE nickname = '%s'",
            $da->escape_string($this->poApiToken->getAcces_token()),
            $da->escape_string($this->poApiToken->getRefresh_token()),    
            $da->escape_string($this->poApiToken->getDateAcces_token()),  
            $da->escape_string($this->poApiToken->getDateRefresh_token()), 
            $da->escape_string($this->poApiToken->getNickname())
        );
        if($da->connect()){
            $result = $da->execSetQuery($query);
            $da->disconnect();
            return $result;
        }else{
            return false;
        }
    }
}
