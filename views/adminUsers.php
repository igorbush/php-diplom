{% extends 'adminTemplate.php' %}
{% block title %}
	<title>Пользователи</title>
{% endblock %}
{% block child %}
				<form action="/admin/new-admin" method="POST" class="uk-form uk-margin-top">
					<div class="uk-inline">
						<span class="uk-form-icon" uk-icon="icon: user"></span>
						<input type="text" name="login" placeholder="введите имя" class="uk-input">
					</div>
					<div class="uk-inline">
						<span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
						<input type="password" name="password" placeholder="введите пароль" class="uk-input">
					</div>
					<input type="submit" name="newadmin" value="добавить администратора" class="uk-button uk-button-primary">
				</form>
				{% if error %}
				<div class="uk-alert-primary uk-width-2-3@s" uk-alert>
		   			<a class="uk-alert-close" uk-close></a>
		   			{% if error == 'duble' %}
		    			<p class="uk-padding-small">Такой пользователь уже есть</p>
		    		{% elseif error == 'empty' %}
		    			<p class="uk-padding-small">Не все поля введены</p>
		    		{% elseif error == 'wrongpass' %}
		    			<p class="uk-padding-small">старый пароль введен неверно</p>
		    		{% endif %}
				</div>
				{% endif %}
				<table class="uk-table uk-table-hover uk-table-middle uk-table-divider" style="width: 100%;">
					<thead>
						<tr>
							<td>ID</td>
							<td>Имя пользователя</td>
							<td>Удалить</td>
							<td>Cменить пароль</td>
						</tr>
						</thead>
					<tbody>
						{% for admin in admins %}
						<tr>
							<td>{{ admin.id }}</td>
							<td>{{ admin.login }}</td>
							<td>
								<p><a href="/admin/delete-admin/{{ admin.id }}"><span uk-icon="icon: trash"></span> Удалить</a></p>
							</td>
							<td>
								<form action="/admin/change-password" method="POST" class="uk-form">
									<input type="hidden" name="id" value="{{ admin.id }}">
									<input type="hidden" name="login" value="{{ admin.login }}">
									<div class="uk-inline">
										<input type="password" name="old" placeholder="старый пароль" class="uk-input">
									</div>
									<div class="uk-inline">
										<input type="password" name="new" placeholder="новый пароль" class="uk-input">
									</div>
									<input type="submit" name="changepassword" value="сменить пароль" class="uk-button uk-button-primary">
									
								</form>
							</td>
						</tr>
					{% endfor %}
				</tbody>
				</table>
{% endblock %}