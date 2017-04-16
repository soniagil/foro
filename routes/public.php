<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('posts/{post}', [
	'as' => 'posts.show',
	'uses' => 'PostController@show'
])->where('post', '\d+'); // indicamos que el id del post sólo es numérico
// con esto evitamos una posible confusión con la ruta posts/create
// en la que Laravel crea que el id es la palabra "create"
