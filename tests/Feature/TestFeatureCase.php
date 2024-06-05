<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Orchid\Support\Facades\Dashboard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class TestUnitCase.
 */
abstract class TestFeatureCase extends BaseTestCase
{
    /**
     * @var User
     */
    private $user;

    protected function createAdminUser(): User
    {
        if ($this->user === null) {
            $this->user = User::factory()->create([
                'permissions' => Dashboard::getAllowAllPermission(),
              ]);
        }

        return $this->user;
    }

    /**
     * Set the URL of the previous request.
     *
     *
     * @return $this
     */
    public function from(string $url)
    {
        $this->app['session']->setPreviousUrl($url);

        return $this;
    }
}
