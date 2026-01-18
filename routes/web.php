<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/about",function(){
    $data = [
        "name" => "nyaganya",
        "age" => 20
    ];
    dump($data);
    return view("about");
});

Route::view(uri:"/contact",view:"contact");

// Route with required parameters
Route::get("/about/{name}",function(string $name){
    return "About {$name}";
});

//Route with optional parameters
Route::get("/products/{category?}",function(string $category = "food"){
    return "Category = $category";
})-> whereAlpha("category");

