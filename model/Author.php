<?php

class Author 
{
  // возвращает id автора
  public function getAuthorId($authorName, $email)
  {
    $sth = Di::get()->db()->prepare("SELECT id, name, email FROM authors WHERE name = :name AND email = :email LIMIT 1");
    $sth->execute([
      ':name' => $authorName,
      ':email' => $email,
    ]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['id'];
  }

  // изменить имя автора
  public function changeAuthorName($newAuthorName, $authorName)
  {
    $sth = Di::get()->db()->prepare("UPDATE authors SET `name` = :new_name WHERE `name` = :old_name LIMIT 1");
    $sth->execute([
      ":new_name" => $newAuthorName,
      ":old_name" => $authorName,
    ]);
  }

  // добавить автора
  public function addAuthor($authorName, $email)
  {
    $sth = Di::get()->db()->prepare("INSERT INTO authors SET name = :name, email = :email");
    $sth->execute([
      ":name" => $authorName,
      ":email" => $email,
    ]);
  }  
}
?>