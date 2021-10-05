<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 14:53
 */

namespace backend\modules\kursmanager\models\traits;

use backend\models\Rating;
use backend\modules\kursmanager\models\KursComment;
use Yii;

trait KursCommentRatingTrait
{

    private $_averageRating;

    public function getRatings()
    {
        return $this->hasMany(Rating::class, ['kurs_id' => 'id']);
    }

    public function getValidRatings()
    {
        return $this->getRatings()->andWhere(['>=', 'rate', 1]);
    }

    public function getRatingsCount()
    {
        return intval($this->getValidRatings()->cache()->count());
    }

    public function getAverageRating()
    {
        if ($this->isNewRecord) {
            return 0;
        }
        if ($this->_averageRating === null) {
            $rating = $this->getValidRatings()->cache()->average('rate');
            $this->setAverageRating($rating);
        }
        return $this->_averageRating;
    }

    public function setAverageRating($rating)
    {
        $this->_averageRating = round($rating, 1);
    }

    public function getIntvalAverageRating()
    {
        return intval(round($this->getValidRatings()->average('rate'), 0));
    }

    public function getValidRatingsCount()
    {
        return $this->getValidRatings()->count();
    }

    public function getComments()
    {
        return $this->hasMany(KursComment::class, ['kurs_id' => 'id'])->andWhere(['reply_id' => null]);
    }

    public function getActiveComments()
    {
        return $this->getComments()->active();
    }

    public function getActiveCommentsCount()
    {
        return intval(Yii::$app->db->cache(function ($db) {
            return $this->getActiveComments()->count();
        }));
    }

}