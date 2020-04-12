<?php

use App\Category;
use App\Seller;
use App\User;
use App\Curso;
use App\transaction;
use App\video;



$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('11223344'),
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElement([User::user_verificado, User::user_no_verificado]),
        'verification_token'=> $verified == User::user_verificado ? null : User::GenerateToken(),
        'role'=> $faker->randomElement([User::user_admin, User::user_teacher, User::user_student]),
        'img'=>$faker->randomElement([User::img_user])
    ]; 
});

$factory->define(Category::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'codecategory' => $faker->paragraph(1),
        'iconpiker' => $faker->paragraph(1),
        'url_img' => Category::img_category,
        'iconpiker' => $faker->paragraph(1),
    ];
});


$factory->define(Curso::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'status' => $faker->randomElement([Curso::disable, Curso::enable]),
        'quantity' => $faker->numberBetween(1, 10),
        'seller_id' => User::all()->random()->id,
    ];
});

$factory->define(transaction::class, function (Faker\Generator $faker) {
    // $vendedor = Seller::has('curso')->get()->random();
    $comprador = User::all()->random();
    return [
        'quantity' => $faker->numberBetween(1, 10),
        'buyer_id' => User::all()->random()->id,
        'curso_id' => Curso::all()->random()->id
    ];
});
$factory->define(video::class, function (Faker\Generator $faker) {
    
    return [
        'url' => $faker->word,
        'curso_id' => Curso::all()->random()->id
    ];
});