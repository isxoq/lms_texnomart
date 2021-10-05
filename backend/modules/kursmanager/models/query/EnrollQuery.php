<?php

namespace backend\modules\kursmanager\models\query;

class EnrollQuery extends \soft\db\SActiveQuery
{

    /**
     * @return EnrollQuery
     */
    public function expired()
    {
        return $this->andWhere([ '<', 'enroll.end_at', time()]);
    }

    /**
     * @return EnrollQuery
     */
    public function nonExpired()
    {
        return $this->andWhere([ '>', 'enroll.end_at', time()]);
    }

    /**
     * Bepul a'zoliklarni filtrlash
     * @return $this
     */
    public function free()
    {
        return $this->andWhere(['<', 'sold_price', 1]);
    }

    /**
     * Pullik a'zoliklarni filtrlash
     * @return $this
     */
    public function paid()
    {
        return $this->andWhere(['>', 'sold_price', 0]);
    }

}