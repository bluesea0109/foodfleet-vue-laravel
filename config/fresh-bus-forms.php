<?php

use App\Http\Controllers\Auth\LoginController;
use FreshinUp\FreshBusForms\Http\Controllers\Auth\PasswordsController;
use FreshinUp\FreshBusForms\Http\Controllers\ConsumerController;
use FreshinUp\FreshBusForms\Http\Controllers\SPAController;

return [
    'app' => [
        'name' => config('app.name')
    ],
    'models' => [
        'user'          => \App\User::class,
        'user_level'    => FreshinUp\FreshBusForms\Models\User\UserLevel::class,
        'user_type'     => FreshinUp\FreshBusForms\Models\User\UserType::class,
        'user_status'   => FreshinUp\FreshBusForms\Models\User\UserStatus::class,
        'policy'        => FreshinUp\FreshBusForms\Models\Policy::class,
        'policy_versions'   => FreshinUp\FreshBusForms\Models\PolicyVersion::class,
        'policy_agreements' => FreshinUp\FreshBusForms\Models\PolicyAgreement::class,
    ],
    'resources' => [
        'user'          => FreshinUp\FreshBusForms\Http\Resources\User\User::class,
        'current_user'  => \App\Http\Resources\CurrentUser::class
    ],
    'controllers' => [
        'login'         => LoginController::class,
        'password'      => PasswordsController::class,
        'ConsumerSPA'   => ConsumerController::class,
        'AdminSPA'      => SPAController::class,
    ],
    'enums' => [
        'user_status'   => App\Enums\UserStatus::class,
    ],
    'redirects'         => [
        /**
         * When the users is Unauthenticated (i.e. 'not logged in')
         */
        'unauthenticated'   => 'auth.login',
        /**
         * Usually what happens after login
         */
        'authenticated'     => [
            /**
             * We may instead want to do "landing" routes instead
             */
            'admin'                 => 'admin.index',
            'user'                  => 'customer.index'
        ],
        'policies' => 'policies'
    ]
];
