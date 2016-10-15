<?php return array(
"vhodnye-dveri/" => "catalog/index",
"vhodnye-dveri/search" => "catalog/search",
"vhodnye-dveri/<url:([0-9a-z\/_-]+)>/" => "catalog/tree",
"novosti/" => "news/list",
"novosti/<name:([\w-]+)>/" => "news/item",
"" => "site/index",
"contacts" => "site/contacts",
"userlogin" => "client/loginUser",
"cart" => "site/cart",
"cartinfo" => "site/cartinfo",
"<_c:(profile|user|client|profileblog)>" => "<_c>/index",
"<_c:(profile|user|client|profileblog)>/<_a>" => "<_c>/<_a>",
"<_a:(login|logout|register)>" => "user/<_a>",
"<_c>/<_a:(captcha)>/refresh" => "<_c>/<_a>",
"<_c>/<_a:(captcha)>/<v>" => "<_c>/<_a>",
"<url:([0-9a-z\/_-]+)>/" => "site/page",
);
?>