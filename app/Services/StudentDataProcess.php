<?php

namespace App\Services;

use League\Csv\Reader;
use App\Models\Subject;
use League\Csv\Statement;
use Illuminate\Support\Facades\Storage;

class StudentDataProcess
{
    //=========================================================================
    protected $scoringMethods = [];
    //=========================================================================
    public function __construct(){
        //call to this function when handle scoring mehods static 
        // $this->initDefaultScoringMethods();
        
        //call to this function when handle scoring methods dynamic(fetch from db)
        $this->scoringMethods = $this->getScoringMethods();
    }
    //=========================================================================
    public function getScoringMethods(){
        $subjects = Subject::with('scores')->active()->get();

        $scoringMethods = $subjects->mapWithKeys(function ($subject) {
            return [
                $subject->name => $subject->scores->pluck('sort', 'score')->toArray(),
            ];
        })->toArray();
    
        return $scoringMethods;
    }
    //=========================================================================
    protected function initDefaultScoringMethods(): void{
        // English: 8 is highest, 1 is lowest
        $this->addScoringMethod('English', [
            '8' => 8, '7' => 7, '6' => 6, '5' => 5, '4' => 4, '3' => 3, '2' => 2, '1' => 1
        ]);

        // Maths: A is highest, F is lowest
        $this->addScoringMethod('Maths', [
            'A' => 6, 'B' => 5, 'C' => 4, 'D' => 3, 'E' => 2, 'F' => 1
        ]);

        // Science: Excellent to Very Poor
        $this->addScoringMethod('Science', [
            'Excellent' => 5, 'Good' => 4, 'Average' => 3, 'Poor' => 2, 'Very Poor' => 1
        ]);
        

    }
    //=========================================================================
    public function addScoringMethod(string $subject, array $scoreValues): void {
        $this->scoringMethods[$subject] = $scoreValues;
    }
    //=========================================================================
    public function processData(string $filePath): array { //transform CSV file to JSON format
        $csv        = $this->getCsvData($filePath);
        $records    = $csv->setHeaderOffset(0);//combain file header with each record in array of objects
        $result     = $this->processRecords($records);
        // Save the result to a file in storage
        Storage::put('student_scores.txt', json_encode($result, JSON_PRETTY_PRINT));//this will found in storage/app/private directory
        return $result;
    }
    //=========================================================================
    public function getCsvData($filePath=null) {
        // For local file
        if (file_exists($filePath)) {
            $csv        = Reader::createFromPath($filePath, 'r');
        }else {
            // For Laravel storage file
            $content    = Storage::get($filePath);
            $csv        = Reader::createFromString($content);
        }
        return $csv;
    }
    //=========================================================================
    protected function processRecords(iterable $records): array{ //process CSV records into the required format
        $studentsData = [];
        //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        // group records by student ID
        $studentsData = $this->groupDataByStudent($records,$studentsData);
        //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        // Sort scores for each student based on subject scoring method
        $studentsData = $this->sortStudentScoreObject($studentsData);
        //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        // Convert to indexed array
        return array_values($studentsData);
    }
    //=========================================================================
    public function groupDataByStudent($records,$studentsData) {
        // group records by student ID
        foreach ($records as $record) {
            $studentId          = $record['Student ID'];
            $studentName        = $record['Name'];
            $subject            = $record['Subject'];
            $learningObjective  = $record['Learning Objective'];
            $score              = $record['Score'];
            
            // If student doesn't exist in our array yet, create it
            $studentsData = $this->checkStudentInDataArray($studentsData,$studentId,$studentName,$subject);
            
            // Add score to student
            $studentsData = $this->addScoreObjectToStudentData($studentsData,$studentId,$learningObjective,$score);
        }
        return $studentsData;
    }
    //=========================================================================
    public function checkStudentInDataArray($studentsData,$studentId,$studentName,$subject) {
        // If student doesn't exist in our array yet, create it
        if (!isset($studentsData[$studentId])) {
            $studentsData[$studentId] = [
                'student_id'    => (int) $studentId,
                'name'          => $studentName,
                'subject'       => $subject,
                'scores'        => []
            ];
        }
        return $studentsData;
    }
    //=========================================================================
    public function addScoreObjectToStudentData($studentsData,$studentId,$learningObjective,$score) {
        // Add score to student
        $studentsData[$studentId]['scores'][] = [
            'learning_objective'    => $learningObjective,
            'score'                 => $score
        ];
        return $studentsData;
    }
    //=========================================================================
    public function sortStudentScoreObject($studentsData){
        // Sort scores for each student based on subject scoring method
        foreach ($studentsData as &$student) {      //process each student by referance to make effect to studentData array direct not to a copy
            $subject = $student['subject'];
            if (isset($this->scoringMethods[$subject])) {
                usort($student['scores'], function ($a, $b) use ($subject) {
                    $scoreA = $this->scoringMethods[$subject][$a['score']] ?? 0;
                    $scoreB = $this->scoringMethods[$subject][$b['score']] ?? 0;
                    
                    //use spaceship operator to compare scores
                    return $scoreB <=> $scoreA;     // Sort in descending order (higher scores first)
                    // return $scoreA <=> $scoreB;  // Sort in ascending order (lower scores first)
                });
            }
        }
        return $studentsData;
    }
    //=========================================================================
}