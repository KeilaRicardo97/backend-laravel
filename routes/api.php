<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['cors']], function () {
    
    Route::resource('mascotas', 'Mascota\MascotaController', ['except' => ['create', 'edit']]);
    
    //Route::resource('cursos.video', 'Video\VideoController', ['only' => ['index']]);
    


});