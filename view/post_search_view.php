<!DOCTYPE html>
<html lang="ja">
	<head>
		<?php require("_head_view.php"); ?>
	</head>
	<body>
		<?php require("_header_view.php"); ?>		
		<main class="container py-4">
			<?php require("_message_view.php"); ?>
			<?php if(isset($csrf_token)){ ?>
				<div class="col-lg-12">
					<h1>Search Book</h1>
					<hr>
				</div>
				<div class="col-lg-12">
					<form action="../app/post_get.php" method="post" enctype="multipart/form-data">	
						<div>
							<h2>Title:</h2>
							<textarea name="bookTitle" id="bookTitle" value maxlength="100" placeholder="Title"></textarea>
						</div>
						<div>
							<h2>Author:</h2>
							<textarea name="author" id="author" value maxlength="100" placeholder="Author"></textarea>
						</div>
						<button type="submit" name="submit" class="btn btn-primary">Send</button>
					</form>
				</div>
			<?php } else { 
				header("Location: error.php"); 
			} ?>
		</main>
		<?php require("_footer_view.php"); ?>
	</body>
</html>
