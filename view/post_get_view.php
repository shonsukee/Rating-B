<!DOCTYPE html>
<html lang="ja">
	<head>
		<?php require("_head_view.php"); ?>
	</head>
	<body>
		<?php require("_header_view.php"); ?>		
		<main class="container py-4">
			<?php require("_message_view.php"); ?>
			<!-- 1件以上取得した書籍情報がある場合 -->
			<?php if($get_count > 0): ?>
				<div class="row">
					<!-- get_count->count()つかって -->
					<?php foreach($books as $book):
						// 画像と著者がある本のみ
						if(isset($book->volumeInfo->imageLinks) && isset($book->volumeInfo->authors)){ ?>
							<div class="col-lg-4">
								<div class="mb-4 one-book cen-ptn shadow-md">
									<a href="../app/post_one.php?link=<?= h($book->selfLink); ?>">
										<?php create_block($book, "", ""); ?>
									</a>
								</div>	
							</div>
						<?php } ?>
					<?php endforeach; ?>
				</div>
			<!-- 書籍情報が取得されていない場合 -->
			<?php else: ?>
				<?php 
				$query = "『  ";
				$query .= $params['intitle'] . "  ";
				$query .= $params['inauthor'] . "  ";
				$query .= "』";
				?>
				<p class="cen-ptn"><?php echo $query . "は見つかりませんでした．"?></p>
			<?php endif; ?>
		</main>
		<?php require("_footer_view.php"); ?>
	</body>
</html>
