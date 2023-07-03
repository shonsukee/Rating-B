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
			<?php if(isset($csrf_token)){ ?>
				<div class="col-lg-12">
					<h3>Search Book</h3>
					<hr>
				</div>
				<div class="col-1"></div>
				<div class="col-10">
					<form action="../app/post_get.php" method="post" enctype="multipart/form-data">	
						<input type="hidden" name="csrf_token" value="<?= h($csrf_token); ?>" />
						<div class="form-group">
							<label for="title">Title</label>
							<input type="title" class="form-control" maxlength="100" id="title" name="title">
						</div>
						<div class="form-group">
							<label for="author">Author</label>
							<input type="author" class="form-control" maxlength="100" id="author" name="author">
						</div>
						<button type="submit" class="btn btn-primary sign-btn">Send</button>
					</form>
				</div>
				<div class="col-1"></div>
			<?php } else { 
				header("Location: error.php"); 
			} ?>
			</div>
		</main>
		<?php require("_footer_view.php"); ?>
	</body>
</html>
