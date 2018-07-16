<?php
namespace App\Services;

use App\Contracts\FacultyContract;

class FacultyService implements FacultyContract {

  public function getClassList($term,$email)
  {
    return [
      [
      'classes_id' => '1234561',
      'events' => [
          'entities_id' => 'entity:id',
          'term_id' => '2187'
          ]
      ],
      [
          'classes_id' => '1234561',
          'events' => [ 
              'entities_id' => 'entity:id',
              'term_id' => '2187' 
          ]
      ],
      [
          'classes_id' => '1234561',
          'events' => [ 
              'entities_id' => 'entity:id',
              'term_id' => '2187' 
          ]
      ]
    ];
  }

  public function getFinalExamTimes($term,$email){
    return 'this is a test';

  }
    
}
?>