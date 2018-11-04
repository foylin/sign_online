<?php

use think\Route;

Route::resource('protocol/categories', 'protocol/Categories');
Route::resource('protocol/articles', 'protocol/Articles');
Route::resource('protocol/pages', 'protocol/Pages');
Route::resource('protocol/userArticles', 'protocol/UserArticles');

Route::get('protocol/search','protocol/Articles/search');
Route::get('protocol/articles/my', 'protocol/Articles/my');
Route::get('protocol/tags/:id/articles', 'protocol/Tags/articles');
Route::get('protocol/tags', 'protocol/Tags/index');

Route::post('protocol/userArticles/deletes','protocol/UserArticles/deletes');