<?php //объявили абстрактный класс, что-бы невозможно было создавать от него объект

abstract class AbstractModel
{
    static protected $table;

    //получить все записи из БД
    public static function findAll()
    {
        //получаем имя класса, который будет этот метод использовать
        $class = get_called_class();
        $sql = 'SELECT * FROM ' . static::$table;
        $db = new DB();
        //передали объекту имя класса, что-бы он у себя его запомнил
        $db->setClassName($class);
        return $db->query($sql);
    }

    //получить одну запись из БД по первичному ключу
    public static function findOneByPk($id)
    {
        //получаем имя класса, который будет этот метод использовать
        $class = get_called_class();
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE id=:id';
        $db = new DB();
        //передали объекту имя класса, что-бы он у себя его запомнил
        $db->setClassName($class);
        return $db->query($sql, [':id' => $id]);
    }


}