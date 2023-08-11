<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        $this->middleware('auth')->except(['index','show']);
    }

    public function index()
    {
        $categories = Category::all();
        $data['categories'] = $categories;
        return view('categories.index',$data);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => 'required | unique:categories',
        ];
         $validator =  Validator::make($request->all(),$data);

         if($validator->passes()){
            $category = new Category();
            $category->name = $request->name;
            $category->save();

            $request->session()->flash('success','Category created successfully');
            return redirect()->back();
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category) // laravel gets the id of category
    {
        // if(auth()->user()->id !== $category->user->id){
        //     abort(403);
        // }

        $data['category']  = $category;
        return view('categories.edit',$data);  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = [
            'name' => 'required | unique:categories',
        ];
         $validator =  Validator::make($request->all(),$data);

         if($validator->passes()){
            $category->name = $request->name;
            $category->save();

            $request->session()->flash('success','Category updated successfully');
            return redirect()->back();
         }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, Request $request)
    {
        $category->delete();
        $request->session()->flash('success','Category deleted successfully');
        return redirect()->back();

    }
}
