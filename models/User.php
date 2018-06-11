<?php

class User
{

    public static function register($name, $email, $password)
    {

        $db = Db::getConnection();

        $sql = 'INSERT INTO user (name, email, password) '
            . 'VALUES (:name, :email, :password)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * Проверяет имя: не меньше, чем 2 символа
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет имя: не меньше, чем 6 символов
     */
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет email
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public static function checkEmailExists($email)
    {

        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    public static function getCountUsersRegistered()
    {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) as count FROM user';
        $stmt = $db->prepare($sql);
        $stmt->execute();

        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }//if
        else {
            print_r($stmt->errorInfo());
            return array();
        }//else
    }

    /**
     * Проверяем существует ли пользователь с заданными $email и $password
     * @param string $email
     * @param string $password
     * @return mixed : ingeger user id or false
     */
    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE email=:email AND password=:password';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);

        $result->execute();

        $user = $result->fetch();

        if ($user) {
            return $user['id'];
        }

        return false;

    }

    public static function auth($userId)
    {

        $_SESSION['user'] = $userId;
    }

    public static function checkLogged()
    {


        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");

    }

    public static function isGuest()
    {

        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    public static function getUserById($userId)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE id=:userId';

        $result = $db->prepare($sql);
        $result->bindParam(':userId', $userId, PDO::PARAM_INT);


        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();

//
//$result->execute();
//        $user = $result->fetch();
//
//        if($user){
//            return $user;
//        }
//
//        return false;
    }

    public static function edit($userId, $name, $password)
    {
        $db = Db::getConnection();
        $sql = "UPDATE user SET name=:name , password=:password WHERE id=:userId";

        $result = $db->prepare($sql);
        $result->bindParam(':userId', $userId, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

}
