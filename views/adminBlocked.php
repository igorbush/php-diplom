{% extends 'adminTemplate.php' %}
{% block title %}
	<title>Заблокированные вопросы</title>
{% endblock %}
{% block child %}
				{% if error and error == 'empty' %}
				<div class="uk-alert-primary uk-width-1-2@s" uk-alert>
		   			<a class="uk-alert-close" uk-close></a>
		    		<p class="uk-padding-small">Вы не ввели стоп-слово</p>
				</div>
				{% endif %}
				<form action="/admin/add-stop-word" method="POST" class="uk-form uk-margin-top">
					<div class="uk-inline">
						<input type="text" name="stop_word" placeholder="стоп-слово" class="uk-input">
					</div>
					<input type="submit" name="add" value="Добавить стоп-слово" class="uk-button uk-button-primary">
					<p><a download href="/stopsheets/stopwords.txt">Скачать базу вредных слов</a></p>
				</form>
				<div class="uk-overflow-auto">
					<div class="uk-alert-primary" uk-alert>
		   				<a class="uk-alert-close" uk-close></a>
		    			<p class="uk-padding-small">Обращаем внимание! Перед тем, как разблокировать вопрос, убедитесь в том, что он исправлен и не содержит вредных слов. Вы можете отредактировать вопрос, нажав на ссылку "Редактировать" (справа от статуса), после чего производить разблокировку.</p>
					</div>
					<table class="uk-table uk-table-hover uk-table-middle uk-table-divider" style="width: 100%;">
						<thead>
						<tr>
							<td>Вопрос</td>
							<td>Автор и дата</td>
							<td>Категория</td>
							<td>Статус</td>
							<td>Операции</td>
						</tr>
						</thead>
						<tbody>
							{% for question in questions %}
							<tr>
								<td>{{ question.question }}</td>
								<td><p>{{ question.author }} ({{ question.email }})</p><p>{{ question.date_added }}</p></td>
								<td>
									<p>{{ question.category }}</p>
								</td>
								<td class="uk-text-small">
									<p class="uk-text-warning">Заблокирован из-за слов:
									{% for word in question.blockwords %}
									<p>{{ word }}</p>
									{% endfor %}
									</p>
								</td>
								<td class="uk-text-small">
									<p><a href="/admin/delete-blocked-question/{{ question.id }}"><span uk-icon="icon: trash"></span> Удалить</a></p>
									<p><a href="/admin/edit-question/{{ question.id }}"><span uk-icon="icon: file-edit"></span> Редактировать</a></p>
									<p><a href="/admin/unlock-question/{{ question.id }}"><span uk-icon="icon: unlock"></span> Разблокировать</a></p>
								</td>
							</tr>
							{% endfor %}
						</tbody>
					</table>
			</div>
{% endblock %}