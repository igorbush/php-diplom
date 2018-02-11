<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Вопросы</title>
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
			<div class="uk-width-1-6@s">
				<ul class="uk-nav uk-nav-default" uk-nav>
					<li class="uk-margin-bottom uk-margin-top"><a href="/admin/questions"><span uk-icon="icon: question"></span> ВОПРОСЫ</a></li>
					<li class="uk-margin-bottom"><a href="/admin/users"><span uk-icon="icon: user"></span> АДМИНИСТРАТОРЫ</a></li>
					<li class="uk-margin-bottom"><a href="/admin/categories"><span uk-icon="icon: tag"></span> КАТЕГОРИИ</a></li>
					<li class="uk-margin-bottom"><a href="/main"><span uk-icon="icon: home"></span> НА ГЛАВНУЮ</a></li>
					<li class="uk-margin-bottom"><a href="/logout">Выйти из  пользователя</a></li>
				</ul>
			</div>
			<div class="uk-width-5-6@s">
				<form method="POST" class="uk-form uk-margin-top">
					<select name="category" class="uk-select uk-width-1-4@s">
						<option selected disabled>Выберите категорию</option>
						<?php foreach($categories as $category): ?>
							<option value="<?= $category['id'] ?>"><?= $category['category'] ?></option>
						<?php endforeach; ?>
					</select>
					<select name="answer" class="uk-select uk-width-1-4@s">
						<option selected disabled>варианты вопросов</option>
						<option value="no">все вопросы</option>
						<option value="yes">неотвеченные вопросы</option>
					</select>
					<input type="submit" name="sort" value="сортировать" class="uk-button uk-button-primary uk-width-1-4@s">
				</form>
				<div class="uk-overflow-auto">
					<table class="uk-table uk-table-hover uk-table-middle uk-table-divider" style="width: 100%;">
						<thead>
						<tr>
							<td style="width: 27.5%%;">Вопрос</td>
							<td style="width: 17.5%;">Автор и дата</td>
							<td style="width: 20%;">Категория</td>
							<td style="width: 15%;">Статус</td>
							<td style="width: 20%;">Операции</td>
						</tr>
						</thead>
						<tbody>
							<?php foreach($questions as $question): ?>
							<tr>
								<td style="width: 27.5%;"><?= $question['question'] ?></td>
								<td style="width: 17.5%;"><p><?= $question['author'] . ' (' . $question['email'] . ')' ?></p><p><?= $question['date_added'] ?></p></td>
								<td style="width: 20%;">
									<p><?= $question['category'] ?></p>
									<form action="/admin/change-category" method="POST" class="uk-form uk-flex uk-flex-center">
										<input type="hidden" name="id" value="<?= $question['id'] ?>">
										<select name="category_id" class="uk-select uk-form-small">
											<?php foreach($categories as $category): ?>
											<option value="<?= $category['id'] ?>"><?= $category['category'] ?></option>
										<?php endforeach; ?>
										</select>
										<button type="submit" name="change" value="сменить" class="uk-button uk-button-primary uk-button-small"><span uk-icon="icon:  check"></span></button>
									</form>
								</td>
								<td style="width: 15%;" class="uk-text-small">
									<?php if(is_null($question['answer']) && is_null($question['visibility'])):?>
									<p class="uk-text-danger">Ожидает ответа</p><p class="uk-text-danger">(не опубликован)</p>
									<?php endif; ?>
									<?php if(!empty($question['answer']) && is_null($question['visibility'])):?>
									<p class="uk-text-warning">Не опубликован</p><p class="uk-text-warning">(отвечен)</p>
									<?php endif; ?>
									<?php if(!empty($question['answer']) && !empty($question['visibility'])): ?>
									<p class="uk-text-success">Опубликован</p><p class="uk-text-success">(отвечен)</p>
									<?php endif; ?>
								</td>
								<td style="width: 20%;" class="uk-text-small">
									<p><a href="/admin/delete-question/<?= $question['id'] ?>"><span uk-icon="icon: trash"></span> Удалить</a></p>
									<p><a href="/admin/edit-question/<?= $question['id'] ?>"><span uk-icon="icon: file-edit"></span> Редактировать</a></p>
									<?php if(is_null($question['visibility']) && !empty($question['answer'])): ?>
									<p><a href="/admin/visible-question/<?= $question['id'] ?>"><span uk-icon="icon: plus-circle"></span> Опубликовать</a></p>
									<?php elseif(!empty($question['visibility']) && !empty($question['answer'])): ?>
									<p><a href="/admin/invisible-question/<?= $question['id'] ?>"><span uk-icon="icon: minus-circle"></span> Снять с публикации</a></p>
									<?php endif; ?>	
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
			</div>
			</div>
		</div>
	</div>
</body>
</html>