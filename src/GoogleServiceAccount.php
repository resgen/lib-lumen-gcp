<?php

namespace Resgen\Common\Gcp;

class GoogleServiceAccount
{

    /** @var string */
    protected $filePath = '';

    /** @var ?array */
    protected $json;

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getDecodedJson()
    {
        return $this->json;
    }

    public function init($env = 'APP_GCP_SERVICE_ACCOUNT')
    {
        $creds = env($env);

        $this->filePath = sprintf('%s/gcp-%s.json',
            sys_get_temp_dir(),
            $env
        );

        $this->json = json_decode(
            base64_decode($creds), 
            true
        );

        if (!$this->json) {
            throw new InvalidServiceAccount("Invalid service account json for env var $env");
        }

        if (!is_file($this->filePath)) {
            file_put_contents($this->filePath, json_encode($this->json));
        }
    }

}