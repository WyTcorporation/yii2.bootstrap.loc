<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 21.03.2020
 * Time: 16:59
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

namespace backend\controllers;

use backend\models\characteristics\CharacteristicsOptions;
use backend\models\characteristics\CharacteristicsProducts;
use backend\models\translations\Translations;
use Yii;
use backend\controllers\AppAdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\products\Products;
use backend\models\Csv;
use yii\web\UploadedFile;

class CsvController extends AppAdminController
{

    protected function isModerActive()
    {
        $actions = [];
        return $this->isModer($actions);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new Csv();
        $message = null;
        $send_file = null;
        $send_zip = null;
        if (Yii::$app->request->isPjax) {
            $data = Yii::$app->request->post();
            if (isset($data['download-akb-csv']) && !empty($data['download-akb-csv'])) {
                $download_akb_csv = 'active';
                if ($model->imageFile = UploadedFile::getInstance($model, 'imageFile')) {
                    $path = $model->upload();

                    if ($path) {
                        $pathToFile = Yii::$app->basePath . '/web/akb.csv';
                        if (!file_exists($pathToFile) || !is_readable($pathToFile)) {
                            $message = 'Файл отсудствует!';
                        } else {
                            $data = [];
                            $handle = fopen($pathToFile, 'r');
                            if ($handle !== false) {
                                while (($row = fgetcsv($handle, 10000, ';')) !== false) {
                                    $data[] = $row;
                                }
                            }
                            fclose($handle);
                            unset($data[0]);
                            foreach ($data as $itemes) {
                                $category_id = $itemes[0];
                                $name = $itemes[1];
                                $content = $itemes[2];
                                $price = $itemes[3];
                                $img = $itemes[4];
                                $hit = $itemes[5];
                                $new = $itemes[6];
                                $sale = $itemes[7];

                                $product = Products::findOne(['name' => $name]);
                                if (isset($product) && !empty($product)) {
                                    $product->price = $price;
                                    $product->save();
                                } else {
                                    $product = new Products();
                                    $product->category_id = $category_id;
                                    $product->name = $name;
                                    $product->price = $price;
                                    $product->content = $content;
                                    $product->img = $img;
                                    $product->hit = $hit;
                                    $product->new = $new;
                                    $product->sale = $sale;
                                    $product->save();
                                }
                            }

                            $message = '<span style="color: green;">Продукты обновлены</span>';
                        }
                    }
                } else {
                    $message = '<span style="color: red;">Выберите файл!</span>';
                }
            } elseif (isset($data['download-products-csv']) && !empty($data['download-products-csv'])) {
                $link = Yii::$app->basePath . '/web/details.csv';
                $fp = fopen('details.csv', "w");

                file_put_contents("details.csv", "");

                fputs($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));

                $title = ['category_id', 'name', 'price', 'content', 'img', 'hit', 'new', 'sale'];
                fputcsv($fp, $title, $delimiter = ';');

                $products = Products::find()->all();
                foreach ($products as $product) {
                    $product_csv = [$product->category_id, $product->name, $product->price, $product->content, $product->img, $product->hit, $product->new, $product->sale];
                    fputcsv($fp, $product_csv, $delimiter = ';');
                }
                fclose($fp);

                $message = '<span style="color: green;">Скачать файл!</span>';
                $send_file = 'yes';
            } elseif (isset($data['download-products-zip']) && !empty($data['download-products-zip'])) {

                // Все работает, только надо подставить названия файлов и расположения
//                $files = [
//                    ['file_name' => $product->title . '.zip', 'local_name' => 'details/' . $product->title . '.zip'],
//                    ['file_name' => $name . '.zip', 'local_name' => 'details/' . $name . '.pdf'],
//                ];
//
//                $zip_name = 'archive' . microtime() . '.zip';
//                $file = \Yii::getAlias('@webroot/zip/' . $zip_name);
//                $zip = new \ZipArchive();
//                $zip->open($file, \ZIPARCHIVE::CREATE);
//                foreach ($files as $item) {
//                    $zip->addFile($item['local_name']);//добавляем файлы в архив
//                }
//
//                $zip->close();

//                $download_zip_input = $zip_name;


                $zip_name = 'yes'; //удалить
                $message = '<span style="color: green;">Архив создан!</span>';
                $send_zip = $zip_name;
            }
        }

        return $this->render('index', [
            'model' => $model,
            'download_akb_csv' => $download_akb_csv,
            'message' => $message,
            'send_file' => $send_file,
            'send_zip' => $send_zip,
        ]);
    }

    public function actionExcel()
    {
        $model = new Csv();
        $message = null;
        $params = Yii::$app->params['languages'];
        $language = Yii::$app->sourceLanguage;
        if (Yii::$app->request->isPjax) {
            $typeCharacteristicsOptions = 'characteristics-options';
            $paramsCharacteristicsOptions = $this->createTranslationArray($language, $typeCharacteristicsOptions, 'name');

            $typeProducts = 'products';
            $paramsProducts = $this->createTranslationArray($language, $typeProducts, 'name');

            set_time_limit(1500);
            if ($model->imageFile = UploadedFile::getInstance($model, 'imageFile')) {
                $path = $model->upload(date("d-m-Y H:i:s"));
                if ($path) {
                    $pathToFile = Yii::$app->basePath . '/web' . $path;
                    $data = \moonland\phpexcel\Excel::import($pathToFile);
                    $message = '';
                    foreach ($data as $key => $value) {
                        $brand = trim($value['Товар бренд (наимен)']);
                        $vendor_code = trim($value['Товар код']);
                        $name = trim($value['Товар нименов.']);
                        $price = trim($value['!Цена']);
                        if (isset($name) && !empty($name)) {
                            $array[$key]['brand'] = $brand;
                            $array[$key]['vendor_code'] = $vendor_code;
                            $array[$key]['name'] = $name;
                            $array[$key]['price'] = str_replace(',', '', $price);

                            $product = Products::findOne(['vendor_code' => $vendor_code]);
                            if (!isset($product) && empty($product)) {
                                $product = new Products();

                                foreach ($params as $keyParams => $param) {
                                    $names['field_name'][$param] = $name;
                                    $names['field_content'][$param] = $name;
                                    $names['field_keywords'][$param] = $name;
                                    $names['field_description'][$param] = $name;
                                    $brands['field_name'][$param] = $brand;
                                }

                                $brandTranslate = Translations::findOne(['content' => Yii::$app->params['searchBrand']]);
                                $characteristic_id = $brandTranslate->translation_id;
                                if (isset($characteristic_id) && !empty($characteristic_id)) {
                                    $translations = Translations::findOne(['content' => $brand]);
                                    $type = 'characteristics-options';
                                    if (!isset($translations) && empty($translations)) {
                                        $characteristicsOptions = new CharacteristicsOptions();
                                        $characteristicsOptions->characteristics_id = $characteristic_id;
                                        $characteristicsOptions->save();
                                        $result = $this->setTranslation($brands, $characteristicsOptions->id, $type, $paramsCharacteristicsOptions);
                                    }
                                }

                                $product->name = $names['field_name'][$language];
                                $product->category_id = 1;
                                $product->price = str_replace(',', '', $price);
                                $product->vendor_code = $vendor_code;
                                $product->currency_code = 'UAH';
                                $product->status_stock = 1;
                                $product->save();

                                $type = 'products';
                                $translation_id = $product->id;
                                $result = $this->setTranslation($names, $translation_id, $type, $paramsProducts);
                                $characteristicsProducts = CharacteristicsProducts::findOne(['product_id' => $product->id, 'characteristics_options_id' => $characteristicsOptions->id]);
                                if (!isset($characteristicsProducts) && empty($characteristicsProducts)) {
                                    $characteristicsProducts = new CharacteristicsProducts();
                                    $characteristicsProducts->characteristics_options_id = $characteristicsOptions->id;
                                    $characteristicsProducts->product_id = $product->id;
                                    $characteristicsProducts->save();
                                }
                            } else {
                                $product->price = str_replace(',', '', $price);
                                $product->save();

                                $type = 'products';
                                $translation_id = $product->id;
                                $result = $this->setTranslation($names, $translation_id, $type, $paramsProducts);
                            }
                        }
                    }
                }
            }
            $message = '<h3 style="color: green;">Данные обновлены, спасибо за внимание!</h3>';
        }

        return $this->render('excel', [
            'model' => $model,
            'message' => $message
        ]);
    }
}
