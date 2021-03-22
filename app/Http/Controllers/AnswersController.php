<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use App\Question;
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
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update',$answer);
        return view('answers.edit',compact('question','answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Question $question, Answer $answer)
    {
        // return 'test';
        $this->authorize('update',$answer);
        $answer->update($request->validate([
            'body' => 'required',
        ]));

        return redirect()->route('questions.show',$question->slug)->with('success','Sucessfully updated answer');
        // $this->authorize('update', $answer);

        // $answer->update($request->validate([
        //     'body' => 'required',
        // ]));

        // return redirect()->route('questions.show', $question->slug)->with('success', 'Your answer has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question,Answer $answer)
    {
        $this->authorize('delete',$answer);
        $answer->delete();
        return redirect('/questions')->with('success','Answer successfully deleted!');
    }

    public function test(Question $question,$answer){
        // $this->question->best_answer_id = $this
        $question->best_answer_id = $answer;
        $question->save();
        return back()->with('success','Updated best answer');
        // return 'test';
    }
}
