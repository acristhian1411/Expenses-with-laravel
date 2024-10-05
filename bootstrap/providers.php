<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    OwenIt\Auditing\AuditingServiceProvider::class,
    G4T\Swagger\Http\Middleware\SwaggerMiddleware::class
];
