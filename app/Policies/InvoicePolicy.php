<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;

class InvoicePolicy
{
    /**
     * Determine if the user can generate invoices.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function generateInvoices(User $user)
    {
        return $user->is_admin; // Or any other logic that determines whether the user is allowed
    }
}