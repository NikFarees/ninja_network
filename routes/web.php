<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ninjas', function () {
  $ninjas = [
    ["name" => "mario","skill" => 75, "id" => "1"],
    ["name" => "luigi","skill" => 45, "id" => "2"],
  ];

  return view('ninjas.index', ["greeting" => "hello", "ninjas" => $ninjas]);
});

Route::get('/ninjas/{id}', function ($id) {
  // do something with the id
  // e.g. fetch a record from the db

  return view('ninjas.show', ['id' => $id]);
});
