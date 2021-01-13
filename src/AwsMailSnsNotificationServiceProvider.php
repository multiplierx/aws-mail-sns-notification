<?php

namespace Multiplier\AwsMailSnsNotification;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Multiplier\AwsMailSnsNotification\Middlewares\NotificationConnection;

class AwsMailSnsNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/mail_sns_notification.php', 'mail_sns_notification');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('aws.mail.sns.notification', NotificationConnection::class);

        $this->publishes([
            __DIR__ . '/../config/mail_sns_notification.php' => config_path('mail_sns_notification.php'),
        ], 'config');
    }
}
