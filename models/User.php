<?php

namespace app\models;
use yii\web\IdentityInterface;
use conquer\oauth2\OAuth2IdentityInterface;
// use yii\base\BaseObject;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements IdentityInterface, OAuth2IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $auth_key;
    public $access_token;

    private static $users = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required', 'on' => 'create'],
            [['username', 'email'], 'required', 'on' => 'update'],
            [['user_level'], 'string'],
            [['email'], 'email'],
            [['username', 'email'], 'unique'],
            [['phone_number'],'string','max' => 30],
            [['username','password','password_reset_token','full_name', 'email'], 'string', 'max' => 250],
            [['user_image'], 'string', 'max' => 500],
            [['user_image'], 'file'],            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = self::find()
            ->where(["id" => $id])
            ->asArray()
            ->one();
        if (!$user) {
            return null;
        }
        return new static($user);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::find()
            ->where(["access_token" => $token])
            ->asArray()
            ->one();
        if (!$user) {
            return null;
        }
        return new static($user);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = self::find()
            ->where(["username" => $username])
            ->asArray()
            ->one();
        if (!$user) {
            return null;
        }
        return new static($user);
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
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findIdentityByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
            }
            return true;
        }
        return false;
    }

}
