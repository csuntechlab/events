<?php
namespace App\Services;
use App\ClassMemberships;
use App\Contracts\FacultyContract;

class FacultyService implements FacultyContract {
    
    protected $table = 'nemo.classmemberships';

    public function getClassList($term,$email)
    {
        // $first = ClassMemberships::all();
        $first = ClassMemberships::email($email)
        ->term($term)
        ->with('events')
        ->get();
        // var_dump($first);
        return ['status'=>'true'] ;
        // return $first;
    }
    
    public function getFinalExamTimes($term,$email){
        return 'this is a test';
    }
    
}
?>