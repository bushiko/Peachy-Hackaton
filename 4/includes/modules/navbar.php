<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="row">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">MixStore</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <?php if(!isset($_SESSION['user_id'])) : ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign In <b class="caret"></b></a>
            <div class="dropdown-menu" style="padding: 15px;">
              <form action="login.php" method="post">
                <input type="hidden" name="action" value="process">
                <input style="margin-bottom: 15px;" type="text" name="login_mail" size="30" placeholder="Email" />
                <input style="margin-bottom: 15px;" type="password" name="login_pass" size="30" placeholder="Password" />
                <input class="btn btn-success" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" name="commit" value="Sign In" />
              </form>
            </div>
          </li>
          <li><a href="signup.php">Signup</a></li>
          <?php else : ?>
          <li><a href="account.php">Mi Cuenta</a></li>
          <li><a href="logout.php">Cerrar Sesi&oacute;n</a></li>
          <?php endif; ?>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.row-->
  </div>
</nav>