<?php

namespace app\models;
use yii\base\Model;
use \yii\db\Expression;
use yii\web\UploadedFile;
use \yii\db\ActiveRecord;
use  yii\web\IdentityInterface;


class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
	    public $name;
    public $surname;
    public $image;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
		   
        $command = static::getDb()->createCommand("select * from user where id=".$id)->queryAll();
        
    
		
        return isset($command[0]) ? new static($command[0]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
		$command = static::getDb()->createCommand("select * from user where login='".$username."'")->queryAll();
        if (count($command)>=1){
		return new static($command[0]);
		}else return null;
    }

    

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
	
	
	
	
	
	
	
	
	
	   public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'user';
    }
 
    /**
     * @return array primary key of the table
     **/     
    public static function primaryKey()
    {
        return array('id');
    }
 
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'name' => 'Name',
            'surname' => 'Surname',
			'image' => 'Image',
        );
    }
	
	public function rules()
	{
		return array(
        array(array('login', 'password'), 'required'),
	//	array(['image'], 'file',  'extensions' => 'png,jpg', 'skipOnEmpty' => false)
		
		);
	}
	public function beforeSave($insert)
	{
		if ($this->isNewRecord)
    {
        $this->created = new Expression('NOW()');
        //$command = static::getDb()->createCommand("select max(id) as id from posts")->queryAll();
       // $this->id = $command[0]['id'] + 1;
    }
 
    $this->updated = new Expression('NOW()');
    return parent::beforeSave($insert);
}
	
}
