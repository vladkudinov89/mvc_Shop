<?php

class Product
{
    
    const SHOW_BY_DEFAULT = 10;
    const SHOW_RECOMMENDED = 3;
    const SHOW_PAGINATION = 3;
    
/**
//     * Returns an array of products
//     */
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT)
    {
        $count = intval($count);
        $db = Db::getConnection();
        $productsList = array();

        $result = $db->query('SELECT * FROM product '
                . 'WHERE status = "1"'
                . 'ORDER BY id DESC '                
                . 'LIMIT ' . $count);

        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            //$productsList[$i]['image'] = $row['image'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $productsList;
    }
    
    public static function getProductsListByCategory($categoryID = false , $page = 1) {
        //print_r($categoryID);
        if($categoryID){
            
            $page = intval($page);
            $offset = ($page - 1) * self::SHOW_PAGINATION;
            
             $db = Db::getConnection();
        $products = array();

        $result = $db->query("SELECT * FROM product WHERE status = '1' AND category_id = '$categoryID' "
                . "ORDER BY id ASC "
                . "LIMIT " .self::SHOW_PAGINATION . " OFFSET " . $offset);

        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            //$products[$i]['image'] = $row['image'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $products;
        }
        
    }
    
    public static function getProductById($id) {
        
        $id = intval($id);

        if ($id) {                        
            $db = Db::getConnection();
            
            $result = $db->query('SELECT * FROM product WHERE id=' . $id);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            
            return $result->fetch();
        }
        
    }
    
    public static function getRecommendedProducts()
    {
        
        $db = Db::getConnection();
        $recommendedProducts = array();
        
        $result = $db->query('SELECT * FROM product '
                . 'WHERE status = "1" AND is_recommended = "1"'
                . 'ORDER BY id DESC ');

        $i = 0;
        while ($row = $result->fetch()) {
            $recommendedProducts[$i]['id'] = $row['id'];
            $recommendedProducts[$i]['name'] = $row['name'];
            //$productsList[$i]['image'] = $row['image'];
            $recommendedProducts[$i]['price'] = $row['price'];
            $recommendedProducts[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $recommendedProducts;
        
        
    }
    
    public static function getTotalProductsInCategory($categoryId) 
    {
        
        $db = Db::getConnection();
        
        $result = $db->query("SELECT count(id) as count FROM product WHERE status = '1' AND category_id = '$categoryId' ");
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        return $row['count'];
        
    }

    public static function getProductsByIds($ids)
    {
        $products = [];

        $db = Db::getConnection();

        $idsString = implode(',' , $ids);

        $sql = "SELECT * FROM product WHERE status='1' AND id IN ($idsString)";

        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;

        while($row = $result->fetch()){
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }

        return $products;

    }

}