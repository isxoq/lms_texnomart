<?php


namespace backend\modules\import\models;

use common\models\User;
use backend\modules\kursmanager\models\Kurs;
use backend\modules\kursmanager\models\Section;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 *
 * @property-read mixed $sections
 */
class OldKurs extends ActiveRecord
{

    public static function tableName()
    {
        return 'course';
    }

    public static function getDb()
    {
        return Yii::$app->db2;
    }


    public function getSections()
    {
        return $this->hasMany(OldSection::class, ['course_id' => 'id']);
    }

    public function importKurs()
    {
        $kurs = new Kurs([
            'id' => $this->id,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'category_id' => $this->sub_category_id,
            'level' => $this->level,
            'user_id' => $this->user_id,
            'is_best' => $this->is_top_course,
            'is_free' => $this->is_free_course,
            'preview_host' => $this->course_overview_provider,
            'preview_link' => $this->video_url,
            'language' => substr($this->language, 0, 2),
            'image' => "/uploads/course/course_thumbnail_default_" . $this->id,
            'meta_keywords' => $this->meta_keywords,
            'meta_description' => $this->meta_description,
            'created_at' => $this->date_added,
            'updated_at' => $this->last_modified,
            'status' => $this->status == 'active' ? 1 : 5,
            'deleted' => 0,
            'benefits' => $this->benefits(),
            'requirements' => $this->requirements()


        ]);

        $kurs = $this->getPrices($kurs);
        return $kurs->save();
    }


    public function importSections()
    {
        $oldSections = $this->sections;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $flag = true;
            foreach ($oldSections as $oldSection) {
                $newSection = new Section([
                    'id' => $oldSection->id,
                    'title' => $oldSection->title,
                    'kurs_id' => $oldSection->course_id,
                    'sort' => $oldSection->order,
                    'status' => 1,
                ]);

                if (!$newSection->save()) {
                    $flag = false;
                    $transaction->rollBack();
                    break;
                }
            }
            if ($flag) {
                $transaction->commit();
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            dd("$e");
        }

    }

    /**
     * @param $kurs Kurs
     * @return Kurs
     */
    public function getPrices($kurs)
    {
        if ($this->discounted_price == 0) {
            $kurs->old_price = 0;
            $kurs->price = $this->price;
        } else {
            $kurs->old_price = $this->price;
            $kurs->price = $this->discounted_price;
        }
        return $kurs;
    }

    public function benefits()
    {
        return $this->outcomes;
        $benefits = [];
        $outcomes = json_decode($this->outcomes);
        foreach ($outcomes as $outcome) {
            $benefits[]['benefits'] = $outcome;
        }
        return Json::encode($benefits);
    }

    public function requirements()
    {
        return $this->requirements;
        $result = [];
        $requirements = json_decode($this->requirements);
        foreach ($requirements as $requirement) {
            $result[]['requirements'] = $requirement;
        }
        return Json::encode($result);
    }


    public function findUserId()
    {
        $user = User::findOne($this->user_id);
        return $user == null ? 2 : $user->id;
    }

}