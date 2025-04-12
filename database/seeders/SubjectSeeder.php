<?php

namespace Database\Seeders;

use App\Models\Score;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use App\Traits\HandleTableTruncate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    //===================================================
    use HandleTableTruncate;
    //===================================================
    public function run(): void{
        $this->truncateTable('scores');
        $this->truncateTable('subjects');
        $subjects=[
            [
                'name'=>'English',
                'scores'=>[
                    [
                        'score'=>'8',
                        'sort' => 8
                    ],
                    [
                        'score'=>'7',
                        'sort' => 7
                    ],
                    [
                        'score'=>'6',
                        'sort' => 6
                    ],
                    [
                        'score'=>'5',
                        'sort' => 5
                    ],
                    [
                        'score'=>'4',
                        'sort' => 4
                    ],
                    [
                        'score'=>'3',
                        'sort' => 3
                    ],
                    [
                        'score'=>'2',
                        'sort' => 2
                    ],
                    [
                        'score'=>'1',
                        'sort' => 1
                    ]
                ]
            ],
            [
                'name'=>'Maths',
                'scores'=>[
                    [
                        'score'=>'A',
                        'sort' => 6
                    ],
                    [
                        'score'=>'B',
                        'sort' => 5
                    ],
                    [
                        'score'=>'C',
                        'sort' => 4
                    ],
                    [
                        'score'=>'D',
                        'sort' => 3
                    ],
                    [
                        'score'=>'E',
                        'sort' => 2
                    ],
                    [
                        'score'=>'F',
                        'sort' => 1
                    ]
                ]
            ],
            [
                'name'=>'Science',
                'scores'=>[
                    [
                        'score'=>'Excellent',
                        'sort' => 5
                    ],
                    [
                        'score'=>'Good',
                        'sort' => 4
                    ],
                    [
                        'score'=>'Average',
                        'sort' => 3
                    ],
                    [
                        'score'=>'Poor',
                        'sort' => 2
                    ],
                    [
                        'score'=>'Very Poor',
                        'sort' => 1
                    ]
                ]
            ]
        ];
        foreach($subjects as $subject){
            $added_subject=Subject::create(['name'=>$subject['name']]);
            foreach($subject['scores'] as $score){
                Score::create([
                    'subject_id'    => $added_subject->id,
                    'score'         => $score['score'],
                    'sort'          => $score['sort']
                ]);
            }
        }
    //===================================================
    }
}
