<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">MyContacts</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li <?php if($thispage == 'public_contacts') echo 'class="active"'; ?>>
				<a href="public.php">Public Contacts</a>
			</li>
			
			<?php if(isset($logged_in) && $logged_in){ ?>
				<li>
					<a href="logout.php">Log Out</a>
				</li>
			<?php }
			else { ?>
				<li <?php if($thispage == 'login') echo 'class="active"'; ?>>
					<a href="login.php">Login</a>
				</li>
				<li <?php if($thispage == 'sign_up') echo 'class="active"'; ?>>
					<a href="signup.php">Sign up</a>
				</li>
			<?php } ?>
          </ul>
        </div>
    </div>
</nav>