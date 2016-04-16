<?php

//вспомогательный класс, работающий с базой
class DB
{
    public $link;
    public function __construct()
    {
        $this->link = mysqli_connect('localhost', 'root', '', 'test');
    }

    public function queryAll($sql, $class = 'stdClass')
    {
        $res = mysqli_query($this->link, $sql);
        if (false === $res){
            return false;
        }
        $ret = array();
        while ($row = mysqli_fetch_object($res, $class)){
            $ret[] = $row;
        }
        return $ret;
    }

    public function queryOne($sql, $class = 'stdClass')
    {
        return $this->queryAll($sql, $class)[0];
    }
}