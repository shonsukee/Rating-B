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
					<img src="<?= h($book->volumeInfo->imageLinks->thumbnail); ?>" alt="画像">
					<p>
						<b>『<?= h($image["book_name"]); ?>』</b><br />
						著者：<?php echo get_author($book); ?>
					</p>
					<div class="average-score mb3">
						<div class="star-rating ml-2">
							<div class="star-rating-front" style="width: <?php echo $average_dao->avgScore($image["id"], 20);?>%" >★★★★★</div>
							<div class="star-rating-back">★★★★★</div>
						</div>
						<div class="average-score-display">
							<?php echo "(" . $average_dao->avgScore($image["id"], 1) . "点)"; ?>
						</div>
						<div class="commentNum">
							<?php echo "コメント:" . $average_dao->avgScore($image["id"], 0) . "件"?>
						</div>
					</div>
				</a>
			</div>
		<?php };?>
		</main>
		<?php require("_footer_view.php"); ?>
	</body>
</html>