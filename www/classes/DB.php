<?php

//вспомогательный класс, работающий с базой
class DB
{
    private $dbh;
    private $className = 'stdClass';

    public function __construct()
    {
        //в конструкторе создали объект PDO, который хранит связь с нашей БД, и сохранили в свойство нашего объекта $dbh
        $this->dbh = new PDO('mysql:dbname=test;host=localhost', 'root', '');
    }

    //запоминаем переданное имя класса
    public function setClassName($className)
    {
        $this->className = $className;
    }

    //передаём в метод query запрос($sql) и параметры запроса($param)
    public function query($sql, $param=[])
    {
        //подготовка запроса
        $sth = $this->dbh->prepare($sql);
        //выполнить запрос с указанными параметрами
        $sth->execute($param);
        //получение результата запроса, во второй параметр передаём имя используемого класса
        return $sth->fetchAll(PDO::FETCH_CLASS, $this->className);
    }

    /*
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
        $rot = $this->queryAll($sql, $class);
        return $rot[0];
    }
    */
}