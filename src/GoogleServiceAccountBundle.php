<?php

namespace Resgen\Common\Gcp;

class GoogleServiceAccountBundle
{

    protected $configuredAccounts = [];

    public function has($key): bool
    {
        return isset($this->configuredAccounts[$key]);
    }

    public function get($key): GoogleServiceAccount
    {
        if (!$this->has($key)) {
            throw new GoogleServiceAccountNotConfigured("$key not configured");
        }

        return $this->configuredAccounts[$key];
    }

    public function init()
    {
        $envAccounts = explode(',', env('APP_GCP_ACCOUNTS', ''));

        foreach ($envAccounts as $env) {
            // dont use app, it'll return the singleton instance which only support one env var
            $serviceAccount = new GoogleServiceAccount();

            $serviceAccount->init($env);

            $this->configuredAccounts[$env] = $serviceAccount;
        }
    }

}