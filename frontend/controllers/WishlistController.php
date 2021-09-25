<?php
/**
 * name: Vladyslav Gladyr
 * email: wild.savedo@gmail.com
 * site: lockit.com
 * 13.07.2020
 */

namespace frontend\controllers;

use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\wishlist\Wishlist;
use backend\models\wishlist\WishlistItems;
use Yii;
use frontend\controllers\AppController;
use backend\models\products\Products;

class WishlistController extends AppController
{

    public function actionAdd($id)
    {

        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('danger', Yii::t('frontend/flash', 'Please login or register first!'));
            return $this->redirect('/login');
        }


        $product = Products::findOne($id);
        if (empty($product)) {
            return false;
        }


        if (!Yii::$app->request->isAjax) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        //Params
        $language = Yii::$app->language;
        $language_id = Languages::findOne(['code' => $language])->id;
        $content_id = Content::findOne(['content' => 'name'])->id;
        $type_id = $this->getType('products')->id;


        $user_id = Yii::$app->user->id;

        $wishlist = Wishlist::findOne(['user_id' => $user_id]);

        if (!isset($wishlist) && empty($wishlist)) {
            $wishlist = new Wishlist();
        }
        $wishlist->user_id = $user_id;
        $wishlist->save();

        $wishlist_item = WishlistItems::findOne(['wishlist_id' => $wishlist->id, 'product_id' => $product->id]);

        if (empty($wishlist_item)) {
            $wishlist_item = new WishlistItems();
        }

        $product->language_id = $language_id;
        $product->content_id = $content_id;
        $product->type_id = $type_id;

        $wishlist_item->wishlist_id = $wishlist->id;
        $wishlist_item->product_id = $product->id;
        $wishlist_item->name = $product->translation->content;
        $wishlist_item->save();


        $this->layout = false;

        $name = $product->translation->content;
        return $this->render('wishlist-modal', compact('name'));
    }

    public function actionView()
    {

        $this->setMeta( null, null, null,'Магазин | Список пожеланий');

        if (Yii::$app->user->isGuest) {
            return $this->redirect('/login');
        }
        //Params
        $language = Yii::$app->language;
        $language_id = Languages::findOne(['code' => $language])->id;
        $content_id = Content::findOne(['content' => 'name'])->id;
        $type_id = $this->getType('products')->id;

        $user_id = Yii::$app->user->id;

        $wishlist = Wishlist::find()->with('wishlistItems')->where(['user_id' => $user_id])->one();

        return $this->render('view',compact('wishlist','language_id','content_id','type_id'));
    }

    public function actionDeleteItem($id)
    {

        $delete = WishlistItems::findOne($id);
        $delete->delete();

        $user_id = Yii::$app->user->id;

        $wishlist = Wishlist::find()->with('wishlistItems')->where(['user_id' => $user_id])->one();

        return $this->redirect('view');
    }
}