<?php

namespace app\models;
use yii\base\Model;
use \yii\db\Expression;
use yii\web\UploadedFile;

class Comment extends \yii\db\ActiveRecord
{  public $image;
     /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comments the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'comments';
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
            'content' => 'Content',
            'id_user' => 'Id_user',
            'id_user_commented' => 'Id_user_commented',
			
        );
    }
	
	public function rules()
	{
		return array(
			array(array('content'), 'required'),
		
		);
	}

	public function beforeSave($insert)
	{
		$this->updated = new Expression('NOW()');
		return parent::beforeSave($insert);
	}
	
}
?>
