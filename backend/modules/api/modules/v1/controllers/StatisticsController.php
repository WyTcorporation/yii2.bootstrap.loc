<?phpnamespace backend\modules\api\modules\v1\controllers;use backend\controllers\AppAdminController;use backend\models\categories\Categories;use yii\web\Controller;use yii\helpers\Json;use Yii;use yii\web\Response;class StatisticsController extends AppAdminController{    public $enableCsrfValidation = false;    public static function allowedDomains()    {        return [            '*',                        // star allows all domains        ];    }    public function behaviors()    {        return array_merge(parent::behaviors(), [            // For cross-domain AJAX request            'corsFilter' => [                'class' => \yii\filters\Cors::className(),                'cors' => [                    // restrict access to domains:                    'Origin' => static::allowedDomains(),                    'Access-Control-Allow-Origin' => ['*'],                    'Access-Control-Request-Method' => ['POST', 'GET','PUT',"DELETE"],                    'Access-Control-Allow-Credentials' => false,                    'Access-Control-Max-Age' => 3600,                 // Cache (seconds)                ],            ],        ]);    }    public function actionIndex()    {        try {            $data = Yii::$app->request->post();            Yii::$app->response->format = Response::FORMAT_JSON;            $category = Categories::find()->all();            return ["code"=>200,"message"=>"OK",'data'=>$category];            //return Json::encode(["code"=>200,"message"=>"OK",'data'=>$category]);        } catch (\Exception $e) {            $errors = ['message' => $e->getMessage(), 'code' => $e->getCode(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'data' => \Yii::$app->request->get()];            \Yii::error($errors, 'statistics-v1');            print Json::encode($errors);        }    }}