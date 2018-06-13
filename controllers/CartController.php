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

        if ($productsInCart) {

            $productsIds = array_keys($productsInCart);
//            print_r($productsIds);

            $products = Product::getProductsByIds($productsIds);

//            print_r($products);

            $totalPrice = Cart::getTotalPrice($products);
        }


        require_once(ROOT . '/views/cart/index.php');

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

    public function actionCheckout()
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $result = false;

        if (isset($_POST['submit'])) {

            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
//            $userEmail = $_POST['userEmail'];
            $userComment = $_POST['userComment'];

            $errors = false;

            if (!User::checkName($userName)) {
                $errors[] = 'Неправильное имя';
            }

//            if (!User::checkEmailExists($userEmail)) {
//                $errors[] = 'Неправильный email';
//            }

            if (!User::checkPhone($userPhone)) {
                $errors[] = 'Неправильный телефон';
            }

            if ($errors == false) {

                $productsInCart = Cart::getProducts();

                if (User::isGuest()) {
                    $userId = 0;
                } else {
                    $userId = User::checkLogged();
                }

                // Сохраняем заказ в БД
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                if ($result) {

                    $adminEmail = 'php.start@mail.ru';
                    $message = 'http://digital-mafia.net/admin/orders';
                    $subject = 'Новый заказ!';
                    mail($adminEmail, $subject, $message);

                    // Очищаем корзину
                    Cart::clear();
                } else {
                    $result = false;
                    $errors1[] = 'Вы уже сделали заказ';
                }

            } else {
                // Форма заполнена корректно? - Нет
                // Итоги: общая стоимость, количество товаров
                $productsInCart = Cart::getProducts();
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
            }

        } else {

            $productInCart = Cart::getProducts();

            if ($productInCart == false) {
                header("Location : /");
            } else {

                $productIds = array_keys($productInCart);
                $products = Product::getProductsByIds($productIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();

                $userName = false;
                $userPhone = false;
                $userComment = false;


                if (User::isGuest()) {

//                $userName = false;
//                $userPhone = false;
//                $userEmail = false;
//                $userComment = false;

                } else {

                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);

                    $userName = $user['name'];
//                $userEmail = $user['email'];
                    $userPhone = '';
                    $userComment = '';


                }
            }


        }

        require_once(ROOT . '/views/cart/checkout.php');
        return true;
    }

}