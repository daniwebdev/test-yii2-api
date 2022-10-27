<?php

namespace app\controllers;

use app\common\components\Helpers;
use app\models\User;
use Exception;
use PHPUnit\TextUI\Help;
use Yii;
use yii\web\HttpException;

class AuthController extends BaseController
{

    
    public function actionLogin() {

        try {
            $body       =  Yii::$app->getRequest()->getBodyParams();
            $model      = new User();

            $user       = $model->find()->where(['email' => $body['email']])->one();

            // jika email tidak ditemukan
            if($user == null) {
                throw new HttpException(401, "Email tidak terdaftar");
            }

            // jika user tidak active
            if($user->is_active != 1) {
                throw new HttpException(401, "User tidak active (Disable)");
            }

            $checkPassword = Yii::$app->getSecurity()->validatePassword($body['password'], $user->password);

            if(!$checkPassword) {
                throw new HttpException(401, "Password yang anda masukan salah.");
            }

            // mengambil konfigurasi dari database 'config' dengan key = TOKEN_EXP_SECONDS jika
            // jika tidak ada waktu kadaluara token = 60*60*24 (24jam)
            $exp_seconds = Helpers::config('TOKEN_EXP_SECONDS') ?? 60*60*24;

            // membuat token autentikasi
            $token = Helpers::createToken([
                'id' => $user['id'],
                'email' => $user['email']
            ], $exp_seconds);


            return $this->responseSuccess([
                "token" => $token,
                "user"  => $user,
            ]);

        } catch (HttpException $th) {

            return $this->responseError($th->getMessage(), [], $th->statusCode);
        } catch (\Throwable $th) {

            return $this->responseError($th->getMessage(), [], $th->getCode() ? $th->getCode():500);
        }

    }


    public function actionRegister() {
        
       try {

            $body       =  Yii::$app->getRequest()->getBodyParams();
            $model      = new User();

            $checkEmail = $model->find()->where(['email' => $body['email']])->count();

            if($checkEmail) {

                throw new HttpException(401, "Email sudah terdaftar.");

            }

            $hashPassword = Yii::$app->getSecurity()->generatePasswordHash($body['password']);

            $model->first_name = $body['first_name'];
            $model->last_name  = $body['last_name'];
            $model->password   = $hashPassword;
            $model->email      = $body['email'];
            $model->is_active  = 1;

            $model->save();

            return $this->responseSuccess([$model]);

       } catch (HttpException $th) {

            return $this->responseError($th->getMessage(), [], $th->statusCode);
       } catch (\Throwable $th) {

            return $this->responseError($th->getMessage(), [], $th->getCode() ? $th->getCode():500);
        }

    }

}
