<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Link;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Редиректит на url найденный по hash.
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionRedirect($hash)
    {
        $link=Link::find()->where(['hash'=>$hash])->one();
        if (is_null($link)){
            throw new \yii\web\NotFoundHttpException('Hash '.$hash.' not found');
        }
        $link->updateCounters(['visits' => 1]);
        return $this->redirect($link->url);
    }

}
