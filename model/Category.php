<?php

class Category
{
  /**
   * Returns an array of categories
   * @return array
   */
  public function getCategories(): array
  {
    $sth = Di::get()->db()->prepare("SELECT id, title FROM categories");
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Returns an array of categories with the value of the questions in each category
   * @return array
   */
  public function getCategoriesCountQuantity(): array
  {
    $sql = "
    SELECT
      c.id,
      c.title,
    COUNT(q.id) as quantity_q,
    SUM(CASE WHEN q.status_id='2' THEN 1 ELSE 0 END) as published_q,
    SUM(CASE WHEN q.status_id='1' THEN 1 ELSE 0 END) as waiting_q,
    SUM(CASE WHEN q.status_id='3' THEN 1 ELSE 0 END) as hidden_q
    FROM categories c
    LEFT JOIN questions q ON q.category_id=c.id
    GROUP BY c.id
    ";
    $sth = Di::get()->db()->prepare($sql);
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Returns the category name
   * @param $categoryId
   * @return mixed
   */
  public function getName($categoryId)
  {
    $sth = Di::get()->db()->prepare("SELECT title FROM categories WHERE id = :id LIMIT 1");
    $sth->execute([':id' => $categoryId]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['title'];
  }

  /**
   * Returns the result of a category existence check
   * @param $newCategory
   * @return array
   */
  public function checkCategory($newCategory): array
  {
    $sth = Di::get()->db()->prepare("SELECT title FROM categories WHERE title = :title LIMIT 1");
    $sth->execute([':title' => $newCategory]);
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Adds a category
   * @param $newCategory
   */
  public function addCategory($newCategory)
  {
    $sth = Di::get()->db()->prepare("INSERT INTO categories SET title = :title");
    $sth->execute([':title' => $newCategory]);
  }

  /**
   * Deletes a category
   * @param $categoryId
   */
  public function deleteCategory($categoryId)
  {
    $sth = Di::get()->db()->prepare("DELETE categories FROM  categories WHERE categories.id = :category_id ");
    $sth->execute([':category_id' => $categoryId]);
  }
}