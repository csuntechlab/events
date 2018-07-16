<?php
namespace App\Services;
use App\ClassMemberships;
use App\Contracts\FacultyContract;

class FacultyService implements FacultyContract {
    public function getClassList($term,$email)
    {
        // $first = ClassMemberships::email($email)
        // ->term($term)
        // ->get();
        // return $first;
        $json = json_encode(
            [
                [
                    "classes_id" => '12343',
                    "term_id" => '2187'
                ],
                [
                    "classes_id" => '12344',
                    "term_id" =>'2187'
                ],
                [
                    "classes_id" => '12345',
                    "term_id" => '2187'
                ]
            ]
        );
        
        return $json;
    }
    
    public function getFinalExamTimes($term,$email){
        return 'this is a test';
    }
    
}
?>