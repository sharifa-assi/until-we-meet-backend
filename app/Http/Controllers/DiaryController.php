<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diary;
use File;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $diaries = Diary::with('user')->orderBy('created_at', 'ASC')->get();
            if($diaries){
                return response()->json([
                    'data'=> $diaries
                ],200);
            }
            return response()->json([
                'diary'=>"empty"
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


       // var_dump($request);
        $diary = new Diary();
        $diary->fill($request->all());//because we used fillable
        $diary->user_id = auth('api')->id();
        if($image=$request->file('image'))
        {
          $image=$request->image;
            $image->store('public/images/'. auth('api')->id());
            $diary->image = $image->hashName();
        }
        if($diary->save()){ //returns a boolean
            return response()->json([
                'data'=> $diary
            ],200);
        }
        else
        {
            return response()->json([
                'diary'=>'diary could not be added' 
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
        $diary = Diary::find($id);
        if($diary)
        {
            return response()->json([
                'data'=> $diary
            ],200);
        }
        return response()->json([
            'diary'=>'diary could not be found' 
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
        $diary = Diary::find($id);
        if($diary){
            $diary->update($request->all());//because we used fillable
            if($image=$request->file('image'))
            {
                
                if($this->imageDelete($diary->image,$diary->user_id)){
                    
                    $image=$request->image;
                    $user =  is_null($request->user_id)? $diary->user_id: $request->user_id;
                    $image->store('public/images/'. $user);                    
                    $diary->image = $image->hashName();
                }
                else
                {
                    $image=$request->image;
                    $user =  is_null($request->user_id)? $diary->user_id: $request->user_id;                   
                    $image->store('public/images/'. $user);                    
                    $diary->image = $image->hashName();
                }               
            }
            if($diary->save()){ //returns a boolean
                return response()->json([
                    'data'=> $diary
                ],200);
            }
            else
            {
                return response()->json([
                    'diary'=>'diary could not be updated' 
                ],500);
            }
        }
        return response()->json([
            'diary'=>'diary could not be found' 
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
        $diary = Diary::find($id);
        if($diary->delete()){ //returns a boolean
            if($this->imageDelete($diary->image,$diary->user_id)){
                var_dump('got deleted');
            }
            else
            {
                var_dump('didnt delete');
            }
            return response()->json([
                'diary'=> "good for you"
            ],200);
        }
        else
        {
            return response()->json([
                'diary'=>'diary could not be deleted' 
            ],500);
        }
    }
    public function imageDelete($oldImage, $user_id)
    {
        if(File::exists(public_path('storage/images/'. $user_id .'/'. $oldImage)))
        {
            File::delete(public_path('storage/images/'. $user_id . '/' . $oldImage));
            return true;
        }
        else
        {
            return false;
        }
    }
}
