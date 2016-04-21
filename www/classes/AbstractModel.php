<?php //объявили абстрактный класс, что-бы невозможно было создавать от него объект

abstract class AbstractModel
{
    static protected $table;

    protected $data = [];

    public function __set($k, $v)
    {
        $this->data[$k] = $v;
    }

    public function __get($k)
    {
        return $this->data[$k];
    }

    public function __isset($k)
    {
        return isset($this->data[$k]);
    }

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
        $res = $db->query($sql, [':id' => $id]);
        if (!empty($res)){
            return $res[0];
        }
        return false;
    }

    //поиск в базе данных объекта, у которого заданное поле($column) имеет заданное значение($value)
    //например для поиска новости с конкретным заголовком
    public static function findOneByColumn($column, $value)
    {
        $db = new DB();
        //передали объекту имя класса, что-бы он у себя его запомнил и установили его методом setClassName
        $db->setClassName(get_called_class());
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE '. $column . '=:value';//"SELECT * FROM news WHERE title=:value"
        $res = $db->query($sql, [':value' => $value]);
        if (empty($res)){
            //отпускаем пузырь исключения(запускаем код назад: ищем блок try{} catch{})
            throw new ModelException('Ничего не найдено...');
        }
        return $res[0];
    }

    public function insert()
    {
        //получили массив столбцов, в которых будем изменять данные с помощью ленивой инициализации
        $cols = array_keys($this->data);
        $data = [];
        foreach ($cols as $col){
            $data[':' . $col] = $this->data[$col];
        }

        //в запросе с помощью implod выводим из массива данные в список через запятую
        $sql = '
          INSERT INTO ' . static::$table . ' 
          (' . implode(', ', $cols). ')
          VALUES 
          (' . implode(', ', array_keys($data)). ') 
        ';

        $db = new DB();
        $db->execute($sql, $data);
        $this->id = $db->lastInsertId();
    }

    public function update()
    {
        $cols = [];
        $data = [];
        foreach ($this->data as $k => $v){
            $data[':' . $k] = $v;
            if ('id' == $k){
                continue;
            }
            $cols[] = $k . '=:' . $k;
        }
        $sql = '
            UPDATE ' . static::$table . '
            SET ' . implode(', ', $cols) . '
            WHERE id=:id
        ';
        $db = new DB();
        $db->execute($sql, $data);
    }

    public function save()
    {
        if (!isset($this->id)){
            $this->insert();
        }else{
            $this->update();
        }
    }

}