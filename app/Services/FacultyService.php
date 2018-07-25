<?php
namespace App\Services;
use App\ClassMemberships;
use App\User;
use App\Event;
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
  // public function getOfficeHours($term,$email)
  //   {
  //       $userId = User::email($email)->first();
  //       $userId = str_replace("members:","",$userId['user_id']);
  //       $entities_id = 'office-hours:'.$term.':'.$userId;
  //       $officeHours = Event::officeHours($entities_id)
  //       ->term($term)
  //       ->type('office-hours')
  //       ->get();
  //       return $officeHours;
  //   }

  public function getOfficeHoursWithPattern($term,$email,$pattern)
      {
          $userId = User::email($email)->first();
          $userId = str_replace("members:","",$userId->user_id);
          $entities_id = 'office-hours:'.$term.':'.$userId;
          $officeHours = Event::officeHours($entities_id)
          ->term($term)
          ->type('office-hours')
          ->patternNumber($pattern)
          ->get();
          return $officeHours;
      }

}
?>
