<?php

class NewsModel extends AbstractModel
{
    static protected $table = 'news';

    public $id;
    public $title;
    public $text;
}