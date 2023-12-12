<?php

namespace App\Console\Commands;

use App\Models\Medicine;
use Illuminate\Console\Command;

class RemoveExpiredMedicines extends Command
{

    protected $signature = 'medicines:remove-expired';


    protected $description = 'Remove expired medicines from the database';


    public function handle()
    {
        Medicine::where('expiration_date','<',now())->delete();

        $this->info('Expired medicines have been removed successfully');
    }
}
