<?php

namespace app\modules\v1\models;

use Yii;
use yii\web\IdentityInterface;

class User extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user';
    }
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'username', 'password'], 'required'],
            [['age', 'sex', 'city', 'state', 'created_at', 'deleted', 'status', 'updated_at'], 'safe', 'on' => ['update']],
            [['email'], 'email'],
            ['username', 'unique', 'targetClass' => 'app\modules\v1\models\User', 'message' => 'This username has already been taken.'],
            ['email', 'unique', 'targetClass' => 'app\modules\v1\models\User', 'message' => 'This email has already been taken.'],
            ['access_token', 'unique', 'targetClass' => 'app\modules\v1\models\User', 'message' => 'Invalid access_token.'],
            ['email', 'filter', 'filter' => 'trim'],
            ['password', 'validatePassword'],
            ['username', 'filter', 'filter' => 'trim'],
            [['name', 'city', 'state'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'access_token' => 'Access Token',
            'name' => 'Name',
            'age' => 'Age',
            'sex' => 'Sex',
            'city' => 'City',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function addUserDetails($data){

        if($data){
            $this->username = $data['username'];
            $this->email = $data['email'];
            $this->name = $data['name'];
            $this->sex = $data['sex'];
            $this->age = $data['age'];
            $this->password = Yii::$app->getSecurity()->generatePasswordHash($data['password']);
            $this->status =1;
            $this->deleted = 0;
            $this->city = $data['city'];
            $this->state = $data['state'];

            return $this;
        }

    }
    public function updateUserDetails($data){
        if($data){
            $this->username = $data['username'] ? $data['username'] : $this->username;
            $this->email = $data['email'] ? $data['email'] : $this->email;
            $this->name = $data['name'] ? $data['name'] : $this->name;
            $this->sex = $data['sex'] ? $data['sex'] : $this->sex;
            $this->age = $data['age'] ? $data['age'] : $this->age;
            $this->password = $data['password'] ?  Yii::$app->getSecurity()->generatePasswordHash($data['password']) : $this->password;
            $this->status = 1;
            $this->deleted = 0;
            $this->city = $data['city'] ? $data['city'] : $this->city; ;
            $this->state = $data['state'] ? $data['state'] : $this->state;
    
            return $this;

        }
    }
    public function generateAuthKey() {
        $this->access_token = \Yii::$app->security->generateRandomString();
        $this->save();
        return $this;
    }
    public function validateAuthKey($authKey) {
        return $this->access_token === $authKey;
    }
    public  function validatePassword($password) {
       return \Yii::$app->security->validatePassword($password, $this->password);
    }    
  
}
