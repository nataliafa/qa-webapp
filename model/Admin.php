<?php

class Admin
{
  // возвращает массив администраторов
  public function getAdmins() 
  {
    $sth = Di::get()->db()->prepare("SELECT id, login, password FROM `admins`");
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // возвращает результат проверки есть ли в таблице admins введенный логин и пароль
  public function checkLoginAndPassword($login, $password) 
  {
    $sth = Di::get()->db()->prepare("SELECT id, login, password FROM admins WHERE login = :login AND password = :password LIMIT 1");
    $sth->execute([
      ':login' => $login,
      ':password' => $password,
    ]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  
  // возвращает результат проверки есть ли в таблице admins введенный логин
  public function checkLogin($login) 
  {
    $sth = Di::get()->db()->prepare("SELECT id, login, password FROM admins WHERE login = :login LIMIT 1");
    $sth->execute([
      ':login' => $login,
    ]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // изменить пароль администратора
  public function changePassword($newPassword, $id) 
  {
    $sth = Di::get()->db()->prepare("UPDATE `admins` SET password= :password WHERE id = :id LIMIT 1");
    $sth->execute([ 
      ":password" => $newPassword,
      ":id" => $id
    ]);
  }

  // добавить администратора
  public function addAdmin($login, $password) 
  {
    $sth = Di::get()->db()->prepare("INSERT INTO `admins` SET login = :login, password= :password");
    $sth->execute([
      ':login' => $login,
      ':password' => $password,
    ]);
  }

  // удалить администратора
  public function deleteAdmin($id) 
  {
    $sth = Di::get()->db()->prepare("DELETE FROM `admins` WHERE id = :id LIMIT 1");
    $sth->execute([ ":id" => $id]);
  }

  // добавить в сессию администратора
  public function addToSession($admin)
  {
    $_SESSION['login'] = $admin[0]['login'];
  }

  // закрыть сессию
  public function destroySession()
  {
    session_destroy();
  }

  // проверить есть ли администратор в сессии
  public function checkAdminInSession() 
  {
    if (!isset($_SESSION['login'])) {
      header('Location: index.php');
      exit;
    }
  }
}
?>