<?php

namespace app\modules\api\v1\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use app\modules\api\v1\models\Link;

/**
 * Link controller for the `api` module
 */
class LinkController extends ActiveController
{
    public $modelClass = 'app\modules\api\v1\models\Link';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'],$actions['view'],$actions['update'],$actions['delete']);
        return $actions;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[]=[
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON
            ],
        ];
        return $behaviors;
    }


    public function actionGetByHash($hash)
    {
        return Link::find()
            ->where(['hash'=>$hash])
            ->one();
    }


}

