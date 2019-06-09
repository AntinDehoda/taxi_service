<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Status;

final class OrderStatus
{
    const CREATED = 'created';
    const EXECUTED = 'executed';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';
    const UPDATED = 'updated';
}
