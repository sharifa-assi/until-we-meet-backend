<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $categories = Category::orderBy('cat_name', 'ASC')->get();
            if($categories){
                return response()->json([
                    'data'=> $categories
                ],200);
            }
            return response()->json([
                'category'=>"empty"
            ],404);
        }
        catch(\Exception $e){
            return response()->json([
                'category'=>'internal error'
            ],500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->fill($request->all());//because we used fillable
        if($category->save()){ //returns a boolean
            return response()->json([
                'data'=> $category
            ],200);
        }
        else
        {
            return response()->json([
                'category'=>'category could not be added' 
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if($category)
        {
            return response()->json([
                'data'=> $category
            ],200);
        }
        return response()->json([
            'category'=>'category could not be found' 
        ],500);
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $category = Category::find($id);
        //what is the best way to validate the update request
        if($category){
            $category->update($request->all());//because we used fillable
            if($category->save()){ //returns a boolean
                return response()->json([
                    'data'=> $category
                ],200);
            }
            else
            {
                return response()->json([
                    'category'=>'category could not be updated' 
                ],500);
            }
        }
        return response()->json([
            'category'=>'category could not be found' 
        ],500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = Category::find($id);
        if($category->delete()){ //returns a boolean
            return response()->json([
                'category'=> "good for you"
            ],200);
        }
        else
        {
            return response()->json([
                'category'=>'category could not be deleted' 
            ],500);
        }
    }
}
