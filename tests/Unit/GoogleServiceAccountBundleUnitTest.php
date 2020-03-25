<?php

namespace Resgen\Common\Gcp;

class GoogleServiceAccountBundleUnitTest extends \Resgen\TestCase
{

    public function setup(): void
    {
        parent::setup();


        putenv('APP_GCP_ACCOUNTS=APP_GCP_ACCOUNT_ONE,APP_GCP_ACCOUNT_TWO');

        putenv(sprintf(
            'APP_GCP_ACCOUNT_ONE=%s',
            base64_encode('{"foo":"bar"}')
        ));

        putenv(sprintf(
            'APP_GCP_ACCOUNT_TWO=%s',
            base64_encode('{"baz":"bin"}')
        ));
    }

    /**
     * @expectedException \Resgen\Common\Gcp\GoogleServiceAccountNotConfigured
     */
    public function test_Should_Throw_Exception_With_Env_Var_DoesNotExist()
    {
        // given
        app()->register(GoogleServiceAccountProvider::class);

        // when
        $sut = app(GoogleServiceAccountBundle::class);
        $sut->get('APP_GCP_ACCOUNT_THREE');
    }

    public function test_Should_Return_ServiceAccount_For_ENV()
    {
        // given
        app()->register(GoogleServiceAccountProvider::class);

        // when
        $sut = app(GoogleServiceAccountBundle::class);
        $account = $sut->get('APP_GCP_ACCOUNT_TWO');

        // then
        $this->assertFileExists($account->getFilePath());
    }

}
