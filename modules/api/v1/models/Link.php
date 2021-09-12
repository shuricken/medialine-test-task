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

    public function fields()
    {
        $fields=parent::fields();
        if (Yii::$app->controller->action->id == 'create')
        { $fields=['shortlink'];}
        if (Yii::$app->controller->action->id == 'get-by-hash')
        { $fields=['url','visits']; }
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
