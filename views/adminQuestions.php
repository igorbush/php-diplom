{% extends 'adminTemplate.php' %}
{% block title %}
	<title>Вопросы</title>
{% endblock %}
{% block child %}
				<form method="POST" class="uk-form uk-margin-top">
					<select name="category" class="uk-select uk-width-1-4@s">
						<option selected disabled>Выберите категорию</option>
						{% for category in categories %}
							<option value="{{ category.id }}">{{ category.category }}</option>
						{% endfor %}
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
							<td style="width: 27.5%;">Вопрос</td>
							<td style="width: 17.5%;">Автор и дата</td>
							<td style="width: 20%;">Категория</td>
							<td style="width: 15%;">Статус</td>
							<td style="width: 20%;">Операции</td>
						</tr>
						</thead>
						<tbody>
							{% for question in questions %}
							<tr>
								<td style="width: 27.5%;">{{ question.question }}</td>
								<td style="width: 17.5%;"><p>{{ question.author }} ({{ question.email }})</p><p>{{ question.date_added }}</p></td>
								<td style="width: 20%;">
									<p>{{ question.category }}</p>
									<form action="/admin/change-category" method="POST" class="uk-form uk-flex uk-flex-center">
										<input type="hidden" name="id" value="{{ question.id }}">
										<select name="category_id" class="uk-select uk-form-small">
											{% for category in categories %}
											<option value="{{ category.id }}">{{ category.category }}</option>
											{% endfor %}
										</select>
										<button type="submit" name="change" value="сменить" class="uk-button uk-button-primary uk-button-small"><span uk-icon="icon:  check"></span></button>
									</form>
								</td>
								<td style="width: 15%;" class="uk-text-small">
									{% if question.answer is null and question.visibility is null %}
									<p class="uk-text-danger">Ожидает ответа</p><p class="uk-text-danger">(не опубликован)</p>
									{% endif %}
									{% if question.answer and question.visibility is null %}
									<p class="uk-text-warning">Не опубликован</p><p class="uk-text-warning">(отвечен)</p>
									{% endif %}
									{% if question.answer and question.visibility %}
									<p class="uk-text-success">Опубликован</p><p class="uk-text-success">(отвечен)</p>
									{% endif %}
								</td>
								<td style="width: 20%;" class="uk-text-small">
									<p><a href="/admin/delete-question/{{ question.id }}"><span uk-icon="icon: trash"></span> Удалить</a></p>
									<p><a href="/admin/edit-question/{{ question.id }}"><span uk-icon="icon: file-edit"></span> Редактировать</a></p>
									{% if question.answer and question.visibility is null %}
									<p><a href="/admin/visible-question/{{ question.id }}"><span uk-icon="icon: plus-circle"></span> Опубликовать</a></p>
									{% elseif question.answer and question.visibility %}
									<p><a href="/admin/invisible-question/{{ question.id }}"><span uk-icon="icon: minus-circle"></span> Снять с публикации</a></p>
									{% endif %}	
								</td>
							</tr>
							{% endfor %}
						</tbody>
					</table>
			</div>
{% endblock %}