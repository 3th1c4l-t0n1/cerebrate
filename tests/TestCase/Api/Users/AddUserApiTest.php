<?php

declare(strict_types=1);

namespace App\Test\TestCase\Api\Users;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use App\Test\Fixture\AuthKeysFixture;
use App\Test\Fixture\UsersFixture;
use App\Test\Fixture\OrganisationsFixture;
use App\Test\Fixture\RolesFixture;
use App\Test\Helper\ApiTestTrait;

class AddUserApiTest extends TestCase
{
    use IntegrationTestTrait;
    use ApiTestTrait;

    protected const ENDPOINT = '/api/v1/users/add';

    protected $fixtures = [
        'app.Individuals',
        'app.Roles',
        'app.Users',
        'app.AuthKeys'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->initializeValidator(APP . '../webroot/docs/openapi.yaml');
    }

    public function testAddUser(): void
    {
        $this->setAuthToken(AuthKeysFixture::ADMIN_API_KEY);
        $this->post(
            self::ENDPOINT,
            [
                'individual_id' => UsersFixture::USER_REGULAR_USER_ID,
                'organisation_id' => OrganisationsFixture::ORGANISATION_A_ID,
                'role_id' => RolesFixture::ROLE_REGULAR_USER_ID,
                'disabled' => false,
                'username' => 'test',
                'password' => 'Password123456!',
            ]
        );

        $this->assertResponseOk();
        $this->assertResponseContains('"username": "test"');
        $this->assertDbRecordExists('Users', ['username' => 'test']);
        //TODO: $this->assertRequestMatchesOpenApiSpec();
        $this->assertResponseMatchesOpenApiSpec(self::ENDPOINT, 'post');
    }

    public function testAddUserNotAllowedToRegularUser(): void
    {
        $this->setAuthToken(AuthKeysFixture::REGULAR_USER_API_KEY);
        $this->post(
            self::ENDPOINT,
            [
                'individual_id' => UsersFixture::USER_REGULAR_USER_ID,
                'organisation_id' => OrganisationsFixture::ORGANISATION_A_ID,
                'role_id' => RolesFixture::ROLE_REGULAR_USER_ID,
                'disabled' => false,
                'username' => 'test',
                'password' => 'Password123456!'
            ]
        );

        $this->assertResponseCode(405);
        $this->assertDbRecordNotExists('Users', ['username' => 'test']);
        //TODO: $this->assertRequestMatchesOpenApiSpec();
        $this->assertResponseMatchesOpenApiSpec(self::ENDPOINT, 'post');
    }
}
