<?php

class View implements Iterator
{

    private $position = 0;
    protected $data = array();
    
    public function __construct()
    {
        $this->position = 0;
    }
    //передача данных, которые хотим отобразить, объекту и запись их в массив $data{}
    //public function assign($name, $value)
    //{
    //    $this->data[$name] = $value;
    //}
    //ленивая инициализация на установку (мутатор)
    public function __set($k, $v)
    {
        $this->data[$k] = $v;
    }
    //ленивая инициализация на получение (акцептор)
    public function __get($k)
    {
        return $this->data[$k];
    }

    //метод подключения view
    public function render($template)
    {
        //$this->data['items'] --> $items
        foreach ($this->data as $key => $val){
            //переменная с именем (первая $), чьё имя содержится в другой переменной ($key)
            $$key = $val;
        }
        //проводим view через буфер вывода перед передачей в браузер клиента
        //стартуем
        ob_start();
        //подключаем шаблон
        include __DIR__ . '/../views/' . $template;
        //запоминаем шаблон в переменную $content
        $content = ob_get_contents();
        //очищаем буфер
        ob_end_clean();
        return $content;
    }
    //тут можно скорректировать шаблон перед передачей клиенту в браузер
    public  function display($template)
    {
        echo $this->render($template);    
    }
    

    public function current()
    {
        //var_dump($this->data);
        return $this->data[$this->position];
    }

    public function next()
    {
        //var_dump(__METHOD__);
        ++$this->position;
    }

    public function key()
    {
        //var_dump(__METHOD__);
        return $this->position;
    }

    public function valid()
    {
        //var_dump(__METHOD__);
        return isset($this->data[$this->position]);
    }

    public function rewind()
    {
        //var_dump(__METHOD__);
        $this->position = 0;
    }
}