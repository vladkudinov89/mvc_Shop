<?php

//include_once ROOT . '/models/Category.php';
//include_once ROOT . '/models/Product.php';

class SiteController
{

    public function actionIndex()
    {
        
        $categories = [];
        $categories = Category::getCategoriesList();
        
        $latestProducts = [];
        $latestProducts = Product::getLatestProducts(3);
        
         $recommendedProducts = [];
        $recommendedProducts = Product::getRecommendedProducts();
        //print_r($recommendedProducts);
        
        require_once (ROOT . '/views/site/index.php');
        return true;
    }
    
 

}
