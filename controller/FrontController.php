<?php
include 'model/Category.php';
include 'model/Author.php';
include 'model/Question.php';

class FrontController
{
  /**
   * Render index.php page
   */
  public function enter()
  {
    Di::get()->render('index.php');
  }

  /**
   * Render page with categories
   */
  public function categories()
  {
    if (isset($_GET['categoryId'])) {
      $activeCategory = $_GET['categoryId'];
      $category = new Category;
      $categories = $category->getCategories();
      $question = new Question;

      if (isset($_POST['categoryId'])) {
        $activeCategory = $_POST['categoryId'];
        header("Location: index.php?c=front&a=categories&categoryId=$activeCategory");
      }

      if ($activeCategory === 'all') {
        $result = $question->getQuestionsAllFront();
      } else {
        $result = $question->getQuestionsByIdCategoryFront($activeCategory);
      }
      Di::get()->render('categories.php', ['activeCategory' => $activeCategory, 'categories' => $categories, 'result' => $result]);
    }
  }

  /**
   * Rendering of page with question submission form
   */
  public function sendQuestion()
  {
    $message = '';
    if (isset($_POST['send']) && isset($_POST['authorName']) && isset($_POST['email']) && isset($_POST['categoryId']) && isset($_POST['title']) && isset($_POST['content'])) {
      $author = new Author;
      $question = new Question;

      $author->addAuthor($_POST['authorName'], $_POST['email']);
      $authorId = $author->getAuthorId($_POST['authorName'], $_POST['email']);
      $question->addQuestion($_POST['title'], $_POST['categoryId'], $authorId, $_POST['content']);
      $message = 'Your question was submitted';
    }
    $category = new Category;
    $categories = $category->getCategories();
    Di::get()->render('sendQuestion.php', ['categories' => $categories, 'message' => $message]);
  }
}

?>