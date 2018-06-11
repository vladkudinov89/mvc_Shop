<?php
/**
 * Created by PhpStorm.
 * User: adminemz
 * Date: 11.06.2018
 * Time: 8:28
 */

class CabinetController
{

    public function actionIndex()
    {

        $userId = User::checkLogged();

//        echo $userId;

        $user = User::getUserById($userId);

//        print_r($user);

        require_once (ROOT . '/views/cabinet/index.php');

        return true;
    }

    public function actionEdit()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);

        $name = $user['name'];
        $password = $user['password'];

        $result = false;

        if(isset($_POST['submit'])){

            $name = $_POST['name'];
            $password = $_POST['password'];

            $errors = false;

            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            if ($errors == false) {
                $result = User::edit($userId, $name, $password);
            }
        }

        require_once (ROOT . '/views/cabinet/edit.php');

        return true;
    }

}