<?php


namespace backend\modules\menumanager\controllers;

use backend\controllers\BackendController;
use backend\modules\pagemanager\models\Page;
use backend\modules\postmanager\models\PostCategory;
use Yii;
use yii\helpers\Html;

use yii\web\Controller;

class MenuController extends BackendController
{

    public function actionGetValue()
    {

        $options = '';
        $type = $_GET['type'];
        if ($type == 'category') {
            $options = $this->categories();
        }

        if ($type == 'page') {
            $options = $this->pages();
        }

        if ($type == 'c-action') {
            $options = $this->sections();
        }

        return Html::tag('select', $options, [
            'id' => 'tree-url_value',
            'class' => 'form-control',
            'name' => 'Menu[url_value]'
        ]);

    }

    private function categories()
    {

        $categories = PostCategory::find()->multilingual()->all();
        $options = Html::tag('option', "Kategoriyani tanlang");
        foreach ($categories as $category) {
            $options .= Html::tag('option', $category->title, ['value' => $category->slug]);
        }

        return $options;
    }

    private function pages()
    {
        $pages = Page::find()->multilingual()->all();
        $options = Html::tag('option', "Sahifani tanlang");
        foreach ($pages as $page) {
            $options .= Html::tag('option', $page->title, ['value' => $page->id]);
        }
        return $options;
    }

    private function sections()
    {
        $sections = Yii::$app->getModule('menumanager')->sections();
        $options = Html::tag('option', "Sahifani tanlang ... ");
        foreach ($sections as $route => $label) {
            $options .= Html::tag('option', $label, ['value' => $route]);
        }
        return $options;
    }

}