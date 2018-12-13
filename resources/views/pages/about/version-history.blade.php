@extends('layouts.master')

@section('title')
  Version History
@endsection

@section('description')
  {{ env('APP_NAME') }} Web Service Version History
@endsection

@section('content')
  <div class="version-history">
    <h2>Version History</h2>
    <h3>{{ env('APP_NAME') }} <small>Release Date: 06/12/17</small></h3>
    Initial Release for Calendar download portion that is implemented in <a href="//www.csun.edu/faculty">Faculty</a>
    <br>
  </div>
@endsection
