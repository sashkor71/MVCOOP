<?php //контроллер, управление выводом новостей(NewsController)

//require_once __DIR__ .'/../models/News.php'; //перенесено в автозагрузку(autoload.php)

class NewsController //контроллер новостей
{
    //вывод всех новостей
    public function actionAll()
    {

        $art = NewsModel::findOneByColumn('title', 'Третьино');
        $art->title = 'Вторая статья';
        $art->save();
        die;
        //пытаемся получить запись из базы данных с помощью модели
        $news = News::getAll();
        //создаём объект View
        $view = new View();
        //1 вариант: передаём данные($news) из базы в метод assign объекта $view
        //$view->assign('items', $news);
        //2 вариант: передаём данные($news) из базы в произвольное свойство items
        $view->items = $news;
        //передаём шаблон view(all.php) объекту в метод display
        $view->display('news/all.php');
        //отображаем эту модель с помощью view
    }

    //вывод одной новости(id) по запросу пользователя
    public function actionOne()
    {
        //какую новость(id) хочет пользователь
        $id = $_GET['id'];
        //пытаемся получить запись из базы данных с помощью модели
        $items = News::getOne($id);
        //создаём объект View
        $view = new View();
        //передаём данные($items) из базы в метод assign объекта $view
        $view->assign('items', $items);
        //передаём шаблон view(one.php) объекту в метод display
        $view->render('news/one.php');
    }
}