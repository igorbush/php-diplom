<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Категории</title>
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
				<form action="/admin/category-create" method="POST" class="uk-form uk-margin-top">
					<div class="uk-inline">
						<input type="text" name="category" placeholder="название категории" class="uk-input">
					</div>
					<input type="submit" name="create" value="создать категорию" class="uk-button uk-button-primary">
				</form>
				<?php if(isset($_GET['error']) && $_GET['error'] == 'empty'): ?>
				<div class="uk-alert-primary uk-width-1-2@s" uk-alert>
		   			<a class="uk-alert-close" uk-close></a>
		    		<p class="uk-padding-small">Вы не ввели название категории</p>
				</div>
				<?php endif ?>
				<table class="uk-table uk-table-hover uk-table-middle uk-table-divider" style="width: 100%;">
					<thead>
						<tr>
							<td>Наименование</td>
							<td>Колличество вопросов</td>
							<td>Колличество вопросов без ответа</td>
							<td>Колличество опубликованных вопросов</td>
							<td>Удалить категорию</td>
							<td>Переименовать категорию</td>
						</tr>
					</thead>
					<tbody>
						<?php foreach($categories as $category): ?>
						<tr>
							<td><?=$category['category'] ?></td>
							<td><?=$category['count_questions'] ?></td>
							<td><?=$category['count_questions'] - $category['count_answer'] ?></td>
							<td><?=$category['count_visible'] ?></td>
							<td style="width: 15%"><p><a href="/admin/delete-category/<?=$category['id'] ?>"><span uk-icon="icon: trash"></span> Удалить</a></p></td>
							<td style="width: 20%">
								<form action="/admin/rename-category" method="POST" class="uk-form uk-flex uk-flex-center">
									<input type="hidden" name="id" value="<?=$category['id'] ?>">
									<div class="uk-inline">
										<input type="text" name="name" placeholder="новое название" class="uk-input uk-form-small">
									</div>
									<button type="submit" name="change" value="Переименовать" class="uk-button uk-button-primary uk-button-small"><span uk-icon="icon:  check"></span></button>
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