<?php

return [
    'host'        => env('ELASTICSEARCH_HOST', 'https://localhost:9200'),
    'username'    => env('ELASTICSEARCH_USERNAME', 'elastic'),
    'password'    => env('ELASTICSEARCH_PASSWORD'),
    'ca_bundle'   => storage_path('certs/http_ca.crt'),
    'sales_index' => 'sales',
    'traffic_index' => 'traffic_hourly',
    'country_index' => 'country_requests',
    'ip_index' => 'ip_requests'
];