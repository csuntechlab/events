<?php
namespace App\Contracts;

interface StudentContract{
    public function termClasses($term, $email);
}