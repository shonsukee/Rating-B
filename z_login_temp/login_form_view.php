<!DOCTYPE html>
<html lang="ja">
<head>
	<?php require("_head_view.php"); ?>
</head>
<body>
	<?php require("_header_view.php");?>
	<main class="container py-4">
		<?php require("_message_view.php"); ?>
		<h2>Sign in</h2>
		<form action="login.php" method="POST">
			<label for="email">メールアドレス</label>
			<input type="email" class="inchar" placeholder="メールアドレス" name="email">
			<?php if (isset($err['email'])) : ?>
				<p><?php echo $err['email']; ?> </p>
				<?php endif; ?>
				
				<label for="password">パスワード</label>
				<input type="password" class="inchar" placeholder="パスワード" name="password">
				<?php if (isset($err['password'])) : ?>
			<p><?php echo $err['password']; ?> </p>
			<?php endif; ?>
			
			<input type="hidden" name="token" value="<?=$token?>">
			<input type="submit" class="submitchar" name="submit" value="サインイン">
		</form>
		<div class="divider-inner">
			新規登録は<a href="../temp/signup_mail.php">こちら</a>
		</div>
	</main>
</body>
</html>