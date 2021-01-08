<?php

class Admin
{
  /**
   * Returns an array of administrators
   * @return array
   */
  public function getAdmins(): array
  {
    $sth = Di::get()->db()->prepare("SELECT id, login, password FROM `admins`");
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Returns the result of checking if the username and password entered is in the admins table
   * @param $login
   * @param $password
   * @return array
   */
  public function checkLoginAndPassword($login, $password): array
  {
    $sth = Di::get()->db()->prepare("SELECT id, login, password FROM admins WHERE login = :login AND password = :password LIMIT 1");
    $sth->execute([
        ':login' => $login,
        ':password' => $password,
    ]);
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Returns the result of checking if the entered login is in the admins table
   * @param $login
   * @return array
   */
  public function checkLogin($login): array
  {
    $sth = Di::get()->db()->prepare("SELECT id, login, password FROM admins WHERE login = :login LIMIT 1");
    $sth->execute([
        ':login' => $login,
    ]);
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Change the administrator's password
   * @param $newPassword
   * @param $id
   */
  public function changePassword($newPassword, $id)
  {
    $sth = Di::get()->db()->prepare("UPDATE `admins` SET password= :password WHERE id = :id LIMIT 1");
    $sth->execute([
        ":password" => $newPassword,
        ":id" => $id
    ]);
  }

  /**
   * Add an administrator
   * @param $login
   * @param $password
   */
  public function addAdmin($login, $password)
  {
    $sth = Di::get()->db()->prepare("INSERT INTO `admins` SET login = :login, password= :password");
    $sth->execute([
        ':login' => $login,
        ':password' => $password,
    ]);
  }

  /**
   * Delete an administrator by ID
   * @param $id
   */
  public function deleteAdmin($id)
  {
    $sth = Di::get()->db()->prepare("DELETE FROM `admins` WHERE id = :id LIMIT 1");
    $sth->execute([":id" => $id]);
  }

  /**
   * Add to the admin session
   * @param $admin
   */
  public function addToSession($admin)
  {
    $_SESSION['login'] = $admin[0]['login'];
  }

  /**
   * Close session
   */
  public function destroySession()
  {
    session_destroy();
  }

  /**
   * Check if there is an administrator in the session
   */
  public function checkAdminInSession()
  {
    if (!isset($_SESSION['login'])) {
      header('Location: index.php');
      exit;
    }
  }
}