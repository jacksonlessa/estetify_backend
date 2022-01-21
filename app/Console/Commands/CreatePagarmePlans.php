<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\Services\PagarMe;

class CreatePagarmePlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pagarme:createPlans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cria plano no pagarme';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(config('pagarme.keys.api'));
        $pagarme = new PagarMe();
        $custormers = $pagarme->getCustomers();
        dd($custormers);
    }
}
