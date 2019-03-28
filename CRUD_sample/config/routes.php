<?php
// routes for user.
$route['manage-user']="UserController/ManageUser";
$route['change-status-user/(:num)']="UserController/changeStatusUser/$1";
$route['edit-user/(:num)']="UserController/editUser/$1";
$route['edit-user-post']="UserController/editUserPost";
$route['delete-user/(:num)']="UserController/deleteUser/$1";
$route['add-user']="UserController/addUser";
$route['add-user-post']="UserController/addUserPost";
$route['view-user/(:num)']="UserController/viewUser/$1";
// end of user routes
?>
