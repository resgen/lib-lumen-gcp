<?php

namespace Resgen\Common\Gcp;

class GoogleServiceAccountUnitTest extends \Resgen\TestCase
{

    /**
     * @expectedException \Resgen\Common\Gcp\InvalidServiceAccount
     */
    public function test_Should_Throw_Exception_With_Invalid_Json()
    {
        // given
        putenv(sprintf(
            'APP_GCP_SERVICE_ACCOUNT=%s',
            base64_encode('{"asdf":"missing}"')
        ));

        // when
        app()->register(GoogleServiceAccountProvider::class);
        $sut = app(GoogleServiceAccount::class);
    }

    public function test_Should_PutDown_File()
    {
        // given
        putenv(sprintf(
            'APP_GCP_SERVICE_ACCOUNT=%s',
            base64_encode('{"foo":"bar"}')
        ));

        // when
        app()->register(GoogleServiceAccountProvider::class);
        $sut = app(GoogleServiceAccount::class);
        
        // then
        $this->assertFileExists($sut->getFilePath());
    }

    public function test_Should_Have_Json()
    {
        // given
        putenv(sprintf(
            'APP_GCP_SERVICE_ACCOUNT=%s',
            base64_encode('{"foo":"bar"}')
        ));

        // when
        app()->register(GoogleServiceAccountProvider::class);
        $sut = app(GoogleServiceAccount::class);
        
        // then
        $this->assertEquals($sut->getDecodedJson(), ['foo' => 'bar']);
    }

}
