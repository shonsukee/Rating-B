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
				<div class="col-5">
					<h3>Recommend Book</h3>
					<hr>
				</div>
				<div class="col-7">
					<h3>Comment</h3>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-5">
					<div class="mb-4 mx-5 one-book cen-ptn shadow-md">
						<div>
							<?php 
								$count = $comment_dao->avgScore($image["id"], 0);
								$evaluation = $comment_dao->avgScore($image["id"], 1);
								$book = get_book_info($image); 
								create_block($book, $count, $evaluation);
							?>
						</div>
					</div>
				</div>
				<!-- comment -->
				<div class="col-lg-7">
					<div class="mx-5 comment-box cen-ptn shadow-middle">
						<div>

							<div class="pr-4 pl-2 pt-1 my-4 mx-3 comment-scroll">
								<ul>
									<?php for($i=0; $i<$count; $i++){ ?>
											<div class="mb-5 mt-2">
											<?php 
											$user_name = $user_dao->getName($comments[$i]["user_id"]); 
											$countStar = 0;
											?>
											<div>
												<i class="fas fa-solid fa-user fa-lg rounded-circle"></i>
												<?= h($user_name['name']);?>
											</div>
											<?php
											while($countStar < 5){ ?>
												<div class="<?= $comments[$i]['comment_eva'] > $countStar ? 'star-rating-comment-front' : 'star-rating-back' ?> ">★</div>
												<?php $countStar++;
											}?>
											<?= h($comments[$i]['create_date']);?>
											<li><?= h($comments[$i]['comment']); ?></li>
										</div>
									<?php } ?>
								</ul>
							</div>
							<?php if(isset($csrf_token)){ ?>
								<form action="./post_comment.php?link=<?= h($book->selfLink); ?>" method="POST" enctype="multipart/form-data">
									<div class="radio cen-ptn">
										<input type="radio" id="inq1" name="num" value="1"> <label for="inq1">★</label>
										<input type="radio" id="inq2" name="num" value="2"><label for="inq2">★★</label>
										<input type="radio" id="inq3" name="num" value="3" checked><label for="inq3">★★★</label>
										<input type="radio" id="inq4" name="num" value="4"><label for="inq4">★★★★</label>
										<input type="radio" id="inq5" name="num" value="5"><label for="inq5">★★★★★</label>
									</div>
									<textarea name="comment" id="comment" class="cen-ptn" value maxlength="100" placeholder="コメントを入力してください！"></textarea>
									<button type="submit" name="submit" class="btn btn-primary mb-1 send-btn">送信</button>
								</form>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</main>
		<?php require("_footer_view.php"); ?>
	</body>
</html>