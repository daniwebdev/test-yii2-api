<?php

namespace app\controllers;

class AuthController extends \yii\web\Controller
{
    public function actionLogin()
    {
        return $this->render('index');
    }

}
