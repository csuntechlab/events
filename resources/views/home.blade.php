@extends('layouts.master')

@section('title')
  Documentation
@endsection

@section('description')
  {{ env('APP_NAME') }} Web Service Documentation
@endsection

@section('content')
        <h2 id="introduction">Introduction</h2>
        <p>The {{ env('APP_NAME') }} web service provides information about faculty office hours, teaching hours,
            and finals hours. This information is derived from the CSUN catalog
            and faculty submitted information using <a href="//www.csun.edu/faculty/scholarship">Scholarship</a>.
            The web service provides a gateway to access the information via a REST-ful
            API. The information is retrieved by creating a specific URI and giving
            values to filter the data. The information that is returned is a JSON
            object that contains a set of interest or badges attached to a particular
            member; the format of the JSON object is as follows:
        </p>
        <div class="card mt-4 mb-3">
            <div class="card-body json-section">
<pre class="prettyprint"><code>{
  "classList": [
    {
      "term_id": 2173,
      "pattern_number": 1,
      "type": "class",
      "label": "Class Meeting Time",
      "start_time": "0800h",
      "end_time": "0900h",
      "days": "MWF",
      "from_date": null,
      "to_date": null,
      "location_type": "physical",
      "location": "EH2003",
      "is_byappointment": 0,
      "is_walkin": 1,
      "booking_url": null,
      "online_label": null,
      "online_url": null,
      "course": {
        "term_id": 2173,
        "class_number": "99994",
        "subject": "COMP",
        "catalog_number": "994",
        "title": "META DEVELOPMENT E",
        "description": null
      }
    },
    {
      "term_id": 2173,
      "pattern_number": 1,
      "type": "class",
      "label": "Class Meeting Time",
      "start_time": "0800h",
      "end_time": "0900h",
      "days": "R",
      "from_date": null,
      "to_date": null,
      "location_type": "physical",
      "location": "JD1100",
      "is_byappointment": 0,
      "is_walkin": 1,
      "booking_url": null,
      "online_label": null,
      "online_url": null,
      "course": {
        "term_id": 2173,
        "class_number": "99995",
        "subject": "COMP",
        "catalog_number": "995",
        "title": "META DEVELOPMENT F",
        "description": null
      }
    },
    {
      "term_id": 2173,
      "pattern_number": 1,
      "type": "class",
      "label": "Class Meeting Time",
      "start_time": "1600h",
      "end_time": "1900h",
      "days": "R",
      "from_date": null,
      "to_date": null,
      "location_type": "physical",
      "location": "BB1125",
      "is_byappointment": 0,
      "is_walkin": 1,
      "booking_url": null,
      "online_label": null,
      "online_url": null,
      "course": {
        "term_id": 2173,
        "class_number": "99996",
        "subject": "COMP",
        "catalog_number": "996",
        "title": "META DEVELOPMENT G",
        "description": null
      }
    },
    {
      "term_id": 2173,
      "pattern_number": 1,
      "type": "class",
      "label": "Class Meeting Time",
      "start_time": "1400h",
      "end_time": "1515h",
      "days": "TR",
      "from_date": null,
      "to_date": null,
      "location_type": "physical",
      "location": "SH268",
      "is_byappointment": 0,
      "is_walkin": 1,
      "booking_url": null,
      "online_label": null,
      "online_url": null,
      "course": {
        "term_id": 2173,
        "class_number": "99999",
        "subject": "COMP",
        "catalog_number": "999",
        "title": "META DEVELOPMENT III",
        "description": null
      }
    }
  ],
  "officeHours": [
    {
      "term_id": 2173,
      "pattern_number": 1,
      "type": "office-hours",
      "label": "General Office Hours",
      "start_time": null,
      "end_time": null,
      "days": null,
      "from_date": null,
      "to_date": null,
      "location_type": "physical",
      "location": null,
      "is_byappointment": 1,
      "is_walkin": 0,
      "booking_url": null,
      "online_label": null,
      "online_url": null
    }
  ]
}</code></pre>
            </div>
        </div>
        <h2 id="getting-started">Getting Started</h2>
        <ol>
          <li><strong>GENERATE THE URI:</strong> Find the usage that fits your need. Browse through subcollections, instances and query types to help you craft your URI.</li>
          <li><strong>PROVIDE THE DATA:</strong> Use the URI to query your data. See the Usage Example session.</li>
          <li><strong>SHOW THE RESULTS</strong></li>
        </ol>
        <p>Loop through the data to display its information. See the Usage Example session.</p>
        <br>
        <h2 id="collections">Collections</h2>
        <strong>All Badges Listing</strong>
        <ul>
          <li><a href="{!! url('1.0/terms/2173/faculty/'.$email) !!}">{!! url('1.0/terms/2173/faculty/'.$email) !!}</a></li>
        </ul>
        <br>
        <h2 id="code-samples">Code Samples</h2>
        <strong>Badges</strong>
        <div class="accordion">
          <div class="card">
            <div id="jquery-header" class="card-header">
              <p class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#jquery-body" aria-expanded="true" aria-controls="jquery-body">
                  JQuery
                </button>
              </p>
            </div>
            <div id="jquery-body" class="collapse" aria-labelledby="jquery-header">
              <div class="card-body">
                <pre>
                  <code class="prettyprint lang-js">
//construct a function to get url and iterate over
$(document).ready(function() {
  //generate a url
  var url = '{!! url('1.0/terms/2173/faculty/'.$email) !!}';
  //use the URL as a request
  $.ajax({
    url: url
  }).done(function(data) {
    // save the degree list
    var badgeList = data.badges;
    //iterate over the degree list
    $(badgeList).each(function(index, badge) {
      //append each degree and institute
      $('#badge-results').append('<strong>'+ badge.name + '</strong><br>by: ' + badge.issuer + '<br>');
      });
    });
});
                  </code>
                </pre>
              </div>
            </div>
          </div>
          <div class="card">
            <div id="php-header" class="card-header">
                <p class="mb-0">
                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#php-body" aria-expanded="true" aria-controls="php-body">
                    PHP
                  </button>
                </p>
            </div>
            <div id="php-body" class="collapse" aria-labelledby="php-header">
              <div class="card-body">
              <pre>
                <code class="prettyprint lang-php">
//generate a url
$url = '{!! url('1.0/terms/2173/faculty/'.$email) !!}';

//add extra necessary options
$arrContextOptions = [
    "ssl" => [
        "verify_peer"=>false,
        "verify_peer_name"=>false
    ]
];

//perform the query
$data = file_get_contents($url, false, stream_context_create($arrContextOptions));

//decode the json
$data = json_decode($data, true);

//iterate over the list of data and print
foreach($data['badges'] as $badge){
	echo = $badge['name'] . '<br>by: ' . $badge['issuer'].'<br>';
}
                </code>
              </pre>
            </div>
            </div>
          </div>
          <div class="card">
            <div id="python-header" class="card-header">
              <p class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#python-body" aria-expanded="true" aria-controls="python-body">
                  Python
                </button>
              </p>
            </div>
            <div id="python-body" class="collapse" aria-labelledby="python-header">
              <div class="card-body">
              <pre>
                <code class="prettyprint language-py">
#python
import urllib2
import json

#generate a url
url = u'{!! url('1.0/terms/2173/faculty/'.$email) !!}'

#open the url
try:
  u = urllib2.urlopen(url)
  data = u.read()
except Exception as e:
  data = {}

#load data with json object
data = json.loads(data)

#iterate over the json object and print
for badge in data['badges']:
  print badge['name'] + '\nby: ' + badge['issuer']
                </code>
              </pre>
            </div>
            </div>
            <div id="ruby-header" class="card-header">
              <p class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#ruby-body" aria-expanded="true" aria-controls="ruby-body">
                  Ruby
                </button>
              </p>
            </div>
            <div id="ruby-body" class="collapse" aria-labelledby="ruby-header">
              <div class="card-body">
              <pre>
                <code class="prettyprint lang-rb">
require 'net/http'
require 'json'

#generate a url
source = '{!! url('1.0/terms/2173/faculty/'.$email) !!}'

#prepare the uri
uri = URI.parse(source)

#request the data
response = Net::HTTP.get(uri)

#parse the json
badges = JSON.parse(response)

#print the json
badges['badges'].each do |badge|
  puts "#{badge['name']}\nby: #{badge['issuer']}"
                </code>
              </pre>
            </div>
            </div>
          </div>
        </div>
@endsection
