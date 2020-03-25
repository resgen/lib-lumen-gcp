<?php

namespace Resgen;

use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase as LumenTestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Resgen\Common\Gcp\GoogleServiceAccount;

abstract class TestCase extends LumenTestCase
{
    use MockeryPHPUnitIntegration;

    public function tearDown(): void
    {
        parent::tearDown();

        putenv('APP_GCP_SERVICE_ACCOUNT');
        putenv('APP_GCP_ACCOUNTS');
        putenv('APP_GCP_ACCOUNT_ONE');
        putenv('APP_GCP_ACCOUNT_TWO');

        $this->delFile('APP_GCP_SERVICE_ACCOUNT');
        $this->delFile('APP_GCP_ACCOUNT_ONE');
        $this->delFile('APP_GCP_ACCOUNT_TWO');
    }

    public function createApplication(): Application
    {
        $app = new Application();
        $app->withFacades();
        return $app;
    }

    private function delFile($var)
    {
        $filePath = sys_get_temp_dir()."/gcp-$var.json";
        if (is_file($filePath)) {
            unlink($filePath);
        }
    }

}
