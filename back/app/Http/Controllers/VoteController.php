<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vote;

class VoteController extends Controller
{
    public function showAll(){
        $votes = Vote::paginate(2);
        return view('index', ['votes' => $votes]);
    }
    public function create(Request $request){
        $vote = new Vote;
        $vote->title = $request->title;
        $vote->text = $request->text;
        $vote->positive = 0;
        $vote->negative = 0;
        $vote->save();

        return redirect('/');
    }
    public function show($id){
        $vote = Vote::find($id);
        return view('show_vote', $vote);
    }
    public function increasePositive($id){
        $vote = Vote::find($id);
        $vote->positive++;
        $vote->save();
        return back();
    }
    public function increaseNegative($id){
        $vote = Vote::find($id);
        $vote->negative++;
        $vote->save();
        return back();
    }
}