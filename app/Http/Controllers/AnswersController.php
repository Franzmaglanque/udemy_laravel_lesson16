<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use App\Question;
// use Illuminate\Http\Auth;
use Auth;

class AnswersController extends Controller
{
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question,Request $request)
    {
            //LONG APPROACH
        $request->validate([
            'body' => 'required'
        ]);

        $question->answers()->create(['body' => $request->body,'user_id' => Auth::id()]);

            //SHORT APPROACH
            // $question->answer()->create($request->validate([
            //         'body' => 'required'
            //      ]) + ['user_id' => Auth::id()]);
            // $question->answers()->create($request->validate([
            //     'body' => 'required'
            // ]) + ['user_id' => Auth::id()]);



        return back()->with('success','Your answer has been submitted sucessfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}