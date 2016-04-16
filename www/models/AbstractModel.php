<?php

abstract class AbstractModel
{

    protected static $table;
    protected static $class;

    //возвпат всех новостей, имеющихся в базе
    public static function getAll()
    {
        $db = new DB();
        return $db->queryAll('SELECT * FROM ' . static::$table, static::$class);
    }

    //возвпат одной новости из базы
    public static function getOne($id)
    {
        $db = new DB();
        return $db->queryOne('SELECT * FROM ' . static::$table . ' WHERE id='. $id, static::$class);
    }
}