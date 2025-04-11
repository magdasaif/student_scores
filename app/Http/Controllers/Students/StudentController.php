<?php

namespace App\Http\Controllers\Students;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StudentScore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Services\StudentScoreTransformer;

class StudentController extends Controller
{
    protected $transformer;
    //======================================================
    public function __construct(StudentScoreTransformer $transformer){
        $this->transformer = $transformer;
    }
    //======================================================
    public function uploadScores(){
        return view('students.scores');
    }
    //======================================================
    public function processScores(StudentScore $request){
        try {
            DB::beginTransaction();
            //************************************************************* */
            // start to process csv file data
            // Store the uploaded file temporary in storage to be used later
            $path = $request->file('file')->store('uploads');
            
            // handle reformatting of the CSV data in external service
            $jsonData = $this->transformer->transformFromFile($path);
            
            // Clean up the temporary file to save disk space
            Storage::delete($path);
            //************************************************************* */
            DB::commit();
            return response()->json($jsonData);
            //************************************************************* */
            // return redirect()->back()->with(['success'=>'Data processed successfully','data'=>json_encode($jsonData)]);
        } catch (\Exception $e) {
            Storage::delete($path);
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    //======================================================
    public function test()
    {
        $csvData = "Student ID,Name,Learning Objective,Score,Subject
1112,John Smith,EN_1,3,English
1112,John Smith,EN_2,4,English
1112,John Smith,EN_3,2,English
1113,Sarah Tyrell,MA_1,D,Maths
1113,Sarah Tyrell,MA_2,A,Maths
1113,Sarah Tyrell,MA_3,C,Maths
1114,Tara Hayworth,SCI_1,Excellent,Science
1114,Tara Hayworth,SCI_2,Good,Science
1114,Tara Hayworth,SCI_3,Poor,Science
1112,John Smith,EN_2,5,English
";
                    
                    
    $rows = collect(explode("\n", trim($csvData)));
    $headers = collect(str_getcsv($rows->shift()));
      // Map CSV rows to collection of data objects
    $data = $rows->map(function ($row) use ($headers) {
        $values = str_getcsv($row);
        return $headers->mapWithKeys(function ($header, $index) use ($values) {
            return [trim($header) => isset($values[$index]) ? trim($values[$index]) : null];
        });
    });              
                    
      // Group by student and format to required structure
     return $studentGroups = $data->groupBy('Student ID')->all();
      
        $studentGroups = $data->groupBy('Student ID')->map(function ($scores, $studentId) {
        $firstScore = $scores->first();
        
        $studentScores = $scores->map(function ($item) {
            return [
                'learning_objective' => $item['Learning Objective'],
                'score' => $item['Score']
            ];
        });
    });
        
        $jsonData = $this->transformer->transform($csvData);
        
        return response()->json($jsonData);
    }
}