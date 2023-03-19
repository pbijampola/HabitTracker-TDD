<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitRequests;
use App\Models\Habit;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    public function index()
    {
        $habits = Habit::all();
        return view('habits.index', ['habits' => $habits]);
    }

    // public function store(Request $request){
    //     $validatedData = $request->validate([
    //         'name' => 'required|max:255',
    //         'time_per_day' => 'required|numeric',
    //     ]);

    //     $habit = Habit::create($validatedData);
    // }

    public function store(StoreHabitRequests $request){

        Habit::create([
            'name' => $request->input('name'),
            'time_per_day' => $request->input('time_per_day'),
        ]);
        return redirect('/habits');
    }

    public function update(Request $request, Habit $habit){
        $request->validate([
            'name' => 'required',
            'time_per_day' => 'required|numeric',

        ]);
        $habit= Habit::find($habit->id);
        $habit->name = $request->input('name');
        $habit->time_per_day = $request->input('time_per_day');
        $habit->update();
        return redirect('/habits');
    }

    public function destroy(Habit $habit){
        $habit->delete();
        return redirect('/habits');
    }
}
