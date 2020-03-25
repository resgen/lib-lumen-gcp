<?php

namespace Resgen\Common\Gcp;

use Illuminate\Support\ServiceProvider;

class GoogleServiceAccountProvider extends ServiceProvider
{

    public function register() {
        $this->app->singleton(GoogleServiceAccount::class, function() {
            $creds = new GoogleServiceAccount();
            $creds->init();
            return $creds;
        });

        $this->app->singleton(GoogleServiceAccountBundle::class, function() {
            $bundle = new GoogleServiceAccountBundle();
            $bundle->init();
            return $bundle;
        });
    }

}