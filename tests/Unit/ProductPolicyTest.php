<?php

namespace Tests\Unit;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use App\Policies\ProductPolicy;
use PHPUnit\Framework\TestCase;

class ProductPolicyTest extends TestCase
{
    public function test_update_allows_owner_even_when_product_owner_id_is_string(): void
    {
        $user = new User();
        $user->id = 2;
        $user->role = UserRole::PARTNER;
        $user->status = UserStatus::ACTIVE;

        $product = (object) [
            'user_id' => '2',
            'mitra_id' => null,
        ];

        $policy = new ProductPolicy();

        $this->assertTrue($policy->update($user, $product));
    }
}
