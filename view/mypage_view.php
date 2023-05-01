<!DOCTYPE html>
<html lang="ja">
	<head>
		<?php require("_head_view.php"); ?>
	</head>
	<body>
		<?php require("_header_view.php"); ?>
			<main class="container py-4">
				<?php require("_message_view.php"); ?>
				<div class="row mt-3 cen-ptn">
					<div class="col-lg-5 cen-ptn">
						<p><i class="fas fa-sharp fa-solid fa-user-circle fa-9x"></i></p>
					</div>
					<div class="col-lg-7 cen-name">
						<h3><?= h($_SESSION[SESSION_ACCOUNT]["name"]);?></h3>
						<p><?= h($_SESSION[SESSION_ACCOUNT]["mail"]);?></p>
						<p>コメントした本：<?= h(count($images));?>冊</p>
					</div>
				</div>
				<hr>
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