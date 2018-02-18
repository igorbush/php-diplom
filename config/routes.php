<?php

return array(
///// главная страница, страница авторизации
	'' => 'main/index',
	'main' => 'main/index',
	'main/add' => 'main/add',
	'login' => 'admin/login',
	'login/check' => 'admin/check',

///// страница с вопросами
	'admin/questions' => 'questions/getQuestions',
	'admin/visible-question/([0-9]+)' => 'questions/visibleQuestion/$1',
	'admin/invisible-question/([0-9]+)' => 'questions/invisibleQuestion/$1',
	'admin/delete-question/([0-9]+)' => 'questions/deleteQuestion/$1',
	'admin/change-category' => 'questions/changeCategory',

///// страница с заблокированными вопросами
	'admin/blocked' => 'questions/getBlockedQuestions',
	'admin/delete-blocked-question/([0-9]+)' => 'questions/deleteBlockedQuestion/$1',
	'admin/unlock-question/([0-9]+)' => 'questions/unlockBlockedQuestion/$1',
	'admin/add-stop-word' => 'questions/addStopWord',

///// страница с редактирование вопроса
	'admin/edit-question/([0-9]+)' => 'question/getQuestion/$1',
	'admin/update-question' => 'question/updateQuestion',

///// страница с операциями над пользователями
	'admin/users' => 'users/users',
	'admin/new-admin' => 'users/addUser',
	'admin/delete-admin/([0-9]+)' => 'users/deleteUser/$1',
	'admin/change-password' => 'users/changePassword',

///// страница с операциями над категориями
	'admin/categories' => 'categories/getCategories',
	'admin/category-create' => 'categories/createCategory',
	'admin/delete-category/([0-9]+)' => 'categories/deleteCategory/$1',
	'admin/rename-category' => 'categories/changeCategory',
	'logout' => 'admin/logOut',
)

?>


