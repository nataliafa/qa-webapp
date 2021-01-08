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

<div class="header__wrapper">
  <header class="header">
    <img src="template/images/logo.png" height="46" width="46" alt="">
    <a class="header__link" href="index.php?c=front&a=categories&categoryId=all">Categories</a>
    <a class="header__link" href="index.php?c=front&a=sendQuestion">Ask a question</a>
    <a class="header__link" href="index.php">Sign in as administrator</a>
  </header>
</div>

<section class="banner">
  <h1 class="banner__title">Q&A</h1>
</section>

<main class="main">
  <form class="categories" action="index.php?c=front&a=categories&categoryId=<?php echo $activeCategory ?>"
        method="post">
    <button class="categories__button" type="submit" name="categoryId" value="all">All categories</button>
    <?php foreach ($categories as $category) { ?>
      <button class="categories__button" type="submit" name="categoryId"
              value="<?php echo $category['id'] ?>"><?php echo $category['title'] ?></button>
    <?php } ?>
  </form>

  <section class="answers">
    <?php if (count($result) > 0) {
      foreach ($result as $item) { ?>
        <div class="answers__item">
          <p class="answers__item-title"><?php echo $item['title'] ?></p>

          <div class="answers__item-tab">
            <div class="answers__item-info">
              <img src="template/images/user_logo.jpg" alt=""/>
              <div class="answers__item-info-container">
                <p class="answers__item-info-date"><?php echo $item['date_added'] ?></p>
                <p class="answers__item-info-name"><?php echo $item['author'] ?></p>
              </div>
            </div>

            <p class="answers__item-question"><?php echo $item['question'] ?></p>
            <div class="answers__item-answer">
              <p class="answers__item-answer-item">Answer:</p>
              <p><?php echo $item['answer'] ?></p>
            </div>
          </div>
        </div>
      <?php }
    } else { ?>
      <p>No questions</p>
    <?php } ?>
  </section>

  <?php $json = json_encode($activeCategory) ?>

  <script type="text/javascript" src="template/js/categories.js"></script>
  <script type="text/javascript">
      const categoryId = JSON.parse('<?php echo $json; ?>');
      const categories = document.querySelector('.categories');
      const buttonsCategories = categories.querySelectorAll('.categories__button');
      const buttonActive = categories.querySelector(`[value = '${categoryId}']`);
      buttonActive.classList.add('categories__button-active');
  </script>
</body>
</html>