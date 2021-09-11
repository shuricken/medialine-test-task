<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use app\models\Link;

/**
 * Link controller for the `api` module
 */
class LinkController extends ActiveController
{
    public $modelClass = 'app\models\Link';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ],
        ];
    }

    public function actionGetByHash($hash)
    {
        return Link::find()
            ->where(['hash'=>$hash])
            ->one();
    }

}

