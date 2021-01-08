<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="template/css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,700" rel="stylesheet">
  <title>Ask a question</title>
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
  <section>
    <h2 class="content__title">Ask a question</h2>

    <form action="index.php?c=front&a=sendQuestion" method="post">
      <div class="content__addQuestion-item">
        <span>Name:</span>
        <input class="input" type="text" name="authorName" required/>
      </div>

      <div class="content__addQuestion-item">
        <span>Email:</span>
        <input class="input" type="email" name="email" required/>
      </div>

      <div class="content__addQuestion-item">
        <span>Category:</span>
        <select class="select" name="categoryId">
          <?php foreach ($categories as $category) { ?>
            <option value="<?php echo $category['id'] ?>"><?php echo $category['title'] ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="content__addQuestion-item">
        <span>Title:</span>
        <input class="input" type="text" name="title" required/>
      </div>

      <div class="content__addQuestion-item">
        <p>Content:</p>
        <textarea name="content" required></textarea>
      </div>

      <input class="button-public" type="submit" name="send" value="Submit"/>
    </form>
    <?php if (isset($message)) { ?>
      <h3 class="error"><?php echo $message ?></h3>
    <?php } ?>
  </section>
</main>

</body>
</html>