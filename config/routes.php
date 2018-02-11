<?php

return array(
	'' => 'main/index',
	'main' => 'main/index',
	'main/add' => 'main/add',
	'login' => 'admin/login',
	'login/check' => 'admin/check',


	'admin/questions' => 'questions/getQuestions',
	'admin/visible-question/([0-9]+)' => 'questions/visibleQuestion/$1',
	'admin/invisible-question/([0-9]+)' => 'questions/invisibleQuestion/$1',
	'admin/delete-question/([0-9]+)' => 'questions/deleteQuestion/$1',
	'admin/change-category' => 'questions/changeCategory',


	'admin/edit-question/([0-9]+)' => 'question/getQuestion/$1',
	'admin/update-question' => 'question/updateQuestion',


	'admin/users' => 'users/users',
	'admin/new-admin' => 'users/addUser',
	'admin/delete-admin/([0-9]+)' => 'users/deleteUser/$1',
	'admin/change-password' => 'users/changePassword',


	'admin/categories' => 'categories/getCategories',
	'admin/category-create' => 'categories/createCategory',
	'admin/delete-category/([0-9]+)' => 'categories/deleteCategory/$1',
	'admin/rename-category' => 'categories/changeCategory',
	'logout' => 'admin/logOut',
)

?>


