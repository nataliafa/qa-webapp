<?php
include 'model/Admin.php';
include 'model/Category.php';
include 'model/Question.php';
include 'model/Status.php';
include 'model/Author.php';

class AdminController
{
  /**
   * Logout
   */
  public function logout()
  {
    if (isset($_POST['logout'])) {
      $admin = new Admin();
      $admin->destroySession();
    }
    header('Location: index.php');
  }

  /**
   * Login
   */
  public function login()
  {
    if (isset($_POST['login']) && isset($_POST['password'])) {

      $admin = new Admin();
      $result = $admin->checkLoginAndPassword($_POST['login'], $_POST['password']);

      if (!empty($result)) {
        $admin->addToSession($result);
        header('Location: index.php?c=admin&a=main');
      } else {
        $message = 'Введен не верный логин или пароль';
        Di::get()->render('index.php', ['message' => $message]);
      }
    } else {
      header('Location: index.php');
    }
  }

  /**
   * Render page with general data
   */
  public function main()
  {
    $admin = new Admin();
    $admin->checkAdminInSession();
    $admins = count($admin->getAdmins());
    $question = new Question();
    $questions = count($question->getQuestionsWithoutAnswer());
    $category = new Category();
    $categories = $category->getCategoriesCountQuantity();
    Di::get()->render('main.php', ['admins' => $admins, 'questions' => $questions, 'categories' => $categories]);
  }

  /**
   * Render page with unanswered questions
   */
  public function questionsWithoutAnswer()
  {
    $admin = new Admin();
    $admin->checkAdminInSession();
    $question = new Question();
    $questions = $question->getQuestionsWithoutAnswer();
    $status = new Status();
    $statuses = $status->getStatuses();
    Di::get()->render('questionsWithoutAnswer.php', ['questions' => $questions, 'statuses' => $statuses]);
  }

  /**
   * Remove a question from the list of topics and pending questions
   */
  public function questionsWithoutAnswerQuestionDelete()
  {
    if (isset($_POST['deleteQuestion']) && isset($_POST['questionId'])) {
      $question = new Question();
      $question->deleteQuestion($_POST['questionId']);
      header('Location: index.php?c=admin&a=questionsWithoutAnswer');
    } else {
      header('Location: index.php');
    }
  }

  /**
   * Change the status of a question on the list of topics and pending questions
   */
  public function questionsWithoutAnswerChangeStatus()
  {
    if (isset($_POST['changeStatus']) && isset($_POST['newStatusId']) && isset($_POST['questionId'])) {
      $question = new Question();
      $question->changeStatus($_POST['newStatusId'], $_POST['questionId']);
      header('Location: index.php?c=admin&a=questionsWithoutAnswer');
    } else {
      header('Location: index.php');
    }
  }

  /**
   * Rendering of the admin list page
   */
  public function adminList()
  {
    $admin = new Admin();
    $admin->checkAdminInSession();
    $admins = $admin->getAdmins();
    Di::get()->render('admins.php', ['admins' => $admins]);
  }

  /**
   * Add an administrator
   */
  public function adminAdd()
  {
    if (isset($_POST['adminAdd'])) {
      if (isset($_POST['login']) && isset($_POST['password'])) {

        $admin = new Admin();
        $result = $admin->checkLogin($_POST['login']);

        if (empty($result)) {
          $admin->addAdmin($_POST['login'], $_POST['password']);
          header('Location: index.php?c=admin&a=adminList');
        } else {
          $message = 'Данный логин занят';
          $admins = $admin->getAdmins();
          Di::get()->render('admins.php', ['admins' => $admins, 'message' => $message]);
        }
      }
    } else {
      header('Location: index.php');
    }
  }

  /**
   * Delete an administrator
   */
  public function adminDelete()
  {
    if (isset($_POST['adminDelete']) && isset($_POST['adminId'])) {
      $admin = new Admin();
      $admin->deleteAdmin($_POST['adminId']);
      header('Location: index.php?c=admin&a=adminList');
    } else {
      header('Location: index.php');
    }
  }

  /**
   * Change administrator password
   */
  public function adminChangePassword()
  {
    if (isset($_POST['changePassword']) && isset($_POST['newPassword'])) {
      $admin = new Admin();
      $admin->changePassword($_POST['newPassword'], $_POST['adminId']);
      header('Location: index.php?c=admin&a=adminList');
    } else {
      header('Location: index.php');
    }
  }

  /**
   * Render page with category list
   */
  public function categoryList()
  {
    $admin = new Admin();
    $admin->checkAdminInSession();
    $category = new Category();
    $categories = $category->getCategoriesCountQuantity();
    Di::get()->render('categoriesAdmin.php', ['categories' => $categories]);
  }

  /**
   * Add a category
   */
  public function categoryAdd()
  {
    if (isset($_POST['categoryAdd']) && isset($_POST['newCategory'])) {
      $category = new Category();
      $result = $category->checkCategory($_POST['newCategory']);

      if (count($result) === 0) {
        $category->addCategory($_POST['newCategory']);
        header('Location: index.php?c=admin&a=categoryList');

      } else {
        $admin = new Admin();
        $admin->checkAdminInSession();
        $category = new Category();
        $categories = $category->getCategoriesCountQuantity();
        $message = 'This topic already exists, please provide a different one';
        Di::get()->render('categoriesAdmin.php', ['categories' => $categories, 'message' => $message]);
      }
    } else {
      header('Location: index.php');
    }
  }

  /**
   * Delete a category with its underlying questions
   */
  public function categoryQuestionsDelete()
  {
    if (isset($_POST['delete']) && isset($_POST['categoryId'])) {
      $question = new Question();
      $question->deleteAllQuestionsByIdCategory($_POST['categoryId']);
      $category = new Category();
      $category->deleteCategory($_POST['categoryId']);
      header('Location: index.php?c=admin&a=categoryList');
    } else {
      header('Location: index.php');
    }
  }

  /**
   * Render page with a list of questions
   */
  public function questionList()
  {
    $admin = new Admin();
    $admin->checkAdminInSession();

    $categoryId = null;
    $categoryName = null;
    $questions = null;
    $statuses = null;
    if (isset($_GET['categoryId'])) {
      $categoryId = $_GET['categoryId'];
      $category = new Category;
      $categoryName = $category->getName($_GET['categoryId']);
      $question = new Question;
      $questions = $question->getQuestionsByIdCategory($_GET['categoryId']);
      $status = new Status;
      $statuses = $status->getStatuses();
    }
    Di::get()->render('questions.php', ['categoryId' => $categoryId, 'categoryName' => $categoryName, 'questions' => $questions, 'statuses' => $statuses]);
  }

  /**
   * Change the status of a question on the question list page
   */
  public function questionChangeStatus()
  {
    if (isset($_POST['changeStatus']) && isset($_POST['newStatusId']) && isset($_POST['categoryId'])) {
      $question = new Question;
      $question->changeStatus($_POST['newStatusId'], $_POST['questionId']);
      header('Location: index.php?c=admin&a=questionList&categoryId=' . $_POST['categoryId']);
    } else {
      header('Location: index.php');
    }
  }

  /**
   * Delete a question on the question list page
   */
  public function questionDelete()
  {
    if (isset($_POST['categoryId']) && isset($_POST['questionId']) && isset($_POST['delete'])) {
      $question = new Question;
      $question->deleteQuestion($_POST['questionId']);
      header('Location: index.php?c=admin&a=questionList&categoryId=' . $_POST['categoryId']);
    } else {
      header('Location: index.php');
    }
  }

  /**
   * Edit a question
   */
  public function questionEdit()
  {
    $admin = new Admin();
    $admin->checkAdminInSession();
    $message = "";

    if (isset($_GET['categoryId']) && isset($_GET['questionId'])) {
      $question = new Question;
      $author = new Author;
      $category = new Category;

      if (isset($_POST['publish'])) {
        // Publish
        $question->publish($_GET['questionId']);
        $message = 'The question is published';
      }

      if (isset($_POST['hide'])) {
        // Hide question
        $question->hide($_GET['questionId']);
        $message = 'Вопрос скрыт';
      }

      if (isset($_POST['newCategory'])) {
        // Change category
        $question->changeCategory($_POST['newCategory'], $_GET['questionId']);
      }

      if (isset($_POST['newAuthorName']) && isset($_POST['authorName'])) {
        // Change the name of the author
        $author->changeAuthorName($_POST['newAuthorName'], $_POST['authorName']);
      }

      if (isset($_POST['newTitle'])) {
        // Change title
        $question->changeTitle($_POST['newTitle'], $_GET['questionId']);
      }

      if (isset($_POST['newContent'])) {
        // Change the content of the question
        $question->changeContent($_POST['newContent'], $_GET['questionId']);
      }

      if (isset($_POST['newAnswer'])) {
        // Change answer
        $question->changeAnswer($_POST['newAnswer'], $_GET['questionId']);
      }

      $question = $question->getQuestionById($_GET['questionId']);
      $categories = $category->getCategories();
      Di::get()->render('questionEdit.php', ['question' => $question, 'categories' => $categories, 'message' => $message]);
    } else {
      header('Location: index.php');
    }
  }
}

?>