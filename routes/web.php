<?php

use App\Models\{
    Curse,
    Module,
    User,
    Preference
};

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/one-to-many', function (){
//   $curse = Curse::create(['name' => 'Curso de Laravel']);
  $curse = Curse::with('modules.lessons')->first();
   echo $curse->name;
   echo '<br>';
   foreach ($curse->modules as $module){
      echo "Modulo  {$module->name} <br>";
      foreach ($module->lessons as $lesson){
        echo "Aula  {$lesson->name} <br>";

     }

   }
  $data = [
     'name' => 'Modulo x2'
  ];


  $curse->modules()->create($data);


//   $curse->modules()->get();
  $modules = $curse->modules;

  dd($modules);
});

Route::get('/one-to-one', function(){
     $user =   User::with('preference')-> find(2);
    //  $preference = $user->preference;

      $data = [
        'background_color' => '#fff',
      ];
       if($user->preference){
        $user->preference->update($data);
       } else{
        // $user->preference()->create($data);
        $preference = new Preference($data);
        $user->preference()->save($preference);
       }

     $user->refresh();
     var_dump($user->preference);
     $user->preference->delete();
     $user->refresh();
     dd($user->preference);
});



Route::get('/', function () {
    return view('welcome');
});
