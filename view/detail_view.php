<!DOCTYPE html>
<html lang="ja">
	<head>
		<?php require("_head_view.php"); ?>
	</head>
	<body>
		<?php require("_header_view.php"); ?>		
		<main class="container py-4">
			<?php require("_message_view.php"); ?>
			<?php $book = get_book_info($images); ?>
				<?php 
					$count = $comment_dao->avgScore($images["id"], 0);
					$evaluation = $comment_dao->avgScore($images["id"], 1);
					create_block($book, $count, $evaluation);
				?>
			<p>コメント</p>
			<ul>
				<?php for($i=0; $i<$count; $i++){
					$nickname = $user_dao->getName($comments[$i]["user_id"]); 
					$countStar = 0;
					while($countStar < 5){ ?>
						<div class="<?= $comments[$i]['comment_eva'] > $countStar ? 'star-rating-comment-front' : 'star-rating-back' ?> ">★</div>
						<?php $countStar++;
					}?>
					<?= h($comments[$i]['create_date']);?>
					<?= h($nickname['name']);?>
					<li><?= h($comments[$i]['comment']); ?></li>
				<?php } ?>
			</ul>
			<form action="./post_comment.php?image_id=<?= h($image_id); ?>" method="POST" enctype="multipart/form-data">
				<div class="radio">
					<input type="radio" id="inq1" name="num" value="1"> <label for="inq1">★</label>
					<input type="radio" id="inq2" name="num" value="2"><label for="inq2">★★</label>
					<input type="radio" id="inq3" name="num" value="3" checked><label for="inq3">★★★</label>
					<input type="radio" id="inq4" name="num" value="4"><label for="inq4">★★★★</label>
					<input type="radio" id="inq5" name="num" value="5"><label for="inq5">★★★★★</label>
				</div>
					<textarea name="comment" id="comment" value maxlength="50" placeholder="コメントを入力してください！"></textarea>
				<button type="submit" name="submit">送信</button>
			</form>
		</main>
		<?php require("_footer_view.php"); ?>
	</body>
</html>