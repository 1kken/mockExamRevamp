<?php

namespace app\models\query;

use app\models\Tblregion;

/**
 * This is the ActiveQuery class for [[Tblregion]].
 *
 * @see Tblregion
 */
class TblregionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tblregion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tblregion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
