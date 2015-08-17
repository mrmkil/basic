<?php

namespace app\models;
use yii\base\Model;
use \yii\db\Expression;
use yii\web\UploadedFile;

class Post extends \yii\db\ActiveRecord
{ 
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
        return 'posts';
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
            'title' => 'Title',
            'content' => 'Content',
            'created' => 'Created',
            'updated' => 'Updated',
			'image' => 'Image',
        );
    }
	
	public function rules()
{
    return array(
        array(array('title', 'content'), 'required'),
		//[['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
		
    );
}
	public function getidd()
{
   
        $command = static::getDb()->createCommand("select max(id) as id from posts")->queryAll();
        $id = $command[0]['id'] + 1;
		
		
			
			
	
    return $id;
}
public function beforeSave($insert)
{
   
   
    if ($this->isNewRecord)
    {
        $this->created = new Expression('NOW()');
        $command = static::getDb()->createCommand("select max(id) as id from posts")->queryAll();
        $this->id = $command[0]['id'] + 1;
		
		
			
			
		
    }
 
    $this->updated = new Expression('NOW()');
    return parent::beforeSave($insert);
}
	public $imageFile;
	 public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
	
}
?>
