<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AddEnergy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-energy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->energy++;
            $user->save();
        }
    }
}
