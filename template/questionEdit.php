<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Редактировать вопрос</title>
  <link rel="stylesheet" href="template/css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,700" rel="stylesheet">
</head>
<body>
<section class="menuAdmin">
  <div class="menuAdmin__admin">
    <img src="template/images/admin_logo.png" alt=""/>
    <p class="menuAdmin__admin-name"><?php echo $_SESSION['login'] ?></p>
  </div>
  <a class="menuAdmin__link" href="index.php?c=admin&a=main">Общее</a>
  <a class="menuAdmin__link" href="index.php?c=admin&a=adminList">Администраторы</a>
  <a class="menuAdmin__link" href="index.php?c=admin&a=categoryList">Категории</a>
  <a class="menuAdmin__link" href="index.php?c=admin&a=questionsWithoutAnswer">Вопросы без ответа</a>
  <form class="menuAdmin__exit" action="index.php?c=admin&a=logout" method="post">
    <input class="menuAdmin__exit-button" type="submit" name='logout' value="Выйти">
  </form>
</section>

<div class="content">
  <?php if (isset($message)) { ?>
    <h3 class="error"><?php echo $message ?></h3>
  <?php } ?>

  <section class="content__item">
    <h2 class="content__title">Редактирование вопроса:</h2>
    <div class="content__question">
      <p class="content__question-item">ID Вопроса: <?php echo $question['id'] ?></p>
      <p class="content__question-item">Дата и время добавления: <?php echo $question['date_added'] ?></p>

      <form
          action="index.php?c=admin&a=questionEdit&categoryId=<?php echo $question['category_id'] ?>&questionId=<?php echo $question['id'] ?>"
          method="POST">
        <span class="content__question-item">Категория:</span>
        <select class="select" name="newCategory">
          <?php foreach ($categories as $category) { ?>
            <option value="<?php echo $category['id'] ?>"
                    <?php if ($category['title'] === $question['category']) : ?>selected<?php endif ?>><?php echo $category['title'] ?></option>
          <?php } ?>
        </select>

        <p class="content__question-item">Статус: <?php echo $question['status'] ?></p>

        <div class="content__question-item">
          <span>Автор: </span>
          <input type="hidden" name="authorName" value="<?php echo $question['author_name'] ?>"/>
          <input class="input" type="text" name="newAuthorName" value="<?php echo $question['author_name'] ?>"/>
        </div>

        <span class="content__question-item">Заголовок вопроса:</span>
        <input class="input" type="text" name="newTitle" value="<?php echo $question['title'] ?>"/>

        <p class="content__question-item">Контент вопроса:</p>
        <textarea name="newContent"><?php echo $question['content'] ?></textarea>

        <p class="content__question-item">Ответ на вопрос:</p>
        <textarea name="newAnswer"><?php echo $question['answer'] ?></textarea>

        <div class="content__question-item">
          <input class="button-public" type="submit" name="publish" value="Опубликовать"/>
          <input class="button-hide" type="submit" name="hide" value="Скрыть"/>
        </div>
      </form>
    </div>
  </section>

</div>
</body>
</html>