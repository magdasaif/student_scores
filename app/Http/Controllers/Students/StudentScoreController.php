<?php

namespace App\Http\Controllers\Students;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StudentScoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Services\StudentDataProcess;

class StudentScoreController extends Controller
{
    protected $processData;
    //=============================================================================
    public function __construct(StudentDataProcess $processData){
        $this->processData = $processData;
    }
    //=============================================================================
    public function uploadScores(){
        //return to upload csv form blade
        return view('students.scores');
    }
    //=============================================================================
    public function csvTemplate(){
        return view('students.scores_template');
    }
    //=============================================================================
    public function processScores(StudentScoreRequest $request){        
        try {
            DB::beginTransaction();
            //************************************************************* */
            // start to process csv file data
            // Store the uploaded file temporary in storage to be used later
            $path = $request->file('file')->store('temp');
            
            // handle reformatting of the CSV data in external service
            $jsonData = $this->processData->processData($path);
            
            // Clean up the temporary file to save disk space
            Storage::delete($path);
            //************************************************************* */
            DB::commit();
            return response()->json($jsonData);
            //************************************************************* */
            // return redirect()->back()->with(['success'=>'Data processed successfully','data'=>json_encode($jsonData)]);
        } catch (\Exception $e) {
            // Make sure to clean up if there's an error
            if (isset($path)) {
                Storage::delete($path);
            }            
            DB::rollBack();
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back()->withErrors(['Oops!! ,Please make sure you choose correct file format with correct heading , you can download template and use it']);
        }
    }
    //=============================================================================
}