<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class StudentScoreTransformer
{
    //======================================================
    /**
     * Scoring methods for different subjects
     */
    protected $scoringMethods = [
        'English' => [
            'scoreValues' => ['8' => 8, '7' => 7, '6' => 6, '5' => 5, '4' => 4, '3' => 3, '2' => 2, '1' => 1],
            'sortOrder' => 'desc'
        ],
        'Maths' => [
            'scoreValues' => ['A' => 6, 'B' => 5, 'C' => 4, 'D' => 3, 'E' => 2, 'F' => 1],
            'sortOrder' => 'desc'
        ],
        'Science' => [
            'scoreValues' => ['Excellent' => 5, 'Good' => 4, 'Average' => 3, 'Poor' => 2, 'Very Poor' => 1],
            'sortOrder' => 'desc'
        ]
    ];
    //======================================================
    /**
     * Transform CSV file into the required JSON format
     *
     * @param string $filePath Path to the CSV file
     * @return array Formatted student data
     */
    public function transformFromFile(string $filePath): array{
        // retrieves the contents of the file as a string
        $csvData = Storage::get($filePath);
        return $this->transform($csvData);
    }
    //======================================================
    /**
     * Transform CSV content into the required JSON format
     *
     * @param string $csvContent CSV content as a string
     * @return array Formatted student data
     */
    public function transform(string $csvContent): array{
        //===========================================
        // Parse CSV to collection
        $rows = collect(explode("\n", trim($csvContent)));
        $headers = collect(str_getcsv($rows->shift()));//fetch csv header
        //===========================================
        //map each data row to related csv header
        /*
        [{
            "Student ID": "1112",
            "Name": "John Smith",
            "Learning Objective": "EN_1",
            "Score": "3",
            "Subject": "English"
            },
            {
            "Student ID": "1112",
            "Name": "John Smith",
            "Learning Objective": "EN_2",
            "Score": "4",
            "Subject": "English"
            },
        ]*/
        // Map CSV rows to collection of data objects
        $data = $rows->map(function ($row) use ($headers) {
            $values = str_getcsv($row);
            return $headers->mapWithKeys(function ($header, $index) use ($values) {
                return [trim($header) => isset($values[$index]) ? trim($values[$index]) : null];
            });
        });
        //===========================================

        // Group by student and format to required structure
        $studentGroups = $data->groupBy('Student ID')->map(function ($scores, $studentId) {
            $firstScore = $scores->first();//just used to fetch subject
            
            
            $studentScores = $scores->map(function ($item) {
            //first score object
            return [
                    'learning_objective' => $item['Learning Objective'],
                    'score' => $item['Score']
                ];
            });

            // Sort scores according to the subject's scoring method
            $subject = $firstScore['Subject'];
            if (isset($this->scoringMethods[$subject])) {
                $scoring = $this->scoringMethods[$subject];
                
                $studentScores = $studentScores->sortBy(function ($score) use ($scoring) {
                    return $scoring['sortOrder'] === 'desc' 
                        ? -1 * ($scoring['scoreValues'][$score['score']] ?? 0)
                        : ($scoring['scoreValues'][$score['score']] ?? 0);
                })->values();
            }

            return [
                'student_id' => (int) $studentId,
                'name' => $firstScore['Name'],
                'subject' => $subject,
                'scores' => $studentScores->toArray()
            ];
        })->values();

        return $studentGroups->toArray();
    }
    //======================================================
    /**
     * Add a new scoring method for a subject
     *
     * @param string $subject Subject name
     * @param array $scoreValues Mapping of score labels to numeric values
     * @param string $sortOrder 'asc' or 'desc'
     * @return void
     */
    public function addScoringMethod(string $subject, array $scoreValues, string $sortOrder = 'desc'): void{
        $this->scoringMethods[$subject] = [
            'scoreValues' => $scoreValues,
            'sortOrder' => $sortOrder
        ];
    }
    //======================================================
}