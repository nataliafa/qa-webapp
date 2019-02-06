<?php

class Question 
{
  public function getQuestionsAllFront()
  {
    $sql = "
    SELECT 
      c.title as category,
      a.name as author,
      q.title as title,
      q.content as question,
      q.answer as answer,
      q.date_added as date_added
    FROM questions q
    INNER JOIN categories c
      ON q.category_id=c.id
    INNER JOIN authors a
      ON q.author_id=a.id
    WHERE q.status_id = 2
    ";
    $sth = Di::get()->db()->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function getQuestionsByIdCategoryFront($categoryId) 
  {
    $sql = "
    SELECT 
      c.title as category,
      a.name as author,
      q.title as title,
      q.content as question,
      q.answer as answer,
      q.date_added as date_added
    FROM questions q
    INNER JOIN categories c
      ON q.category_id=c.id
    INNER JOIN authors a
      ON q.author_id=a.id
    WHERE q.status_id = 2 AND q.category_id = :category_id
    ";
    $sth = Di::get()->db()->prepare($sql);
    $sth->execute([
      ":category_id" => $categoryId
    ]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function getQuestionsWithoutAnswer()
  {
    $sth = Di::get()->db()->prepare("
      SELECT 
        q.id as id, 
        q.title as title, 
        q.category_id as category_id,
        с.title as category,
        q.date_added as date_added,
        s.status as status
      FROM questions q
      INNER JOIN statuses s
        ON q.status_id = s.id AND q.status_id='1'
      INNER JOIN categories с
        ON q.category_id = с.id 
        ");
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function getQuestionsByIdCategory($categoryId)
  {
    $sth = Di::get()->db()->prepare("
      SELECT 
        q.id as id, 
        q.title as title, 
        q.date_added as date_added,
        s.status as status
      FROM questions q
      INNER JOIN statuses s
        ON q.status_id = s.id
      WHERE q.category_id = :category_id");
    $sth->execute([':category_id' => $categoryId]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function getQuestionById($questionId)
  {
    $sql = "
    SELECT 
      q.id as id,
      q.date_added as date_added,
      q.category_id as category_id,
      c.title as category,
      q.title as title,
      s.status as status,
      a.name as author_name,
      q.title as title,
      q.content as content,
      q.answer as answer
    FROM questions q
    INNER JOIN categories c
      ON q.category_id=c.id
    INNER JOIN authors a
      ON q.author_id=a.id
    INNER JOIN statuses s
      ON q.status_id=s.id
    WHERE q.id = :id
    ";
    $sth = Di::get()->db()->prepare($sql);
    $sth->execute([
      ':id' => $questionId
    ]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result[0];
  }
  
  public function changeStatus($newStatusId, $questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET status_id = :status_id WHERE id = :id LIMIT 1");
    $sth->execute([
      ":status_id" => $newStatusId,
      ":id" => $questionId
    ]);
  }
  
  public function changeCategory($newCategory, $questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET category_id = :category_id WHERE id = :id LIMIT 1");
    $sth->execute([
      ":category_id" => $newCategory,
      ":id" => $questionId
    ]);
  }
  
  public function changeTitle($newTitle, $questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET title = :title WHERE id = :id LIMIT 1");
    $sth->execute([
      ":title" => $newTitle,
      ":id" => $questionId
    ]);
  }
  
  public function changeContent($newContent, $questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET content = :content WHERE id = :id LIMIT 1");
    $sth->execute([
      ":content" => $newContent,
      ":id" => $questionId
    ]);
  }
  
  public function changeAnswer($newAnswer, $questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET answer = :answer WHERE id = :id LIMIT 1");
    $sth->execute([
      ":answer" => $newAnswer,
      ":id" => $questionId
    ]);
  }
  
  public function addQuestion($title, $categoryId, $authorId, $content)
  {
    $sth = Di::get()->db()->prepare("INSERT INTO questions SET title = :title, category_id = :category_id, author_id = :author_id, content = :content");
    $sth->execute([
      ":title" => $title,
      ":category_id" => $categoryId,
      ":author_id" => $authorId,
      ":content" => $content
    ]);
  }

  public function deleteQuestion($questionId)
  {
    $sth = Di::get()->db()->prepare("DELETE questions FROM questions WHERE questions.id = :id");
    $sth->execute([':id' => $questionId]);
  }

  public function deleteAllQuestionsByIdCategory($categoryId) 
  {
    $sth = Di::get()->db()->prepare("DELETE questions FROM questions WHERE questions.category_id = :category_id");
    $sth->execute([':category_id' => $categoryId]);
  }
  
  public function publish($questionId) {
    $sth = Di::get()->db()->prepare("UPDATE questions SET status_id = :status_id WHERE id = :id LIMIT 1");
    $sth->execute([
      ":status_id" => 2,
      ":id" => $questionId
    ]);
  }
  
  public function hide($questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET status_id = :status_id WHERE id = :id LIMIT 1");
    $sth->execute([
      ":status_id" => 3,
      ":id" => $questionId
    ]);
  } 
}
?>