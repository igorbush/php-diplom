<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Авторизация</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/styles/favicon.ico" rel="shortcut icon" type="image/x-icon" />
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
		<h3 class="uk-placeholder uk-text-center">Зайти в панель администратора</h3>
		{% if error %}
			<div class="uk-alert-primary uk-width-1-3 uk-margin-auto" uk-alert>
		   		<a class="uk-alert-close" uk-close></a>
		   		{% if error == 'empty' %}
		    	<p class="uk-padding-small">Не все поля введены</p>
		    	{% elseif error == 'wrong' %}
		    	<p class="uk-padding-small">Неверные данные</p>
		    	{% endif %}
			</div>
		{% endif %}
		<form action="/login/check" method="POST" class="uk-form uk-margin-auto uk-text-center">
			<div class="uk-margin uk-text-center">
				<div class="uk-inline uk-margin-auto uk-width-1-3">
	           		<span class="uk-form-icon" uk-icon="icon: user"></span>
					<input type="text" name="login" placeholder="Логин" class="uk-input">
				</div>
			</div>
			<div class="uk-margin uk-text-center">
				<div class="uk-inline uk-width-1-3">
	            	<span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
					<input type="password" name="password" placeholder="Пароль" class="uk-input">
				</div>
			</div>
			<input type="submit" name="checklogin" value="Войти" class="uk-button uk-button-primary uk-margin-auto uk-width-1-4">
		</form>
	</div>
</body>
</html>