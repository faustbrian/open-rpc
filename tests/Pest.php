<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Provide minimal shims for Laravel helper functions used by spatie/laravel-data
// so that tests can run outside a Laravel application context.
if (!function_exists('config')) {
    function config(string $key, $default = null)
    {
        return match ($key) {
            'data.max_transformation_depth' => -1,
            'data.throw_when_max_transformation_depth_reached' => false,
            default => $default,
        };
    }
}
