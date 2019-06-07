<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DBAL;

class EnumOrderStatus extends EnumType
{
    protected $name = 'orderstatus';
    protected $values = ['created', 'executed', 'completed', 'cancelled', 'updated'];

    public static $static_name = 'orderStatus';
    public static $static_values = ['created', 'executed', 'completed', 'cancelled', 'updated'];

    public function getValues()
    {
        return $this->values;
    }
}
