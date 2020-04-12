<?php

use App\Category;
use App\User;
use App\Curso;
use App\transaction;
use App\video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0');
    	User::truncate();
    	transaction::truncate();
    	Category::truncate();
    	Curso::truncate();
    	video::truncate();
    	DB::table('category_curso')->truncate();

    	$UserRun = 54;
    	$categoryRun = 15;
    	$cursoRun = 4;
    	$videoRun = 90;
    	$transactionRun = 30;

    	factory(User::class, $UserRun)->create();
    	factory(Category::class, $categoryRun)->create();
    	factory(Curso::class, $cursoRun)->create()->each(
            function ($curso){
                $category = Category::all()->random(mt_rand(1, 5))->pluck('id');
                $curso->categories()->attach($category); 
            });
    	factory(transaction::class, $transactionRun)->create();
    	factory(video::class, $videoRun)->create();

    }
}
