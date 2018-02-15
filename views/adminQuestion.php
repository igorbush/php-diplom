{% extends 'adminTemplate.php' %}
{% block title %}
	<title>Редактор вопроса</title>
{% endblock %}
{% block child %}
			<form action="/admin/update-question" method="POST" class="uk-form uk-margin-top">
				{% for value in questions %}
				<h3 class="uk-placeholder">Редактирование вопроса:<br>{{ value.question }}</h3>
				{% if error and error == 'true' %}
				<div class="uk-alert-primary uk-width-1-2@s" uk-alert>
		   			<a class="uk-alert-close" uk-close></a>
		    		<p class="uk-padding-small">Публикация на сайте без ответа невозможна</p>
				</div>
				{% endif %}
				<input type="hidden" name="id" value="{{ value.id }}">
				<label class="uk-form-label">Вопрос: </label>
				<div class="uk-width-1-2@s">
					<input type="text" name="question" value="{{ value.question }}" class="uk-input">
				</div>
				<label class="uk-form-label">Автор: </label>
				<div class="uk-width-1-2@s">
					<input type="text" name="author" value="{{ value.author }}" class="uk-input">
				</div>
				<label class="uk-form-label">Email: </label>
				<div class="uk-width-1-2@s">
					<input type="text" name="email" value="{{ value.email }}" class="uk-input">
				</div>
				<label class="uk-form-label">Ответ: </label>
				<div class="uk-width-1-2@s">
				<textarea rows="10" cols="45" name="answer" class="uk-textarea">{{ value.answer }}</textarea>
				</div><br>
				<input type="radio" name="visibility" value="1" class="uk-radio"> Публиковать на сайте  <br><br>
				<input type="radio" name="visibility" value="NULL" class="uk-radio"> Без публикации<br><br>
				<input type="submit" name="update" value="обновить" class="uk-button uk-button-primary">
			{% endfor %}
			</form>
{% endblock %}