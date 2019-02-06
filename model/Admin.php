<?php

class Admin
{
  public function getAdmins() {
    $sth = Di::get()->db()->prepare("SELECT * FROM `admins`");
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  
  public function checkLoginAndPass($login, $password) {
    $sth = Di::get()->db()->prepare("SELECT * FROM admins WHERE login = :login AND password = :password LIMIT 1");
    $sth->execute([
      ':login' => $login,
      ':password' => $password,
    ]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  
  public function checkLogin($login) {
    $sth = Di::get()->db()->prepare("SELECT * FROM admins WHERE login = :login LIMIT 1");
    $sth->execute([
      ':login' => $login,
    ]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function changePass($newPassword, $id) 
  {
    $sth = Di::get()->db()->prepare("UPDATE `admins` SET password= :password WHERE id = :id LIMIT 1");
    $sth->execute([ 
      ":password" => $newPassword,
      ":id" => $id
    ]);
  }
  
  public function addAdmin($login, $password) 
  {
    $sth = Di::get()->db()->prepare("INSERT INTO `admins` SET login = :login, password= :password");
    $sth->execute([
      ':login' => $login,
      ':password' => $password,
    ]);
  }
  
  public function deleteAdmin($id) 
  {
    $sth = Di::get()->db()->prepare("DELETE FROM `admins` WHERE id = :id LIMIT 1");
    $sth->execute([ ":id" => $id]);
  }
  
  public function addToSession($admin)
  {
    $_SESSION['login'] = $admin[0]['login'];
  }
  
  public function destroySession()
  {
    session_destroy();
  }
}
?>