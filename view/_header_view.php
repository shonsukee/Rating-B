<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
			<a href="../app/index.php" class="navbar-brand">
				<img src="../app/img/logo.png" alt="logo" class="logo">
			</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php if (is_sign_in()) { ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= h(get_account_name()) ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="../app/index.php">Home</a>
								<div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../app/mypage.php">My page</a>
								<div class="dropdown-divider"></div> 
                                <a class="dropdown-item" href="../app/post_search.php">Post book</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../app/signout.php">Sign out</a>
                            </div>
                        </li>
                    </ul>
                <?php } else { ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="signin.php" class="btn btn-outline-light">Sign in</a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
</header>