<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Вопросы без ответа</title>
  <link rel="stylesheet" href="template/css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,700" rel="stylesheet">
</head>
<body>

<section class="menuAdmin">
  <div class="menuAdmin__admin">
    <img src="template/i/admin_logo.png" alt=""/>
    <p class="menuAdmin__admin-name"><?php echo $_SESSION['login'] ?></p>
  </div>
  <a class="menuAdmin__link" href="index.php?c=admin&a=main">Statistics</a>
  <a class="menuAdmin__link" href="index.php?c=admin&a=adminList">Administrators</a>
  <a class="menuAdmin__link" href="index.php?c=admin&a=categoryList">Categories</a>
  <a class="menuAdmin__link menuAdmin__link-active" href="index.php?c=admin&a=questionsWithoutAnswer">Unanswered questions</a>
  <form class="menuAdmin__exit" action="index.php?c=admin&a=logout" method="post">
    <input class="menuAdmin__exit-button" type="submit" name='logout' value="Sign out">
  </form>
</section>

<div class="content">

  <?php if (isset($message)) { ?>
    <section class="content__item">
      <h3 class="error"><?php echo $message ?></h3>
    </section>
  <?php } ?>

  <section class="content__item">
    <h2 class="content__title">List of questions without answer:</h2>
    <div class="content__container">
      <?php if (count($questions) > 0): ?>
        <table>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Creation date</th>
            <th>Status</th>
            <th>Change status</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
          <?php foreach ($questions as $question): ?>
            <tr>
              <?php foreach ($question as $key => $value): ?>
                <?php if ($key === 'category_id') {
                  continue;
                } else { ?>
                  <td><span><?php echo $value ?></span></td>
                <?php } ?>
              <?php endforeach; ?>
              <td>
                <form class="form-select" action="index.php?c=admin&a=questionsWithoutAnswerChangeStatus" method="post">
                  <input type="hidden" name="questionId" value="<?php echo $question['id'] ?>"/>
                  <select class="select" name="newStatusId">
                    <?php foreach ($statuses as $status) : ?>
                      <option value="<?php echo $status['id'] ?>"
                              <?php if ($status['status'] === $question['status']) : ?>selected<?php endif ?>><?php echo $status['status'] ?></option>
                    <?php endforeach; ?>
                  </select>
                  <input class="button-delete-change" type="submit" name="changeStatus" value="Change status"/>
                </form>
              </td>
              <td>
                <a class="content__link"
                   href="index.php?c=admin&a=questionEdit&categoryId=<?php echo $question['category_id'] ?>&questionId=<?php echo $question['id'] ?>">Edit</a>
              </td>
              <td>
                <form action="index.php?c=admin&a=questionsWithoutAnswerQuestionDelete" method="post">
                  <input type="hidden" name="questionId" value="<?php echo $question['id'] ?>"/>
                  <input class="button-delete-change button-delete" type="submit" name="deleteQuestion" value="Delete"/>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      <?php else: ?>
        <p>Вопросов нет</p>
      <?php endif; ?>
    </div>
  </section>
</div>
</body>
</html>


