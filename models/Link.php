<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "links".
 *
 * @property int $id
 * @property string $url
 * @property string $hash
 * @property int|null $visits
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['url'], 'string'],
            [['visits'], 'integer'],
            [['hash'], 'string', 'max' => 6],
            [['hash'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'hash' => 'Hash',
            'visits' => 'Visits',
        ];
    }

    public function makeHash()
    {
        do{
            $dirtyHash=Yii::$app->security->generateRandomString(6);
        } while (Link::find()->where(['hash'=>$dirtyHash])->count()!=0);
        $this->hash=$dirtyHash;
    }

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

}