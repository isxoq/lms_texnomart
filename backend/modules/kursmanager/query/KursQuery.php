<?php

namespace backend\modules\kursmanager\query;

class KursQuery extends \soft\db\SActiveQuery
{

    public function free($free = true)
    {
        return $this->andWhere(['kurs.is_free' => $free]);
    }

    public function recently($limit = 0)
    {
        $this->orderBy(['kurs.published_at' => SORT_DESC]);
        if ($limit > 0){
            $this->limit($limit);
        }
        return $this;
    }

}