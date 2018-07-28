<?php
namespace App\Contracts;

interface FacultyContract{
    // public function editPost($postData, $id);

    public function getClassList($term,$email);

    public function getFinalExamTimes($term,$email);
    
    public function getClassAndFinalExamTimes($term, $email);

    public function getOfficeHours($term,$email);

    public function getIcal($instructorInfo,$email);

}
?>
