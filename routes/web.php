<?php
use App\Models\Meal;
use App\Models\Translation;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', function (Request $request) {
  $meals=Meal::with('categories');
  if ($request->missing('lang')) 
        return 'parameter missing';
  
  $per_page = $request->input('per_page',3);
  $page = $request->input('page',1);
  $category = $request->input('category','1,2,3');
  $tags =$request->input('tags','1,2,3');
  $ingredients = $request->input('ingredients','1,2,3');
  $with =  $request->input('with','ingredients,category,tags');
  $with = explode(',',$with);
  $lang = $request->input('lang');
  $request->input('diff_time');
  
  $meals =filter($category,$tags,$ingredients);
  $meals =add_data($with,$meals);
  return view('meals.index')->with('meals',$meals);
   //dd(add_data($with,$meals));  
});

function filter($cat,$tag,$ingred){
  
  if($cat!='NULL'){
  $cat = explode(',',$cat);
  $meals=
   Meal::whereHas('categories', function ($query) use($cat) {$query->where('id', $cat);});
  }
  if($tag!='NULL'){
  $tag = explode(',',$tag);
  $meals = $meals->orWhereHas('tags', function ($query) use($tag){$query->where('id', $tag);});  
}
  
  if($ingred!='NULL'){
  $ingred = explode(',',$ingred);
  $meals = $meals->whereHas('ingredients', function ($query) use($ingred) {
  $query->where('id', $ingred);});
  }
  dd($meals->get());
  return $meals->get();
}



function add_data($with,$meals){
  $data = array();
  localize('eng',$meals);
  
  foreach($meals as $key=>$meal){
    //dd($meal->categories()->get());
    
    //$model = ['id'=>$meal->id,'title'=>$meal->title,'description'=>$meal->description];
    if(in_array('ingredients',$with)){
      $ing =$meal->ingredients();
      
      localize('eng',$ing);
      //$model['ingredients']=$ing;
      
    }
    if(in_array('tags',$with)){
      $tags =$meal->tags()->get();
      localize('eng',$tags);
     // $model['tags']=$tags;
     
    }
    if(in_array('categories',$with)){
      $cats =$meal->categories()->get();
      localize('eng',$cats);
     // $model['categories']=$cats;
     
    }
      
    
  }
  return $meals;
}

function localize($lang,$models){
  
  if($lang =='eng'){
    foreach($models as $model){
      $translation = Translation::where('slug',$model->slug)->first();
      $model->update(['title'=>$translation->eng_title]);
      //dd(property_exists($model,'description'));
      if(array_key_exists('description', $model->getAttributes()))
      $model->update(['description'=>$translation->eng_description]);
  }
  }
  if($lang =='hr'){
    foreach($models as $model){
      $translation = Translation::where('slug',$model->slug);
      $model->title = $translation->hr_title;
      if(property_exists($model,'description'))
        $model->description = $translation->hr_description;
    }
  }
  
}
