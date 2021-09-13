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
        $link=Link::find()
            ->where(['hash'=>$hash])
            ->one();
        if (!$link) {
            throw new \yii\web\NotFoundHttpException('Hash ' . $hash . ' not found');
        }
        $link->scenario = Link::SCENARIO_GETBYHASH;
        return $link;
    }


}

