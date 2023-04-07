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
			<img src="<?= h($book->volumeInfo->imageLinks->thumbnail); ?>" alt="画像">
				<p>
					<b>『<?= h($images["book_name"]); ?>』</b><br />
					
					著者：<?php echo get_author($book); ?>
				</p>
				<div class="average-score mb3">
					<div class="star-rating ml-2">
						<div class="star-rating-front" style="width: <?php echo $average_dao->avgScore($image_id, 20); ?>%" >★★★★★</div>
						<div class="star-rating-back">★★★★★</div>
					</div>
					<div class="average-score-display">
						<?= h("(" . $average_dao->avgScore($image_id, 1) . "点)"); ?>
					</div>
				</div>
				<?php 
				$count_comment = count($comments);
				echo "コメント:" . $count_comment . "件"?>
				<button onclick="location.href='./home.php';">戻る</button>
			</div>
			<p>コメント</p>
			<ul>
				<?php for($i=0; $i<$count_comment; $i++){?>
					<!-- 要変更 -->
					<?php for($j=0; $j<$comments[$i]['comment_eva']; $j++){ ?>
							<?php } 
							$count = 0;
							while($count < 5){ ?>
								<div class="<?= $comments[$i]['comment_eva'] > $count ? 'star-rating-comment-front' : 'star-rating-back' ?> ">★</div>
								<?php $count++;
							}?>
					<?= h($comments[$i]['create_date']);?>
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