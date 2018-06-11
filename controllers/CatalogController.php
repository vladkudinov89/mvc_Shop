<?php

//include_once ROOT . '/models/Category.php';
//include_once ROOT . '/models/Product.php';
//include_once ROOT . '/components/Pagination.php';

/**
 * Description of CatalogController
 *
 * @author adminemz
 */
class CatalogController {
     public function actionIndex()
    {
        
        $categories = [];
        $categories = Category::getCategoriesList();
        
        $latestProducts = [];
        $latestProducts = Product::getLatestProducts();
        
        require_once (ROOT . '/views/catalog/index.php');
        return true;
    }
    
    public function actionCategory($categoryID , $page = 1) 
    {
//        echo 'category: ' . $categoryID;
//        echo '<br>Page: ' . $page;
       
        
        
        $categories = [];
        $categories = Category::getCategoriesList();
        
        $categoryProduct = [];
        $categoryProduct = Product::getProductsListByCategory($categoryID , $page);
        
        $total = Product::getTotalProductsInCategory($categoryID);
//         echo '<br>Total: ' . $total;
        
        $pagination = new Pagination($total  , $page , Product::SHOW_PAGINATION, 'page-');
        
       require_once (ROOT . '/views/catalog/category.php');
        
        return TRUE;
        
    }
}
