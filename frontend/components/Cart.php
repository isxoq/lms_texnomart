<?php


namespace frontend\components;


use frontend\models\Kurs;
use frontend\models\Product;
use Yii;
use yii\helpers\ArrayHelper;


/**
 *
 * @property-read int $countItems
 * @property-read bool $hasItems
 * @property-read array $items
 * @property-read int $totalPrice
 * @property-read mixed $formattedTotalPrice
 * @property-read Kurs[] $courses
 */
class Cart extends \yii\base\Model

{

    public function add($id)
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart', []);
        $cart[$id] = true;
        $session['cart'] = $cart;
        return true;
    }

    public function remove($id)
    {
        Yii::$app->session->open();
        if (isset($_SESSION['cart'][$id])) {
            unset ($_SESSION['cart'][$id]);
        }
    }

    public function clear()
    {
        Yii::$app->session->remove('cart');
    }

    public function getCountItems()
    {
        $count = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $count = count($_SESSION['cart']);
        }
        return $count;
    }

    public function getItems()
    {
        return Yii::$app->session->get('cart', []);
    }

    public function getHasItems()
    {
        return !empty($this->items);
    }

    public function getCourses()
    {
        $ids = array_keys($this->items);
        if (empty($ids)) {
            return [];
        }

        return Kurs::find()->active()->indexBy('id')->andWhere(['in', 'kurs.id', $ids])->with('category')->all();
    }

    public function getTotalPrice()
    {
        $ids = array_keys($this->items);
        return Yii::$app->db->cache(function () use ($ids) {
            return Kurs::find()->active()->andWhere(['in', 'kurs.id', $ids])->sum('price');
        });
    }

    public function getFormattedTotalPrice()
    {
        return Yii::$app->formatter->asSum($this->totalPrice);
    }

}