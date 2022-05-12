<?php

namespace App\Console\Commands;

use App\Models\Shopper\Shopper;
use App\Services\Shopper\ShopperService;
use Illuminate\Console\Command;

class AutoStatusMarkUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-pending2complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The system automatically mark a shopper as "completed" after 2hrs of being active';

    protected $shopper;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ShopperService $shopper)
    {
        parent::__construct();
        $this->shopper = $shopper;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $willCompleteShoppers = $this->shopper->shoppersWillComplete();
        
        foreach ($willCompleteShoppers as $willCompleteShopper) { 
            $this->shopper->update($willCompleteShopper['id'], [
                'status_id' => Shopper::COMPLETED,
                'check_out' => now()
            ]);
        }
        return Command::SUCCESS;
    }
}
