<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Administrators</title>
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
  <a class="menuAdmin__link menuAdmin__link-active" href="index.php?c=admin&a=adminList">Administrators</a>
  <a class="menuAdmin__link" href="index.php?c=admin&a=categoryList">Categories</a>
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
    <h2 class="content__title">Add an administrator:</h2>

    <div class="content__container">
      <form class="form-add form-content-space-between" action="index.php?c=admin&a=adminAdd" method="post">
        <legend class="form-legend">Username:</legend>
        <input class="input" type="text" name="login" required/>

        <legend class="form-legend">Password:</legend>
        <input class="input" type="password" name="password" required/>

        <input class="button-add" type="submit" name="adminAdd" value="Add"/>
      </form>
    </div>
  </section>

  <section class="content__item content__line">
    <h2 class="content__title">List of administrators:</h2>
    <div class="content__container">
      <table>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Password</th>
          <th>Change password</th>
          <th>Delete</th>
        </tr>
        <?php foreach ($admins as $admin): ?>
          <tr>
            <?php foreach ($admin as $key => $value): ?>
              <td><span><?php echo $value ?></span></td>
            <?php endforeach; ?>
            <td>
              <form action="index.php?c=admin&a=adminChangePassword" method="post">
                <input type="hidden" name="adminId" value="<?php echo $admin['id'] ?>"/>
                <input class="input" type="text" name="newPassword" placeholder="Enter new password" required/>
                <input class="button-delete-change" type="submit" name="changePassword" value="Change"/>
              </form>
            </td>
            <td>
              <form action="index.php?c=admin&a=adminDelete" method="post">
                <input type="hidden" name="adminId" value="<?php echo $admin['id'] ?>"/>
                <input class="button-delete-change button-delete" type="submit" name="adminDelete" value="Delete"/>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </section>

</div>
</body>
</html>