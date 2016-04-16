<?php //контроллер, управление выводом новостей(NewsController)

//require_once __DIR__ .'/../models/News.php'; //перенесено в автозагрузку(autoload.php)

class NewsController //контроллер новостей
{
    //вывод всех новостей
    public function actionAll()
    {
        //пытаемся получить запись из базы данных с помощью модели
        $items = News::getAll();
        //отображаем эту модель с помощью view
        include __DIR__ . '/../views/news/all.php';
    }

    //вывод одной новости(id) по запросу пользователя
    public function actionOne()
    {
        //какую новость(id) хочет пользователь
        $id = $_GET['id'];
        //пытаемся получить запись из базы данных с помощью модели
        $item = News::getOne($id);
        //отображаем эту модель с помощью view
        include __DIR__ . '/../views/news/one.php';
    }
}