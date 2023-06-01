<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\AddInfoForm;
use app\models\CategoryForm;
use app\models\ProperName;
use app\models\ProperNameForm;
use app\models\ExtendedForm;
use app\models\DataDownloadForm;
use app\models\PersonalAccountUserForm;

use app\models\User;
use app\models\Category;


class SiteController extends Controller
{

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
					'class' => AccessControl::class,
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
					'class' => VerbFilter::class,
					'actions' => [
						'logout' => ['post'],
					],
			],
		];
	}

		/**
	 * {@inheritdoc}
	 */
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
		return $this->render('index');
	}

	public function actionAbout()
	{
		return $this->render('about');
	}

	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack(); 
		}

		$model->password = '';
		return $this->render('login', [
			'model' => $model,
		]);
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	public function actionSignup()
	{
		if(!Yii::$app->user->isGuest){
			return $this->goHome();
		}

		$model = new SignupForm();
			
		if ($model->load(Yii::$app->request->post())) {
			if ($user = $model->signup()) {
					if (Yii::$app->getUser()->login($user)) {
						$modelLogin = new LoginForm();
						$modelLogin->login = $model->login;
						$modelLogin->password = $model->password;
						if ($modelLogin->login()) {
							return $this->goHome(); 
						}		
					}
			}
		}

		return $this->render('signup', [
			'model' => $model,
		]);
	}

	public function actionAddNewProperName()
	{
		$model = new ProperNameForm();
		if(Yii::$app->request->post()){
			$data = Yii::$app->getRequest()->getBodyParams();
			if(count($data)>2){
				$dublicates=[];
				foreach ($data as $value) {
					$model->name = $value['name'];
					$model->description = $value['description'];
					$idCategory =  (Category::find()
					->select('id')
					->where(['name' => $value['category']])
					->one())['id'];
					if(!$model->getProperName() && !$model->getDescription()){
						Yii::$app->db->createCommand('INSERT INTO `PropersNames` (`name`,`description`,`user_id`,`category_id`) VALUES (:name,:description,:user_id,:category_id)', [
							':name' => $value['name'],
							':description' => $value['description'],
							':user_id' => Yii::$app->user->id,
							':category_id' => $idCategory 
						])->execute();
					}else if($model->getProperName()){
						array_push($dublicates,$value['name']);
					}
				}
				if(!empty($dublicates)){
					return \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => [
							'message' => $data,
							'code' => 200,
							'error' => 'dublicates'
						],
					]);
				}else{
					return \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => [
							'message' => $model->category_id = Category::find()
							->select('id')
							->where(['name' => $data[0]['category']])
							->one(),
							'code' => 200,
							'error' => null
						],
					]);
				}
			}
			else if($model->load(Yii::$app->request->post())){
				$dublicates = null;
				if($model->validate()){
					Yii::$app->db->createCommand('INSERT INTO `PropersNames` (`name`,`description`,`user_id`,`category_id`) VALUES (:name,:description,:user_id,:category_id)', [
						':name' => $model->name,
						':description' => $model->description,
						':user_id' => Yii::$app->user->id,
						':category_id' => (int)$model->category_id
					])->execute();
					return $this->render('add-new-proper-name', [
						'model' => $model,
						'message' => "Загрузка данных успешна"
					]);
				}
			}
		}
		
		if(Yii::$app->user->isGuest){
			return $this->goHome();
		}
		return $this->render('add-new-proper-name', [
			'model' => $model,
			'message' => ''
		]);
	}

	public function actionAddNewCategory()
	{
		$model = new CategoryForm();

		if(Yii::$app->request->post()){
		
			$data = Yii::$app->getRequest()->getBodyParams();
			if(count($data)>2){
				$dublicates=[];
				foreach ($data as $value) {
					$model->name = $value['name'];
					if(!$model->getNameCategory()){
						Yii::$app->db->createCommand('INSERT INTO `Category` (`id`,`name`,`ancestor`) VALUES (:id,:name,:ancestor)', [
							':id' => $value['id'],
							':name' => $value['name'],
							':ancestor' => $value['ancestor']
						])->execute();
					}else if($model->getNameCategory()){
						array_push($dublicates,$value['name']);
					}
				}
				if(!empty($dublicates)){
					return \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => [
							'message' => $dublicates,
							'code' => 200,
							'error' => 'dublicates'
						],
					]);
				}else{
					return \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => [
							'message' => "Вся загруженная информация занесена!",
							'code' => 200,
							'error' => null
						],
					]);
				}
			}
			else if($model->load(Yii::$app->request->post())){
				$dublicates = null;
				if($model->validate()){
					Yii::$app->db->createCommand('INSERT INTO `Category` (`name`,`ancestor`) VALUES (:name,:ancestor)', [
						':name' => $model->name,
						':ancestor' => $model->ancestor
					])->execute();
					
					return $this->render('add-new-category', [
						'model' => $model,
						'message' => "Загрузка данных успешна"
					]);
				}
				return $this->render('add-new-category', [
					'model' => $model,
					'message' => ""
				]);
			}
		}
		
		if(Yii::$app->user->isGuest){
			return $this->goHome();
		}

		return $this->render('add-new-category', [
			'model' => $model,
			'message' => ""
		]);
	}

	public function actionListCategory()
	{

		$dataProvider = new ActiveDataProvider([
			'query' => Category::find(),
			'pagination' => [
				'pageSize' => 49,
			],
		]);

		return $this->render('category-list', [
			'dataProvider' => $dataProvider
		]);
	}

	public function actionCategoryInfo()
	{
		if($request = Yii::$app->request){
			$idCategory = $request->get('id');
			$subCategory = new ActiveDataProvider([
				'query' => Category::find()->where(['ancestor' => $idCategory]),
				'pagination' => [
					'pageSize' => 15,
				],
			]);
			if(isset(Yii::$app->user->identity->id)){
				$propNames = new ActiveDataProvider([
					'query' => ProperName::find()->where(['category_id' => $idCategory])->andWhere(['aproved' => true])->orWhere(['user_id' => Yii::$app->user->identity->id]),
					'pagination' => [
						'pageSize' => 15,
					],
				]);
			} else{
				$propNames = new ActiveDataProvider([
					'query' => ProperName::find()->where(['category_id' => $idCategory])->andWhere(['aproved' => true]),
					'pagination' => [
						'pageSize' => 15,
					],
				]);
			}
			return $this->render('category-info', [
				'subCategory' => $subCategory,
				'title' => $request->get('name'),
				'propNames' => $propNames,
			]);
		}
		return $this->render('category-info', [
			'subCategory' => 'error',
		]);
	}

	public function actionListProperNameInfo(){
		if($request = Yii::$app->request){
			$idCategory = $request->get('id');

			$propNames = new ActiveDataProvider([
				'query' => ProperName::find()->where(['category_id' => $idCategory]),
				'pagination' => [
					'pageSize' => 15,
				],
			]);

			return $this->render('list-proper-name-info', [
				'title' => $request->get('name'),
				'propNames' => $propNames,
			]);
		}
		return $this->render('list-proper-name-info', [
		]);
	}

	public function actionProperName(){
		if($request = Yii::$app->request){
			$propName = $request->get('name');
			$propNameInfo = ProperName::findOne(['name'=> $propName]);
			return $this->render('proper-name', [
				'title' => $request->get('name'),
				'propNames' => $propNameInfo,
			]);
		}
	}

	public function actionSearchResult(){
		if($request = Yii::$app->request){
			$propName = $request->get('name');
			$propNameInfo = ProperName::findOne(['name'=> $propName ,'aproved' => true]);
			if($propNameInfo){
				return $this->render('proper-name', [
					'title' => $request->get('name'),
					'propNames' => $propNameInfo,
				]);
			}
			else{
				return $this->render('proper-name', [
					'title' => 'Произошла ошибка',
					'propNames' => 'Данного имени собственного не существует',
				]);
			}
		}
	}
	
	public function actionExtendedSearch(){
		$model= new ExtendedForm();

		if($model->load(Yii::$app->request->post())){

			if($model->properNameSearch){
				$propNameInfo = ProperName::findOne(['name'=> $model->propName]);

				return $this->render('proper-name', [
					'title' => $model->propName,
					'propNames' => $propNameInfo,
				]);
			}
			else if($model->categorySearch){
				$idCategory = $model->category;
				$categoryName = Category::findOne(['id' => $idCategory]);

				$subCategory = new ActiveDataProvider([
					'query' => Category::find()->where(['ancestor' => $idCategory]),
					'pagination' => [
						'pageSize' => 15,
					],
				]);
	
				$propNames = new ActiveDataProvider([
					'query' => ProperName::find()->where(['category_id' => $idCategory]),
					'pagination' => [
						'pageSize' => 15,
					],
				]);
	
				return $this->render('category-info', [
					'subCategory' => $subCategory,
					'title' => $categoryName->name,
					'propNames' => $propNames,
				]);
			}
			else if(is_null($model->categorySearch) && is_null($model->categorySearch)){
				return $this->render('extended-search',[
					'model' => $model,
					'message' => "Выберете хотябы один вариант поиска"
				]);
			}
		}

		return $this->render('extended-search',[
			'model' => $model,
			'message' => ''
		]);
	}
	
	public function actionDataDownload(){
		
		$model = new DataDownloadForm();
		if(Yii::$app->request->post()){
			$data = Yii::$app->getRequest()->getBodyParams();
			$model->category_id = $data;
			$querry = $model->getProperNamesByCategoryId($model->category_id);

			return  \Yii::createObject([
				'class' => 'yii\web\Response',
				'format' => \yii\web\Response::FORMAT_JSON,
				'data' => [
					'message' => $querry,
					'code' => 200,
			]]);
		}
		
		return $this->render('data-download',[
			'model' => $model,
			'message' => $model->getProperNamesByCategoryId($model->category_id)
		]);
	}

	public function actionPersonalAccount(){

		$model = new PersonalAccountUserForm();
		$model->userId = Yii::$app->user->identity->id;
		$properNames = $model->getProperNamesByUserId($model->userId);
		
		if($request = Yii::$app->request->post()){
			$data = $request;

			//edit data proper name
			if(isset($data['type']) && $data['type'] == 'edit'){
				$changeElem = $model->editUserRequest($data);
				if ($changeElem) {
					$result = ProperName::findOne(['id'=>$data['id']]);
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => $result,
					]);
				} else {
					$result = ["error"=>"Ошибка изменения базы."];
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => $result
					]);
				}
			}
			//Remove proper name 
			if(isset($data['type']) && $data['type']=='remove'){
				return  \Yii::createObject([
					'class' => 'yii\web\Response',
					'format' => \yii\web\Response::FORMAT_JSON,
					'data' => $model->removeProperName($data['id'])
				]);
			}
			// edit account data
			else{
				if($model->load($request)){
					if(is_null($model->updateUserData($model->userId,$model->login,$model->password,$model->email))){
					}else{
						$this->refresh();
					}
				}
			}
		}
		return $this->render('personal-account',[
			'model' => $model,
			'properNames' => $properNames
		]);
	}

	public function actionAdminPageCategorys(){

		$model = new Category();
		$querry = $model->getAllCategory();
		$pages = new \yii\data\Pagination(['totalCount' => $querry->count(),'pageSize' => 25]);
		$categories = $querry->offset($pages->offset)->limit($pages->limit)->all();
		if($request = Yii::$app->request->post()){
			$data = $request;
			if(isset($data['type']) && $data['type'] == 'edit'){
				$changeElem = $model->edit($data);
				if ($changeElem) {
					$result = Category::findOne(['id'=>$data['id']]);
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => $result,
					]);
				} else {
					$result = ["error"=>"Ошибка изменения базы."];
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => $result
					]);
				}
			}
			if(isset($data['type']) && $data['type']=='remove'){
				return  \Yii::createObject([
					'class' => 'yii\web\Response',
					'format' => \yii\web\Response::FORMAT_JSON,
					'data' => $model->remove($data['id'])
				]);
			}
			if(isset($data['type']) && $data['type']=='add'){
				$newInfo = $model->add($data);
				if($newInfo){
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => $newInfo 
					]);
				}else{
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => [
							"status" => "error",
							"message" => "Такой термин уже существует"
						],
					]);
				}
			}
		}
		return $this->render('admin-page-categorys',
			compact('categories','pages'));
	}

	public function actionAdminPageProperNames(){

		$model = new ProperName();
		$querry = $model->getAllProperNames();
		$pages = new \yii\data\Pagination(['totalCount' => $querry->count(),'pageSize' => 25]);
		$properNames = $querry->offset($pages->offset)->limit($pages->limit)->all();

		if($request = Yii::$app->request->post()){
			$data = $request;

			if(isset($data['type']) && $data['type'] == 'edit'){
				$changeElem = $model->edit($data);
				$data['aproved']  = $data['aproved'] == "Одобренно"?1:0; 

				if ($changeElem) {
					$result = ProperName::findOne(['id'=>$data['id']]);
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => $result,
					]);
				} else {
					$result = ["error"=>"Ошибка изменения базы."];
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => $result
					]);
				}
			}
			if(isset($data['type']) && $data['type']=='remove'){
				return  \Yii::createObject([
					'class' => 'yii\web\Response',
					'format' => \yii\web\Response::FORMAT_JSON,
					'data' => $model->remove($data['id'])
				]);
			}
			if(isset($data['type']) && $data['type']=='add'){
				$newInfo = $model->add($data);
				if($newInfo){
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => $newInfo 
					]);
				}else{
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => [
							"status" => "error",
							"message" => "Такое имя собственное уже существует"
						],
					]);
				}
			}
		}
		return $this->render('admin-page-proper-names',
			compact('properNames','pages'));
	}



	//TODO сделать таблицу пользователей
	public function actionAdminPageUsers(){

		$model = new User();
		$querry = $model->getAllUsers();
		$pages = new \yii\data\Pagination(['totalCount' => $querry->count(),'pageSize' => 25]);
		$users = $querry->offset($pages->offset)->limit($pages->limit)->all();

		if($request = Yii::$app->request->post()){
			$data = $request;

			if(isset($data['type']) && $data['type'] == 'edit'){
				$changeElem = $model->edit($data);
				if ($changeElem) {
					$result = User::findOne(['id'=>$data['id']]);
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => $result,
					]);
				} else {
					$result = ["error"=>"Ошибка изменения базы."];
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => $result
					]);
				}
			}
			if(isset($data['type']) && $data['type']=='remove'){
				return  \Yii::createObject([
					'class' => 'yii\web\Response',
					'format' => \yii\web\Response::FORMAT_JSON,
					'data' => $model->remove($data['id'])
				]);
			}
			if(isset($data['type']) && $data['type']=='add'){
				$newInfo = $model->add($data);
				if($newInfo){
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => $newInfo 
					]);
				}else{
					return  \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => [
							"status" => "error",
							"message" => "Такое имя пользователя, или email уже существуют."
						],
					]);
				}
			}
		}
		return $this->render('admin-page-users',
			compact('users','pages'));
	}
}