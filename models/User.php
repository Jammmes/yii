<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\BaseArrayHelper;


class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public static $username;

    /**
     * @return array
     */
    public function rules()
    {
        return BaseArrayHelper::merge(
        [
            [['username','password'] , 'string'],
            [['username','password'], 'required'],
        ],
        parent::rules()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'username' => 'Имя пользователя',
            'password' => 'Пароль',

        ];
    }

    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token'=>$token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username'=>$username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $result = parent::beforeSave($insert);

        if($this->isAttributeChanged('password')){
            $this->password = \password_hash($this->password, \PASSWORD_BCRYPT);

        }
        return $result;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \password_verify($password, $this->password);
    }

    /**
     * return ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasMany(Event::class,['id'=>'user_id']);
    }
}
