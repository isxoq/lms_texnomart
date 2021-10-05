<?php


namespace common\models;

use common\models\User;
use soft\db\SActiveQuery;

class UserQuery extends SActiveQuery
{
    public function active()
    {
        return $this->andWhere(['user.status' => User::STATUS_ACTIVE]);
    }


}