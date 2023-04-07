<!DOCTYPE html>
<html lang="ja">
	<head>
		<?php require("_head_view.php"); ?>
	</head>
	<body>
		<?php require("_header_view.php"); ?>		
		<main class="container py-4">
			<?php require("_message_view.php"); ?>

			<?php foreach ($images as $image) { ?> <!--降順に画像を貼る-->
				<a href="../app/detail.php?image_id=<?= h($image["id"]); ?>">
					<?php $book = get_book_info($image); ?>
				<?php
					print_r("<pre>");
					print_r($image);
					print_r("</pre>");
					print_r("<pre>");
					print_r($book);
					print_r("</pre>");
				?>
					<?php 
						$count = $average_dao->avgScore($image["id"], 0);
						$evaluation = $average_dao->avgScore($image["id"], 1);
						create_block($book, $count, $evaluation);
					?>
				</a>
			</div>
		<?php };?>
		</main>
		<?php require("_footer_view.php"); ?>
	</body>
</html>