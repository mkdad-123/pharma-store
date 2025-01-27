<?php

namespace App\Broadcasting;


use App\Models\Pharmacist;

class OrderStatusChannel
{

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(Pharmacist $user, $pharmacistId): array|bool
    {
        return (int) $user->id === (int) $pharmacistId;
    }
}
