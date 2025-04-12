<?php

namespace App\Http\Controllers\Subjects;

use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;

class SubjectController extends Controller
{
    //=============================================================================
    public function index(){
        $subjects = Subject::with('scores')->get();
        return view('subjects.index', compact('subjects'));
    }
    //=============================================================================
    public function create(){
        return view('subjects.create');
    }
    //=============================================================================
    public function store(SubjectRequest $request){
        try {
            DB::beginTransaction();
            //************************************************************* */
            $subject = Subject::create([
                'name'   => $request->input('name'),
                'active' => $request->input('active', 1),
            ]);
            //*************************************************************
            if ($request->has('scores')) {
                $scores = $request->input('scores', []);
                $sort   = $request->input('sort', []);
                for ($i = 0; $i < count($scores); $i++) {
                    $subject->scores()->create([
                        'score' => $scores[$i] ?? 0,
                        'sort'  => $sort[$i] ?? $i,
                    ]);
                }
            }
            //************************************************************* */
            DB::commit();
            return redirect()->route('home')->with('success', 'Subject created successfully.');
            //************************************************************* */
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Oops!! ,Error occurred while creating subject']);
        }
    }
    //=============================================================================
}