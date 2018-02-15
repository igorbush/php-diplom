<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Главная</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/styles/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<!-- UIkit CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.39/css/uikit.min.css" />

	<!-- UIkit JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.39/js/uikit.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.39/js/uikit-icons.min.js"></script>
</head>
<body class="uk-background-primary uk-padding">
	<div class="uk-container">
		<img src="/styles/logo.png" alt="">
	</div>
	<div class="uk-container uk-background-default uk-padding-small">
		<div class="uk-grid">
			<div class="uk-width-1-4@s">
				<div class="uk-background-muted uk-padding uk-panel uk-margin-bottom">
					{% if session_user %}
						<p>Вы вошли как {{ session_user }}!</p>
						<p><a href="/admin/questions">Перейти в панель администратора</a></p>
						<p><a href="/logout">Выйти</a></p>
					{% else %}
						<a href="/login">войти в админ панель</a>
					{% endif %}
				</div>
				<div class="uk-background-muted uk-padding uk-panel">
					{% for category in categories %}
						<h5><a class="uk-link" href="#{{ category.category }}">{{ category.category }}</a></h5>
					{% endfor %}
				</div>
				<form action="/main/add/" method="POST" class="uk-form uk-padding-small uk-background-muted uk-margin-top">
					<div class="uk-alert-primary" uk-alert>
		   				<a class="uk-alert-close" uk-close></a>
		    			<p>{{ alert }}</p>
					</div>
					<input type="text" name="author" placeholder="Имя" class="uk-input uk-margin-small">
					<input type="text" name="email" placeholder="Эл.Почта" class="uk-input uk-margin-small">
					<select name="category_id" class="uk-select uk-margin-small">
						<option selected disabled>Выбрать категорию</option>
						{% for category in categories %}
							<option value="{{ category.id }}">{{ category.category }}</option>
						{% endfor %}
					</select><br>
					<input type="text" name="question" placeholder="Вопрос" class="uk-input uk-margin-small">
					<input type="submit" name="insertQuestion" value="Отправить" class="uk-button uk-button-primary">
				</form>
			</div>
			<div class="uk-width-3-4@s">
				<div class="uk-alert-primary" uk-alert>
		   			<a class="uk-alert-close" uk-close></a>
		    		<p class="uk-padding-small">Добро Пожаловать! Здесь Вы найдете ответы на любые вопросы по веб-разработке. Если похожего вопроса нет, Вы можете его задать, заполнив форму в левом сайтбаре</p>
				</div>
				{% for key,value in questions %}
					<p class="uk-text-small" id="{{ key }}">{{ key }}</p>
					<ul uk-accordion>
						{% for question in value %}
					    <li>
					        <a class="uk-accordion-title uk-card uk-card-small uk-card-body uk-card-default uk-card-hover" href="#">{{ question.question }}</a>
					        <div class="uk-accordion-content">
					            <p class="uk-padding">{{ question.answer }}</p>
					        </div>
					    </li>
					    {% endfor %}
					</ul>
				{% endfor %}
			</div>
		</div>
	</div>
</body>
</html>