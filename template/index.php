<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Authorization</title>
  <link rel="stylesheet" href="template/css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,700" rel="stylesheet">
</head>
<body>

<?php if (isset($message)) { ?>
  <p><?php echo $message ?></p>
<?php } ?>

<div class="form__wrapper">
  <section class="form__login">
    <h3 class="form__title">Sign in as administrator</h3>
    <form class="form__form" action="index.php?c=admin&a=login" method="post">
      <legend>Username</legend>
      <input class="input" type="text" name="login" required/>

      <legend>Password</legend>
      <input class="input" type="password" name="password" required/>

      <input class="button-add" type="submit" value="Sign in"/>
    </form>
  </section>

  <section class="form__guest">
    <h3 class="form__title">Or continue as a guest</h3>
    <a class="button-add" href="index.php?c=front&a=categories&categoryId=all">Proceed</a>
  </section>
</div>

</body>
</html>