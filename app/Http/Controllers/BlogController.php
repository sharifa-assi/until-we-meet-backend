<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $blogs = Blog::with('category')->orderBy('name', 'ASC')->get();
            if($blogs){
                return response()->json([
                    'data'=> $blogs
                ],200);
            }
            return response()->json([
                'blog'=>"empty"
            ],404);
        }
        catch(\Exception $e){
            return response()->json([
                'message'=>'internal error'
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
        $blog = new Blog();
        $blog->fill($request->all());//because we used fillable
        if($image=$request->file('image'))
        {
          $image=$request->image;
            $image->store('public/images/'. $request->category_id);
            $blog->image = $image->hashName();
        }
        if($blog->save()){ //returns a boolean
            return response()->json([
                'data'=> $blog
            ],200);
        }
        else
        {
            return response()->json([
                'blog'=>'blog could not be added' 
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
        $blog = Blog::find($id);
        if($blog)
        {
            return response()->json([
                'data'=> $blog
            ],200);
        }
        return response()->json([
            'blog'=>'blog could not be found' 
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
        $blog = Blog::find($id);
        if($blog){
            $blog->update($request->all());//because we used fillable
            if($image=$request->file('image'))
            {
                
                if($this->imageDelete($blog->image,$blog->category_id)){
                    
                    $image=$request->image;
                    $cat =  is_null($request->category_id)? $blog->category_id: $request->category_id;
                    $image->store('public/images/'. $cat);                    
                    $blog->image = $image->hashName();
                }
                else
                {
                    $image=$request->image;
                    $cat =  is_null($request->category_id)? $blog->category_id: $request->category_id;                   
                    $image->store('public/images/'. $cat);                    
                    $blog->image = $image->hashName();
                }               
            }
            if($blog->save()){ //returns a boolean
                return response()->json([
                    'data'=> $blog
                ],200);
            }
            else
            {
                return response()->json([
                    'blog'=>'blog could not be updated' 
                ],500);
            }
        }
        return response()->json([
            'blog'=>'blog could not be found' 
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
        $blog = Blog::find($id);
        if($blog->delete()){ //returns a boolean
            if($this->imageDelete($blog->image,$blog->category_id)){
                var_dump('got deleted');
            }
            else
            {
                var_dump('didnt delete');
            }
            return response()->json([
                'blog'=> "good for you"
            ],200);
        }
        else
        {
            return response()->json([
                'blog'=>'blog could not be deleted' 
            ],500);
        }
    }
    public function imageDelete($oldImage, $cat_id)
    {
        if(File::exists(public_path('storage/images/'. $cat_id .'/'. $oldImage)))
        {
            File::delete(public_path('storage/images/'. $cat_id . '/' . $oldImage));
            return true;
        }
        else
        {
            return false;
        }
    }
}
