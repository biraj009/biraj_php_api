<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\Controller;

class LoginController extends Controller
{
    
    public function actionUserLogin(){  

        $login_details = \Yii::$app->getRequest()->getBodyParams();
        if($login_details){
            if( (isset($login_details['username']) && $login_details['username']) && (isset($login_details['password']) && $login_details['password']) ){
                $user=(new \yii\db\Query())
                    ->select(['*'])
                    ->from('user')
                    ->where('(username= :username or email = :email) AND deleted = :deleted AND status = :status', [':username' => $login_details['username'], ':email' => $login_details['username'], ':deleted' => 0, ':status' => 1])
                    ->one();  
                if($user){
                    $userId = \app\modules\v1\models\User::find()->where(array('id'=>$user['id']))->one();
                    $result = $userId->validatePassword($login_details['password']); 
                    if($result){
                        $acces_token = $userId->generateAuthKey(); 
                        \Yii::$app->response->statusCode = 200;
                        return ['status' => 200,'message' => 'user successfully loggedin', 'user' => $acces_token];
                    } else {
                        \Yii::$app->response->statusCode = 404;
                        return ['status' => 404,'message' => 'username and password does not match'];
                    }
                } else {
                    \Yii::$app->response->statusCode = 404;
                    return ['status' => 404,'message' => 'user not found '];
                }
            }
        }
    }
}
