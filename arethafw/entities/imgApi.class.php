<?php

namespace mod_apitoken\entities;

class imgApi
{

    private $poImgApi= null;

    public function __construct()
    {
        $this->poImgApi = new \mod_apitoken\plainObjects\imgApiPO();
    }
    public function getPO()
    {
        return $this->poImgApi;
    }

    public function insert()
    {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf(
            "INSERT INTO imgs_api(id) VALUES ('%s') returning id;",
            $da->escape_string($this->poImgApi->getId())
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

    public function existId()
    {
        $da = new \aretha\dao\DataAccess();
        $query = sprintf(
            "SELECT COUNT(id) FROM imgs_api WHERE id = %d;",
            $da->escape_string($this->poImgApi->getId())
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
    public function selectAll()
    {
        $da = new \aretha\dao\DataAccess();
        $query = "SELECT id, name FROM imgs_api;";

        if ($da->connect()) {
            $result = $da->execGetQuery($query);
            $da->disconnect();
            $arrResult = array();
            if ($result != false) {
                foreach ($result as $row) {
                    $oBusinessPO = new \mod_apitoken\plainObjects\imgApiPO();
                    $oBusinessPO->setId($row[0]);
                    $arrResult[] = $oBusinessPO;
                }
            }
            return $arrResult;
        } else {
            return false;
        }
    }
}
