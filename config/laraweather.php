<?php
return [
  'openweathermap' => [
      'api_key' => env(key: 'OPENWEATHERMAP_API_KEY'),
      'base_api' => env(key: 'OPENWEATHERMAP_BASE_API', default: 'https://api.openweathermap.org/data/'),
      'version' => env(key: 'OPENWEATHERMAP_VERSION', default: '2.5'),
      'units' => env(key: 'OPENWEATHERMAP_DEFAULT_UNIT', default: 'metrics'),
  ]
];
