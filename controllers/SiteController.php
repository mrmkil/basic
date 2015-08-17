<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\User;
use app\models\Userreg;
use app\models\Like;
use app\models\Comment;
use app\models\ContactForm;
use app\models\UploadForm;
use app\models\Post;
use yii\widgets\LinkPager;
use yii\base\HttpException;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\web\Helpers;
use yii\data\Pagination;
use yii\db\Query;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class SiteController extends Controller
{
	 public $imageFile;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
		$post = new Post;
		$query = Post::find();
		
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count(),  'pageSize' => 20]);
		$pages->pageSizeParam = false;
		$post = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['id' => SORT_DESC])
            ->all();
 
        return $this->render('index',
        [
         'post'      => $post,
         'pagenator' => $pages,
        ]
        );
		
		

		/*$post = new Post;
		$data = $post->find()->all();
		echo $this->render('index', array(
        'data' => $data
    ));*/
    }
	
	
	public function actionUpload()
    {
		$id = Yii::$app->user->identity->id; 
		$model = new UploadForm();
		$Post = new Userreg();
		
		if ($id === NULL)
			throw new HttpException(404, 'Not Found');
		
		$Post = $Post->find()->where(['id' => $id])->all();
		$Post = $Post[0];
		
		if ($Post === NULL)
			throw new HttpException(404, 'Document Does Not Exist');
 
		
		
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
			
            if ($model->file && $model->validate()) {                
                $model->file->saveAs('uploads/avatar/' . $Post->id . '.' . $model->file->extension);
				
            }
			$Post->image = 'uploads/avatar/' . $Post->id . '.' . $model->file->extension;
			if ($Post->save()){
				Yii::$app->response->redirect(array('site/user', 'id' => $Post->id));
			} }
		
        return $this->render('upload', ['model' => $model]);
    }
	
	
	public function actionLike()
    {
		$mark = $_POST['mark'];
		$id_user = $_POST['id_user'];
		$id_user1 = Yii::$app->user->identity->id;
		$like = new Like;
		
		$like->id_user1 = Yii::$app->user->identity->id;
		$like->id_user2 = $id_user;
		$like->mark = $mark;
		$data = $like->find()->where(['id_user1' => Yii::$app->user->identity->id, 'id_user2' => $id_user]  )->all();
		
		if (count($data)>=1)
		{
			
			
			$like->updateMark($id_user1,$id_user,$mark); 
			
			//$like = like::find()->where(['id_user1' => Yii::$app->user->identity->id, 'id_user2' => $id_user]  )->One();

			//$like->updateCounters();
			//$like->update();
		}
		else{$like->save();}
		$sum = $like->sum($id_user);
		return $sum;
    
    }
	
	public function actionUser($id=NULL)
	{
			
		$model = new User();
		$comment = new Comment;
		$like = new Like;
		
		if (isset($_POST['Comment']))
		{
		
			
			$comment->content = $_POST['Comment']['comment'];
			$comment->id_user = $_POST['Comment']['id_user'];
			$comment->id_user_commented = $_POST['Comment']['id_my'];
			  
						
			if ($comment->save())
			{	
							
				
			}
		}
 
		
		if ($id === NULL)
            throw new HttpException(404, 'Not Found');
	
		$data = $comment->find()->where(['id_user' => $id])->all();
		//Post::find()->where(['id' => $id])->all();;
        $user = $model->findIdentity($id);
		
 
        if ($user === NULL)
            throw new HttpException(404, 'Document Does Not Exist');
 
		$sum = $like->sum($id);
        echo $this->render('user', array(
	    'user' => $user,
	    'comment' => $comment,
		'data' => $data,
		'sum' => $sum
        ));
	}
	
	public function actionUserupdate($id=NULL)
	{
		$model = new Userreg();
		if ($id === NULL)
			throw new HttpException(404, 'Not Found');
 
		$model = $model->find()->where(['id' => $id])->all();
		$model = $model[0];
		
		if ($model === NULL)
			throw new HttpException(404, 'Document Does Not Exist');
 
		if (isset($_POST['Userreg']))
		{
			
			$model->login = $_POST['Userreg']['login'];
			$model->password = $_POST['Userreg']['password'];
			$model->name = $_POST['Userreg']['name'];
			$model->surname = $_POST['Userreg']['surname']; 
 
			if ($model->save()){
				//Yii::$app->response->redirect(array('site/read', 'id' => $model->id));
		}
 }
		echo $this->render('reg', array(
			'model' => $model
		));
	}
	
	public function actionReg()
	{ 
		//$dir = Yii::getAlias('@frontend/../web/uploads/test/');
        //$uploaded = false;
		$model = new Userreg();
	
		if (isset($_POST['Userreg']))
		{
		
			
            
			$model->login = $_POST['Userreg']['login'];
			$model->password = $_POST['Userreg']['password'];
			$model->name = $_POST['Userreg']['name'];
			$model->surname = $_POST['Userreg']['surname'];  
			
			
			/*$model->login = 'login';
			$model->password = 'password';
			$model->name = 'name';
			$model->surname = 'surname';*/
			//$model->surname = $_POST['Post']['Userreg']['surname'];

				$data1 = $model->find()->where(['login' => $model->login])->all();	
				if(!$data1){
			if ($model->save())
			{	
							
				Yii::$app->response->redirect('site/login');
				}}
		}
 
		echo $this->render('reg', array(
			'model' => $model
	)); 
	}
	

	public function actionRead($id=NULL)
	{
		 if ($id === NULL)
            throw new HttpException(404, 'Not Found');
 
        
		$post = Post::find()->where(['id' => $id])->all();;
 
        if ($post === NULL)
            throw new HttpException(404, 'Document Does Not Exist');
 
		
        echo $this->render('read', array(
	    'post' => $post[0]
        ));
	}
	
	public function actionCreate()
	{
		/*
		$id = Yii::$app->user->identity->id; 
		$model = new UploadForm();
		
		
		if ($id === NULL)
			throw new HttpException(404, 'Not Found');
		
		$Post = $Post->find()->where(['id' => $id])->all();
		$Post = $Post[0];
		
		if ($Post === NULL)
			throw new HttpException(404, 'Document Does Not Exist');
 
		
		
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
			
            if ($model->file && $model->validate()) {                
                $model->file->saveAs('uploads/avatar/' . $Post->id . '.' . $model->file->extension);
				
            }
			$Post->image = 'uploads/avatar/' . $Post->id . '.' . $model->file->extension;
			if ($Post->save()){
				Yii::$app->response->redirect(array('site/user', 'id' => $Post->id));
			} }
		


		*/
		
		
		//$dir = Yii::getAlias('@frontend/../web/uploads/test/');
        //$uploaded = false;
		
		$model1 = new UploadForm();
		$model = new Post;
		
		
	
		  /* if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // file is uploaded successfully
                
            }
        }
			*/
		if (Yii::$app->request->isPost) 
		{
			 $model1->file = UploadedFile::getInstance($model1, 'file');

            if ($model1->file && $model1->validate()) {  
				$idd = $model->getidd();
                $model1->file->saveAs('uploads/post/' . $idd . '.' . $model1->file->extension);
				$model->image = 'uploads/post/' . $idd . '.' . $model1->file->extension;
            }
			
			
     
			
			//$model->image = UploadedFile::getInstance($model, 'image');
	
			// if($model->image !== null)
			//{ $file = $model->image->saveAs('uploads/'.$model->image); }
            
           
			$model->title = $_POST['Post']['title'];
			$model->content = $_POST['Post']['content'];
 
			
			if ($model->save())
			{	
				 
				
				Yii::$app->response->redirect(array('site/index'));
			}
		}
 
		return $this->render('create', array(
			'model' => $model,
			'model1' => $model1
		));
	}
	
	
	
	public function actionUpdate($id=NULL)
	{
		if ($id === NULL)
			throw new HttpException(404, 'Not Found');
 
		$Post = Post::find()->where(['id' => $id])->all();
		$model = $Post[0];
		
		if ($model === NULL)
			throw new HttpException(404, 'Document Does Not Exist');
 
		if (isset($_POST['Post']))
		{
			$model->title = $_POST['Post']['title'];
			$model->content = $_POST['Post']['content'];
 
			if ($model->save())
				Yii::$app->response->redirect(array('site/read', 'id' => $model->id));
		}
 
		echo $this->render('create', array(
			'model' => $model
		));
	}
	
	public function actionDelete($id=NULL)
	{
		if ($id === NULL)
		{
			Yii::$app->session->setFlash('PostDeletedError');
			Yii::$app->getResponse()->redirect(array('site/index'));
    }	
 
		$post = Post::find()->where(['id' => $id])->all();
 
 
		if ($post === NULL)
		{
			Yii::$app->session->setFlash('PostDeletedError');
			Yii::$app->getResponse()->redirect(array('site/index'));
		}
 
		$post[0]->delete();
 
		Yii::$app->session->setFlash('PostDeleted');
		Yii::$app->getResponse()->redirect(array('site/index'));
	}
	
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
