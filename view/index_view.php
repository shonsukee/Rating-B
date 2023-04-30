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
					<div class="col-12">
						<h3>Recommend Books</h3>
						<p>Please click the recommend book!</p>
						<hr>
					</div>
				</div>
				<div class="row">
					<?php foreach ($images as $image) { ?> <!--降順に画像を貼る-->
						<div class="col-lg-3">
							<div class="mb-4 one-book cen-ptn shadow-md">
								<a href="../app/detail.php?image_id=<?= h($image["id"]); ?>">
									<?php 
									$count = $comment_dao->avgScore($image["id"], 0);
									$evaluation = $comment_dao->avgScore($image["id"], 1);
									$book = get_book_info($image); 
									create_block($book, $count, $evaluation);
									?>
								</a>
							</div>
						</div>
					<?php };?>
				</div>
			</main>
		<?php require("_footer_view.php"); ?>
	</body>
</html>