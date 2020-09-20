# dawilog-php

### install
```
composer require wiebekn/dawilog-php
```



add to .env
```
DAWILOG_DSN=
```

config/app.php
```
Dawilog\Laravel\ServiceProvider::class,
```

app/Exceptions/Handler.php
```
    public function report(Throwable $exception)
    {
        if (app()->bound('dawilog') && $this->shouldReport($exception)) {
            app('dawilog')->sendException($exception);
        }

        parent::report($exception);
    }
```

config/dawilog.php
```
php artisan vendor:publish --provider="Dawilog\Laravel\ServiceProvider" --tag="config"
```