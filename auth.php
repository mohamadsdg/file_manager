<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Mohamad Sadeghi
 * Date: 2019-01-01
 * Time: 11:48 AM
 */


function getHash($str)
{
    $saltStr = '7Learn.cOm';
    $hash = sha1($saltStr . md5($str . $saltStr));
    return $hash;
}
function redirectTo($addr){
    header("Location: $addr");
}
function addUser($username, $password, $displayName, $email)
{
    $db = new PDO("mysql:host=localhost;dbname=7lphp;charset=utf8", 'root', '');
    $statement = $db->prepare("insert into users value (null,?,?,?,?,null)");
    $statement->execute(array(strtolower($username), getHash($password), $displayName, strtolower($email)));
}
function getUser($username, $fields = '*'){
    $db = new PDO("mysql:host=localhost;dbname=7lphp;charset=utf8", 'root', '');
    $statment = $db->prepare("select $fields from users where username=? ;");
    $statment->execute(array($username));
    $customers = $statment->fetchAll(2);
    if (count($customers) > 0) {
        return $customers[0];
    }
    return false;
}

function addCookie($username){
    $now = time();
    $expireD = $now + 60 * 60 * 24 * 7; // 7 day (a week)
    $user = getUser($username);
    $user_id = $user['id'];
    $val_cookie = getHash($user_id);
    setcookie('remember', $val_cookie, $expireD, '/');
    $db = new PDO("mysql:host=localhost;dbname=7lphp;chaset=utf8", "root", "");
    $statement = $db->prepare("update users set remember_token=? where id=?");
    $statement->execute(array($val_cookie, $user_id));
}
function getCookie(){
    $val_cookie = $_COOKIE['remember'];
    $db = new PDO("mysql:host=localhost;dbname=7lphp;chaset=utf8", "root", "");
    $statement = $db->prepare("select * from users where remember_token=?");
    $statement->execute(array($val_cookie));
    $customer = $statement->fetchAll(2);
    doLogin($customer[0]['username'], $customer[0]['password'], false);

    return $customer;
}
function removeCookie(){
    $val_cookie = null;
    $user_id = $_SESSION['user_id'] ;
    $db = new PDO("mysql:host=localhost;dbname=7lphp;chaset=utf8", "root", "");
    $statement = $db->prepare("update users set remember_token=? where id=?");
    $statement->execute(array($val_cookie, $user_id));
    setcookie("remember", $val_cookie, time()-10,"/"); // value ro delet mikonim
    unset ($_COOKIE['remember']); // az nazare code ham kar nakhahad kard age unset konim
}

function doLogin($username, $password, $hasForm = true){
    $user = getUser($username);
    $transformPass = $hasForm ? getHash($password) : $password;

    if ($user and $username == $user['username'] and $transformPass == $user['password']) {
        $_SESSION['login'] = $username;
        $_SESSION['user'] = $user['display_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['userIP'] = $_SERVER['REMOTE_ADDR'];
        echo 'set session';
        //$_SESSION['last_action_time'] = time();

        return true;
    }
    return false;

}
function doLogout(){
    unset($_SESSION['login'], $_SESSION['user'], $_SESSION['email'], $_SESSION['last_action_time'], $_SERVER['REMOTE_ADDR']);
    removeCookie();
    return true;
}

function isLogin()
{
    return (isset($_SESSION['login'])) ?
        true :
        isset($_COOKIE['remember']) ?
            true
            :
            !(true);
}