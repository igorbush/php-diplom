<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Редактор вопроса</title>
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
			<form action="/admin/update-question" method="POST" class="uk-form uk-margin-top">
				<?php foreach($question as $value): ?>
				<h3 class="uk-placeholder">Редактирование вопроса:<br><?=$value['question'] ?></h3>
				<?php if(isset($_GET['error']) && $_GET['error'] == 'true'): ?>
				<div class="uk-alert-primary uk-width-1-2@s" uk-alert>
		   			<a class="uk-alert-close" uk-close></a>
		    		<p class="uk-padding-small">Публикация на сайте без ответа невозможна</p>
				</div>
				<?php endif ?>
				<input type="hidden" name="id" value="<?=$value['id'] ?>">
				<label class="uk-form-label">Вопрос: </label>
				<div class="uk-width-1-2@s">
					<input type="text" name="question" value="<?=$value['question'] ?>" class="uk-input">
				</div>
				<label class="uk-form-label">Автор: </label>
				<div class="uk-width-1-2@s">
					<input type="text" name="author" value="<?=$value['author'] ?>" class="uk-input">
				</div>
				<label class="uk-form-label">Email: </label>
				<div class="uk-width-1-2@s">
					<input type="text" name="email" value="<?=$value['email'] ?>" class="uk-input">
				</div>
				<label class="uk-form-label">Ответ: </label>
				<div class="uk-width-1-2@s">
				<textarea rows="10" cols="45" name="answer" class="uk-textarea"><?=$value['answer'] ?></textarea>
				</div><br>
				<input type="radio" name="visibility" value="1" class="uk-radio"> Публиковать на сайте  <br><br>
				<input type="radio" name="visibility" value="NULL" class="uk-radio"> Без публикации<br><br>
				<input type="submit" name="update" value="обновить" class="uk-button uk-button-primary">
			<?php endforeach; ?>
			</form>
		</div>
		</div>
	</div>
</body>
</html>