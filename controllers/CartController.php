<?php

class CartController
{

    public function actionIndex()
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $productsInCart = false;
        $productsInCart = Cart::getProducts();

//        print_r($productsInCart);

        if($productsInCart){

            $productsIds = array_keys($productsInCart);
//            print_r($productsIds);

            $products = Product::getProductsByIds($productsIds);

//            print_r($products);

            $totalPrice = Cart::getTotalPrice($products);
        }


        require_once (ROOT . '/views/cart/index.php');

        return true;
    }

    public function actionAdd($id)
    {
        Cart::addProduct($id);

        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");

    }

    public function actionAddAjax($id)
    {
        echo Cart::addProduct($id);
        return true;
    }

    public function actionDelete($deleteId)
    {
        Cart::deleteProduct($deleteId);

        header("Location: /cart");
    }

}