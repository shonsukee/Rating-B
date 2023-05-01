<!DOCTYPE html>
<html lang="ja">
<head>
	<?php require("_head_view.php"); ?>
</head>
<body>
	<?php require("_header_view.php"); ?> 
    <main class="container py-4">
		<?php require("_message_view.php"); ?>
        <div class="row mt-3">
            <div class="col-6">
                <h3>Sign up</h3>
                <hr>
                <form action="signup_post.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?= h($csrf_token); ?>" />
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
					<div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-secondary">Sign up</button>
                </form>
            </div>
        </div>
    </main>
	<?php require("_footer_view.php"); ?>
</body>
</html>