<?php

namespace app\models\query;

use app\models\Person;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[Person]].
 *
 * @see Person
 */
class PersonQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Person[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Person|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function getGroupedStatusCount(){
        return parent ::
        select([
            'status_text' => new Expression("
            CASE person.status
                WHEN 0 THEN 'Under Investigation'
                WHEN 1 THEN 'Surrendered'
                WHEN 2 THEN 'Apprehended'
                WHEN 3 THEN 'Escaped'
                WHEN 4 THEN 'Deceased'
                ELSE 'Unknown Status'
            END
        "), 'count' => new Expression('COUNT(*)')]); // Count occurrences of each status]);
    }

    public function getCountByBracket(){
        return parent ::
        select(['count' => new Expression('COUNT(*)')]);

    }
}
