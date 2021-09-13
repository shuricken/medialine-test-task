<?php

namespace app\modules\api\v1\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "links".
 *
 * @property int $id
 * @property string $url
 * @property string $hash
 * @property int|null $visits
 */
class Link extends \app\models\Link
{
    private $_shortlink;

    const SCENARIO_CREATE = 'default';
    const SCENARIO_GETBYHASH = 'get-by-hash';

    public function fields()
    {
        $fields = parent::fields();
        if ($this->scenario === self::SCENARIO_CREATE) {
            $fields = ['shortlink'];
        }
        if ($this->scenario === self::SCENARIO_GETBYHASH) {
            $fields = ['url','visits'];
        }
        return $fields;
    }

    /**
     * @throws \yii\base\Exception
     */
    public function makeHash()
    {
        do{
            $dirtyHash=Yii::$app->security->generateRandomString(6);
        } while (!is_null(Link::find()->where(['hash'=>$dirtyHash])->one()));
        $this->hash=$dirtyHash;
    }

    /**
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if (empty($this->hash)){
            $this->makeHash();
        }
        return true;
    }

    public function getShortlink()
    {
        return Url::home(true).$this->hash;
    }
}
