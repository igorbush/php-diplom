{% extends 'adminTemplate.php' %}
{% block child %}
				<form action="/admin/category-create" method="POST" class="uk-form uk-margin-top">
					<div class="uk-inline">
						<input type="text" name="category" placeholder="название категории" class="uk-input">
					</div>
					<input type="submit" name="create" value="создать категорию" class="uk-button uk-button-primary">
				</form>
				{% if error and error == 'empty' %}
				<div class="uk-alert-primary uk-width-1-2@s" uk-alert>
		   			<a class="uk-alert-close" uk-close></a>
		    		<p class="uk-padding-small">Вы не ввели название категории</p>
				</div>
				{% endif %}
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
						{% for category in categories %}
						<tr>
							<td>{{ category.category }}</td>
							<td>{{ category.count_questions }}</td>
							<td>{{ category.count_questions-category.count_answer }}</td>
							<td>{{ category.count_visible }}</td>
							<td style="width: 15%"><p><a href="/admin/delete-category/{{ category.id }}"><span uk-icon="icon: trash"></span> Удалить</a></p></td>
							<td style="width: 20%">
								<form action="/admin/rename-category" method="POST" class="uk-form uk-flex uk-flex-center">
									<input type="hidden" name="id" value="{{ category.id }}">
									<div class="uk-inline">
										<input type="text" name="name" placeholder="новое название" class="uk-input uk-form-small">
									</div>
									<button type="submit" name="change" value="Переименовать" class="uk-button uk-button-primary uk-button-small"><span uk-icon="icon:  check"></span></button>
								</form>
							</td>
						</tr>
					{% endfor %}
				</tbody>
				</table>
{% endblock %}