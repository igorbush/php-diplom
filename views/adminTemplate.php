<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	{% block title %}
	{% endblock %}
	<link href="/styles/favicon.png" rel="shortcut icon" type="image/x-icon" />
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
		    <h4 class="uk-padding-small">Добро пожаловать! {{ session_user }}. Сегодня у Вас в системе {{ fullquestions }} вопросов, {{ fullquestions-answers }} из которых неотвечены.</h4>
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
		<div class="uk-width-5-6@s">
			{% block child %}
			{% endblock %}
		</div>
		</div>
	</div>
</body>
</html>