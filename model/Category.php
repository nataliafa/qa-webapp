<?php

class Category
{
  // возвращает массив категорий
  public function getCategories() 
  {
    $sth = Di::get()->db()->prepare("SELECT id, title FROM categories");
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // возвращает массив категорий с значением вопросов по каждой категории
  public function getCategoriesCountQuantity()
  {
    $sql = "
    SELECT
      c.id,
      c.title,
    COUNT(q.id) as quantity_q,
    SUM(IF(q.status_id='2', 1,0)) as published_q,
    SUM(IF(q.status_id='1', 1,0)) as waiting_q,
    SUM(IF(q.status_id='3', 1,0)) as hidden_q
    FROM categories c
    LEFT JOIN questions q ON q.category_id=c.id
    GROUP BY c.id
    ";
    $sth = Di::get()->db()->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // возвращает имя категории
  public function getName($categoryId)
  {
    $sth = Di::get()->db()->prepare("SELECT title FROM categories WHERE id = :id LIMIT 1");
    $sth->execute([':id' => $categoryId]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['title'];
  }

  // возвращает результат проверки существания категория 
  public function checkCategory($newCategory)
  {
    $sth = Di::get()->db()->prepare("SELECT title FROM categories WHERE title = :title LIMIT 1");
    $sth->execute([':title' => $newCategory]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  
  // добавляет категорию
  public function addCategory($newCategory)
  {
    $sth = Di::get()->db()->prepare("INSERT INTO categories SET title = :title");
    $sth->execute([':title' => $newCategory]);
  }
  
  // удаляет категорию
  public function deleteCategory($categoryId) 
  {
    $sth = Di::get()->db()->prepare("DELETE categories FROM  categories WHERE categories.id = :category_id ");
    $sth->execute([':category_id' => $categoryId]);
  }
}
?>