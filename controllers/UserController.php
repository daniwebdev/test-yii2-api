<?php

namespace app\controllers;

use Yii;
use yii\web\HttpException;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


}
