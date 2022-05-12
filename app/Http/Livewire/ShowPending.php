<?php

namespace App\Http\Livewire;

use App\Models\Shopper\Shopper;
use App\Models\Store\Location\Location;
use App\Services\Store\Location\LocationService;
use App\Services\Shopper\ShopperService;
use Carbon\Carbon;
use Livewire\Component;

class ShowPending extends Component
{
    public $activeShopperCount, $shopperLimit, $pendingInFrontOfMe, $shopperUuid, $shopperStatus;
    public $sec;

    protected $listeners = [
        'update-pending' => 'updatePending'
    ];

    public function render()
    {
        $this->updatePending();
        return view('livewire.show-pending');
    }

    public function init() {
        $this->sec = 10;
    }

    public function updatePending() {
        $shopper = Shopper::where('uuid', $this->shopperUuid)->firstOrFail();
        $location = $shopper->location;

        $this->shopperLimit = $location->shopper_limit;
        $this->activeShopperCount = $location->shoppers_active()->count();

        $expires = Carbon::parse($shopper->check_in);
        $this->pendingInFrontOfMe = collect(
            Shopper::statusId(Shopper::PENDING)
                ->filterLife($expires)
                ->locationId($location->id)
                ->get()
                ->toArray())
            ->count();

        $this->shopperStatus = $shopper->status;
    }
}
