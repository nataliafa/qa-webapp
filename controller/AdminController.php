<?php
include 'model/Admin.php';
include 'model/Category.php';
include 'model/Question.php';
include 'model/Status.php';
include 'model/Author.php';

class AdminController
{
  public function logout()
  {
    if(isset($_POST['logout'])) {
      $admin = new Admin();
      $admin->destroySession();
    } 
    header('Location: index.php');
  }

  public function login()
  {
    if(isset($_POST['login']) && isset($_POST['password'])) {

      $admin = new Admin();
      $result = $admin->checkLoginAndPass($_POST['login'], $_POST['password']);

      if (!empty($result)) {
        $admin->addToSession($result);
        header('Location: index.php?c=admin&a=listAll');
      } else {
        $message = 'Введен не верный логин или пароль';
        Di::get()->render('index.php');
      }
    } else {
      header('Location: index.php');
    }
  }

  public function listAll()
  {
    if (!isset($_SESSION['login'])) {
      header('Location: index.php');
      exit;
    }
    $category = new Category();
    $question = new Question();
    $status = new Status();
    $categories = $category->getCategoriesCountQuantity();
    $questions = $question->getQuestionsWithoutAnswer();
    $statuses = $status->getStatuses();
    Di::get()->render('listAll.php', ['categories' => $categories,'questions' => $questions, 'statuses' => $statuses]);
  }

  public function listAllQuestionDelete()
  {
    if(isset($_POST['deleteQuestion']) && isset($_POST['questionId'])) {
      $question = new Question();
      $question->deleteQuestion($_POST['questionId']);
      header('Location: index.php?c=admin&a=listAll');
    } else {
      header('Location: index.php');
    }
  }

  public function listAllChangeStatus()
  {
    if(isset($_POST['changeStatus']) && isset($_POST['newStatusId']) && isset($_POST['questionId'])) {
      $question = new Question();
      $question->changeStatus($_POST['newStatusId'], $_POST['questionId']);
      header('Location: index.php?c=admin&a=listAll');
    } else {
      header('Location: index.php');
    }
  }

  public function adminList()
  {
    if (!isset($_SESSION['login'])) {
      header('Location: index.php');
      exit;
    }

    $admin = new Admin();
    $admins = $admin->getAdmins();
    Di::get()->render('admins.php', ['admins' => $admins]);
  }

  public function adminAdd()
  {
    if (isset($_POST['adminAdd'])) {
      if(isset($_POST['login']) && isset($_POST['password'])) {

        $admin = new Admin();
        $result = $admin->checkLogin($_POST['login']);

        if (empty($result)) {
          $admin->addAdmin($_POST['login'], $_POST['password']);
          $message = 'Администратор '.$_POST['login'].' добавлен';
          header('Location: index.php?c=admin&a=adminList');

        } else {
          $message = 'Данный логин занят';
          header('Location: index.php?c=admin&a=adminList');
        }
      }
    } else {
      header('Location: index.php');
    }
  }

  public function adminDelete()
  {
    if(isset($_POST['adminDelete']) && isset($_POST['adminId'])) {
      $admin = new Admin();
      $admin->deleteAdmin($_POST['adminId']);
      $message = 'Администратор удален';
      header('Location: index.php?c=admin&a=adminList');
    } else {
      header('Location: index.php');
    }
  }

  public function adminChangePass()
  {
    if(isset($_POST['changePassword']) && isset($_POST['newPassword'])) {
      if ($_POST['newPassword'] === '') {
        $message = 'Введите новый пароль';
        Di::get()->render('admins.php');
      } else {
        $admin = new Admin();
        $admin->changePass($_POST['newPassword'], $_POST['adminId']);
        header('Location: index.php?c=admin&a=adminList');
      }
    } else {
      header('Location: index.php');
    }
  }

  public function categoryAdd()
  {
    if(isset($_POST['categoryAdd']) && isset($_POST['newCategory'])) {
      $category = new Category();
      $result = $category->checkCategory($_POST['newCategory']);

      if(count($result) === 0) {
        $category->addCategory($_POST['newCategory']);
        $message = 'Категория '.$_POST['newCategory'].' добавлена';
        header('Location: index.php?c=admin&a=listAll');

      } else {
        $message = 'Данная тема уже существует, введите другую';
        header('Location: index.php?c=admin&a=listAll');
      }
    } else {
      header('Location: index.php');
    }
  }

  public function categoryQuestionsDelete()
  {
    if(isset($_POST['delete']) && isset($_POST['categoryId'])) {
      $question = new Question();
      $question->deleteAllQuestionsByIdCategory($_POST['categoryId']);
      $category = new Category();
      $category->deleteCategory($_POST['categoryId']);
      header('Location: index.php?c=admin&a=listAll');
    } else {
      header('Location: index.php');
    }
  }

  public function questionList() {
    if (!isset($_SESSION['login'])) {
      header('Location: index.php');
      exit;
    }

    if(isset($_GET['categoryId'])) {
      $categoryId = $_GET['categoryId'];
      $category = new Category;
      $categoryName = $category->getName($_GET['categoryId']);
      $question = new Question;
      $questions = $question->getQuestionsByIdCategory($_GET['categoryId']);
      $status = new Status;
      $statuses = $status->getStatuses();
    }
    Di::get()->render('questions.php', ['categoryId' => $categoryId,'categoryName' => $categoryName, 'questions' => $questions, 'statuses' => $statuses]);
  }

  public function questionChangeStatus()
  {
    if(isset($_POST['changeStatus']) && isset($_POST['newStatusId']) && isset($_POST['categoryId'])) {
      $question = new Question;
      $question->changeStatus($_POST['newStatusId'], $_POST['questionId']);
      header('Location: index.php?c=admin&a=questionList&categoryId='.$_POST['categoryId']);
    } else {
      header('Location: index.php');
    }
  }

  public function questionDelete()
  {
    if(isset($_POST['categoryId']) && isset($_POST['questionId']) && isset($_POST['delete'])) {
      $question = new Question;
      $question->deleteQuestion($_POST['questionId']);
      header('Location: index.php?c=admin&a=questionList&categoryId='.$_POST['categoryId']);
    } else {
      header('Location: index.php');
    }
  }

  public function questionEdit()
  {
    if (!isset($_SESSION['login'])) {
      header('Location: index.php');
      exit;
    }
   
    if (isset($_GET['categoryId']) && isset($_GET['questionId'])) {
      $question = new Question;
      $author = new Author;
      $category = new Category;

      if(isset($_POST['publish'])) {
        //публикация
        $question->publish($_GET['questionId']);
        $message='Вопрос опубликован';
      } 

      if(isset($_POST['hide'])) {
        // скрыть вопрос
        $question->hide($_GET['questionId']);
        $message='Вопрос скрыт';
      } 

      if(isset($_POST['newCategory'])) {
        // изменить категорию
        $question->changeCategory($_POST['newCategory'],$_GET['questionId']);
      } 
      
      if(isset($_POST['newAuthorName']) && isset($_POST['authorName'])) {
        // изменить имя автора
        $author->changeAuthorName($_POST['newAuthorName'], $_POST['authorName']);
      }

      if(isset($_POST['newTitle'])) {
        // изменить title
        $question->changeTitle($_POST['newTitle'], $_GET['questionId']);
      } 

      if(isset($_POST['newContent'])) {
        // изменить контент вопроса
        $question->changeContent($_POST['newContent'], $_GET['questionId']);
      } 

      if(isset($_POST['newAnswer'])) {
        // изменить ответ
        $question->changeAnswer($_POST['newAnswer'], $_GET['questionId']);
      }

      $question = $question->getQuestionById($_GET['questionId']);
      $categories = $category->getCategories();
      Di::get()->render('questionEdit.php', ['question' => $question,'categories' => $categories]);
    } else {
      print('Нет такого вопороса');
    }
  }
}
?>