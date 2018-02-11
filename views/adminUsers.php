<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Пользователи</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- UIkit CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.39/css/uikit.min.css" />

	<!-- UIkit JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.39/js/uikit.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.39/js/uikit-icons.min.js"></script>
</head>
<body class="uk-background-primary uk-padding" style="height: auto; min-height: 100vh;">
	<div class="uk-container">
		<img src="/styles/logo.png" alt="">
	</div>
	<div class="uk-container uk-background-default uk-padding-small">
		<div class="uk-alert-primary" uk-alert>
		   	<a class="uk-alert-close" uk-close></a>
		    <h4 class="uk-padding-small">Добро пожаловать! <?=$_SESSION['user']; ?>. Сегодня у Вас в системе <?=$fullquestions ?> вопросов, <?=$fullquestions-$answers ?> из которых неотвечены.</h4>
		</div>
		<div class="uk-grid">
			<div class="uk-width-1-6">
				<ul class="uk-nav uk-nav-default" uk-nav>
					<li class="uk-margin-bottom uk-margin-top"><a href="/admin/questions"><span uk-icon="icon: question"></span> ВОПРОСЫ</a></li>
					<li class="uk-margin-bottom"><a href="/admin/users"><span uk-icon="icon: user"></span> АДМИНИСТРАТОРЫ</a></li>
					<li class="uk-margin-bottom"><a href="/admin/categories"><span uk-icon="icon: tag"></span> КАТЕГОРИИ</a></li>
					<li class="uk-margin-bottom"><a href="/main"><span uk-icon="icon: home"></span> НА ГЛАВНУЮ</a></li>
					<li class="uk-margin-bottom"><a href="/logout">Выйти из  пользователя</a></li>
				</ul>
			</div>
			<div class="uk-width-5-6">
				<form action="/admin/new-admin" method="POST" class="uk-form uk-margin-top">
					<div class="uk-inline">
						<span class="uk-form-icon" uk-icon="icon: user"></span>
						<input type="text" name="login" placeholder="введите имя" class="uk-input">
					</div>
					<div class="uk-inline">
						<span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
						<input type="password" name="password" placeholder="введите пароль" class="uk-input">
					</div>
					<input type="submit" name="newadmin" value="добавить администратора" class="uk-button uk-button-primary">
				</form>
				<?php if(isset($_GET['error'])): ?>
				<div class="uk-alert-primary uk-width-2-3@s" uk-alert>
		   			<a class="uk-alert-close" uk-close></a>
		   			<?php if($_GET['error'] == 'duble'): ?>
		    			<p class="uk-padding-small">Такой пользователь уже есть</p>
		    		<?php elseif($_GET['error'] == 'empty'): ?>
		    			<p class="uk-padding-small">Не все поля введены</p>
		    		<?php elseif($_GET['error'] == 'wrongpass'): ?>
		    			<p class="uk-padding-small">старый пароль введен неверно</p>
		    		<?php endif ?>
				</div>
				<?php endif ?>
				<table class="uk-table uk-table-hover uk-table-middle uk-table-divider" style="width: 100%;">
					<thead>
						<tr>
							<td>ID</td>
							<td>Имя пользователя</td>
							<td>Удалить</td>
							<td>Cменить пароль</td>
						</tr>
						</thead>
					<tbody>
						<?php foreach ($admins as $admin): ?>
						<tr>
							<td><?=$admin['id'] ?></td>
							<td><?=$admin['login'] ?></td>
							<td>
								<p><a href="/admin/delete-admin/<?=$admin['id'] ?>"><span uk-icon="icon: trash"></span> Удалить</a></p>
							</td>
							<td>
								<form action="/admin/change-password" method="POST" class="uk-form">
									<input type="hidden" name="id" value="<?=$admin['id'] ?>">
									<input type="hidden" name="login" value="<?=$admin['login'] ?>">
									<div class="uk-inline">
										<input type="password" name="old" placeholder="старый пароль" class="uk-input">
									</div>
									<div class="uk-inline">
										<input type="password" name="new" placeholder="новый пароль" class="uk-input">
									</div>
									<input type="submit" name="changepassword" value="сменить пароль" class="uk-button uk-button-primary">
									
								</form>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>