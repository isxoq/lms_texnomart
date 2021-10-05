<?php

namespace backend\modules\postmanager\models\query;

class PostQuery extends \soft\db\SActiveQuery
{

    public function published()
    {
        return $this->andWhere(['<=', 'post.published_at', time()]);
    }

    public function recently($limit = 0)
    {
        $query = $this->orderBy(['post.published_at' => SORT_DESC]);
        if ($limit > 0){
            $query->limit($limit);
        }
        return $query;
    }

}
