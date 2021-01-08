<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Вопросы</title>
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
    <section class="content__item">
      <h3 class="error"><?php echo $message ?></h3>
    </section>
  <?php } ?>

  <section class="content__item">
    <h2 class="content__title"><?php echo $categoryName ?></h2>
    <h2 class="content__title">список вопросов:</h2>
    <div class="content__container">
      <?php if (count($questions) > 0): ?>
        <table>
          <tr>
            <th>ID</th>
            <th>Заголовок вопроса</th>
            <th>Дата добавления</th>
            <th>Статус</th>
            <th>Изменить статус</th>
            <th>Редактирование</th>
            <th>Удаление</th>
          </tr>
          <?php foreach ($questions as $question): ?>
            <tr>
              <?php foreach ($question as $key => $value): ?>
                <td><span><?php echo $value ?></span></td>
              <?php endforeach; ?>
              <td>
                <form class="form-select" action="index.php?c=admin&a=questionChangeStatus" method="post">
                  <input type="hidden" name="categoryId" value="<?php echo $categoryId ?>"/>
                  <input type="hidden" name="questionId" value="<?php echo $question['id'] ?>"/>
                  <select class="select" name="newStatusId">
                    <?php foreach ($statuses as $status) { ?>
                      <option value="<?php echo $status['id'] ?>"
                              <?php if ($status['status'] === $question['status']) : ?>selected<?php endif ?>><?php echo $status['status'] ?></option>
                    <?php } ?>
                  </select>
                  <input class="button-delete-change" type="submit" name="changeStatus" value="Изменить"/>
                </form>
              </td>
              <td><a class="content__link"
                     href="index.php?c=admin&a=questionEdit&categoryId=<?php echo $categoryId ?>&questionId=<?php echo $question['id'] ?>">Редактировать</a>
              </td>
              <td>
                <form action="index.php?c=admin&a=questionDelete" method="post">
                  <input type="hidden" name="categoryId" value="<?php echo $categoryId ?>"/>
                  <input type="hidden" name="questionId" value="<?php echo $question['id'] ?>"/>
                  <input class="button-delete-change" type="submit" name="delete" value="Удалить"/>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      <?php else: ?>
        <p>No questions</p>
      <?php endif; ?>
    </div>
  </section>
</div>
</body>
</html>