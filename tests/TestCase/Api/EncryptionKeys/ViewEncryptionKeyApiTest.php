<?php

declare(strict_types=1);

namespace App\Test\TestCase\Api\Users;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use App\Test\Fixture\AuthKeysFixture;
use App\Test\Fixture\EncryptionKeysFixture;
use App\Test\Helper\ApiTestTrait;

class ViewEncryptionKeyApiTest extends TestCase
{
    use IntegrationTestTrait;
    use ApiTestTrait;

    protected const ENDPOINT = '/api/v1/encryptionKeys/view';

    protected $fixtures = [
        'app.Organisations',
        'app.Individuals',
        'app.Roles',
        'app.Users',
        'app.AuthKeys',
        'app.EncryptionKeys'
    ];

    public function testViewEncryptionKeyById(): void
    {
        $this->setAuthToken(AuthKeysFixture::ADMIN_API_KEY);
        $url = sprintf('%s/%d', self::ENDPOINT, EncryptionKeysFixture::ENCRYPTION_KEY_ORG_A_ID);
        $this->get($url);

        $this->assertResponseOk();
        $this->assertResponseContains(sprintf('"id": %d', EncryptionKeysFixture::ENCRYPTION_KEY_ORG_A_ID));
        // TODO: $this->assertRequestMatchesOpenApiSpec();
        $this->assertResponseMatchesOpenApiSpec($url);
    }
}
