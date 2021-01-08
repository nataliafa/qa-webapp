<?php

class Question
{
  /**
   * Returns an array of all questions with answers for Front
   * @return array
   */
  public function getQuestionsAllFront(): array
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
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Returns an array of all questions with answers to Id category for Front
   * @param $categoryId
   * @return array
   */
  public function getQuestionsByIdCategoryFront($categoryId): array
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
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Returns an array of unanswered questions
   * @return array
   */
  public function getQuestionsWithoutAnswer(): array
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
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Returns an array of questions by category id
   * @param $categoryId
   * @return array
   */
  public function getQuestionsByIdCategory($categoryId): array
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
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Returns the question with values by its id
   * @param $questionId
   * @return mixed
   */
  public function getQuestionById($questionId): mixed
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

  /**
   * Change the status of the question
   * @param $newStatusId
   * @param $questionId
   */
  public function changeStatus($newStatusId, $questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET status_id = :status_id WHERE id = :id LIMIT 1");
    $sth->execute([
        ":status_id" => $newStatusId,
        ":id" => $questionId
    ]);
  }

  /**
   * Change the category of the question
   * @param $newCategory
   * @param $questionId
   */
  public function changeCategory($newCategory, $questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET category_id = :category_id WHERE id = :id");
    $sth->execute([
        ":category_id" => $newCategory,
        ":id" => $questionId
    ]);
  }

  /**
   * Change the title of the question
   * @param $newTitle
   * @param $questionId
   */
  public function changeTitle($newTitle, $questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET title = :title WHERE id = :id");
    $sth->execute([
        ":title" => $newTitle,
        ":id" => $questionId
    ]);
  }

  /**
   * Change the content of the question
   * @param $newContent
   * @param $questionId
   */
  public function changeContent($newContent, $questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET content = :content WHERE id = :id");
    $sth->execute([
        ":content" => $newContent,
        ":id" => $questionId
    ]);
  }

  /**
   * Change the answer of a question
   * @param $newAnswer
   * @param $questionId
   */
  public function changeAnswer($newAnswer, $questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET answer = :answer WHERE id = :id");
    $sth->execute([
        ":answer" => $newAnswer,
        ":id" => $questionId
    ]);
  }

  /**
   * Add a question
   * @param $title
   * @param $categoryId
   * @param $authorId
   * @param $content
   */
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

  /**
   * Delete a question
   * @param $questionId
   */
  public function deleteQuestion($questionId)
  {
    $sth = Di::get()->db()->prepare("DELETE questions FROM questions WHERE questions.id = :id");
    $sth->execute([':id' => $questionId]);
  }

  /**
   * Delete question all questions by category id
   * @param $categoryId
   */
  public function deleteAllQuestionsByIdCategory($categoryId)
  {
    $sth = Di::get()->db()->prepare("DELETE questions FROM questions WHERE questions.category_id = :category_id");
    $sth->execute([':category_id' => $categoryId]);
  }

  /**
   * Publish a question
   * @param $questionId
   */
  public function publish($questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET status_id = :status_id WHERE id = :id");
    $sth->execute([
        ":status_id" => 2,
        ":id" => $questionId
    ]);
  }

  /**
   * Hide a question
   * @param $questionId
   */
  public function hide($questionId)
  {
    $sth = Di::get()->db()->prepare("UPDATE questions SET status_id = :status_id WHERE id = :id LIMIT 1");
    $sth->execute([
        ":status_id" => 3,
        ":id" => $questionId
    ]);
  }
}