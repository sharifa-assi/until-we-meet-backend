<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
  //
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
        $profile = new Profile();
        $profile->fill($request->all());//because we used fillable
        
        if($profile->save()){ //returns a boolean
            return response()->json([
                'data'=> $profile
            ],200);
        }
        else
        {
            return response()->json([
                'profile'=>'profile could not be created' 
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
        $profile = Profile::find($id);
        if($profile)
        {
            return response()->json([
                'data'=> $profile
            ],200);
        }
        return response()->json([
            'profile'=>'profile could not be found' 
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
        $profile = Profile::find($id);
        if($profile){
            $profile->update($request->all());//because we used fillable
         
            if($profile->save()){ //returns a boolean
                return response()->json([
                    'data'=> $profile
                ],200);
            }
            else
            {
                return response()->json([
                    'profile'=>'profile could not be updated' 
                ],500);
            }
        }
        return response()->json([
            'profile'=>'profile could not be found' 
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
    }

/**
     * Calculate
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calculate(Request $request,$id)
    { 

    }

}
