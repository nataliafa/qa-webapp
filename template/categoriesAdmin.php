<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Categories</title>
  <link rel="stylesheet" href="template/css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,700" rel="stylesheet">
</head>
<body>

<section class="menuAdmin">
  <div class="menuAdmin__admin">
    <img src="template/images/admin_logo.png" alt=""/>
    <p class="menuAdmin__admin-name"><?php echo $_SESSION['login'] ?></p>
  </div>
  <a class="menuAdmin__link" href="index.php?c=admin&a=main">Statistics</a>
  <a class="menuAdmin__link" href="index.php?c=admin&a=adminList">Administrators</a>
  <a class="menuAdmin__link menuAdmin__link-active" href="index.php?c=admin&a=categoryList">Categories</a>
  <a class="menuAdmin__link" href="index.php?c=admin&a=questionsWithoutAnswer">Unanswered questions</a>
  <form class="menuAdmin__exit" action="index.php?c=admin&a=logout" method="post">
    <input class="menuAdmin__exit-button" type="submit" name='logout' value="Sign out">
  </form>
</section>

<div class="content">

  <?php if (isset($message)) { ?>
    <h3 class="error"><?php echo $message ?></h3>
  <?php } ?>

  <section class="content__item">
    <h2 class="content__title">Add a category:</h2>
    <div class="content__container">
      <form class="form-add form-content-start" action="index.php?c=admin&a=categoryAdd" method="post">
        <legend class="form-legend">Name:</legend>
        <input class="input" type="text" name="newCategory" required/>
        <input class="button-add" type="submit" name="categoryAdd" value="Add"/>
      </form>
    </div>
  </section>

  <section class="content__item content__line">
    <h2 class="content__title">Categories:</h2>
    <div class="content__container">
      <?php if (count($categories) > 0): ?>
        <table>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th style="white-space: nowrap"># Questions</th>
            <th style="white-space: nowrap"># Published</th>
            <th style="white-space: nowrap"># Unanswered</th>
            <th style="white-space: nowrap"># Hidden</th>
            <th>View all questions</th>
            <th>Delete category and questions</th>
          </tr>
          <?php foreach ($categories as $item): ?>
            <tr>
              <?php foreach ($item as $key => $value): ?>
                <td><span><?php echo $value ?></span></td>
              <?php endforeach; ?>
              <td><a class="content__link" href="index.php?c=admin&a=questionList&categoryId=<?php echo $item['id'] ?>">View</a>
              </td>
              <td>
                <form action="index.php?c=admin&a=categoryQuestionsDelete" method="post">
                  <input type="hidden" name="categoryId" value="<?php echo $item['id'] ?>"/>
                  <input class="button-delete-change button-delete" type="submit" name="delete" value="Delete"/>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      <?php else: ?>
        <p>Категорий нет</p>
      <?php endif; ?>
    </div>
  </section>
</div>
</body>
</html>