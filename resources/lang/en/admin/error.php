<?php
return [
    'no-error-code-passed' => [
        'code' => '500',
        'title' => "Internal Server Error",
        'description' => "A problem occurred on the server. We will look into it and fix it as soon as possible.",
    ],
    'system-error' => [
        'code' => '500',
        'title' => "Internal Server Error",
        'description' => "A problem occurred on the server. We will look into it and fix it as soon as possible.",
    ],
    'invalid-request' => [
        'code' => '400',
        'title' => "Invalid request made..",
        'description' => "Sorry, your request couldn't be processed. Please try again.",
    ],
    'un-authorized-request' => [
        'code' => '401',
        'title' => "Un-authorized request made..",
        'description' => "Sorry, your request couldn't be processed. Please try again.",
    ],
    'not-found' => [
        'code' => '404',
        'title' => "We couldn't find the page..",
        'description' => "Sorry, but the page you are looking for was either not found or does not exist. 
            Try refreshing the page or click the button below to go back to the home page.",
        'back_to_text' => "Back To Homepage",
    ],
    'event-not-found' => [
        'title' => "We couldn't find the event.",
        'description' => "Sorry, but the event you are looking for was either not found or does not exist.",
    ],
];