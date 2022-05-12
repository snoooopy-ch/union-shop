<?php

namespace App\Services\Shopper;

use App\Repositories\Shopper\ShopperRepository;
use App\Models\Shopper\Shopper;
use App\Models\Store\Location\Location;
use App\Services\BaseService;
use Carbon\Carbon;

/**
 * Class ShopperService
 * @package App\Services\Shopper
 */
class ShopperService extends BaseService
{
    /**
     * @var ShopperRepository
     */
    protected $shopper;

    /**
     * ShopperService constructor.
     * @param ShopperRepository $shopper
     */
    public function __construct(ShopperRepository $shopper)
    {
        $this->shopper = $shopper;
        parent::__construct($this->shopper);
    }

    public function checkIn($locationUuid, $params = array()) {
        $location = Location::where('uuid', $locationUuid)->firstOrFail();

        $shopperLimit = $location->shopper_limit;
        $activeShopperCount = $location->shoppers_active()->count();

        if ($shopperLimit > $activeShopperCount) {
            $status = Shopper::ACTIVE;            
        } else {
            $status = Shopper::PENDING;
        }

        $shopper = Shopper::firstOrNew([
            'email'         => $params['email']
        ],[
            'email'         => $params['email'],
            'first_name'    => $params['first_name'],
            'last_name'     => $params['last_name']
        ]);

        $shopper->location_id = $location->id;
        $shopper->status_id = $status;
        $shopper->check_in = now();
        $shopper->save();

        return $shopper->toArray();
    }

    public function checkOut($shopperUuid) {
        $shopper = Shopper::where('uuid', $shopperUuid)->firstOrFail();
        $shopper->status_id = Shopper::COMPLETED;
        $shopper->check_out = now();
        $shopper->save();

        $this->updateShoppingQueueByLocation($shopper->location_id);

        return $shopper;
    }

    public function updateShoppingQueueByLocation($locationId) {
        $pendingShoppers = $this->shopper->all([
                'id'
            ], [
                'location_id'   => $locationId,
                'status_id'     => Shopper::PENDING
            ], [], [], [
                'check_in'      => 'asc'
            ]);
        $activeShoppers = $this->shopper->all([

            ], [
                'location_id'   => $locationId,
                'status_id'     => Shopper::ACTIVE
            ], [], [], [
                'check_in'      => 'asc'
            ]);
        
        $shopperLimit = Location::find($locationId)->shopper_limit;

        if (count($activeShoppers) < $shopperLimit) {
            if ($shopperLimit < count($pendingShoppers) + count($activeShoppers) ) {
                $canActiveShopperCount = $shopperLimit - count($activeShoppers);
            } else {
                $canActiveShopperCount = count($pendingShoppers);
            }

            foreach ($pendingShoppers as $pendingShopper) {
                $this->shopper->update($pendingShopper['id'], [
                    'status_id' => Shopper::ACTIVE,
                    'check_in' => now()
                ]);
                $canActiveShopperCount --;
                if ($canActiveShopperCount == 0) break;
            }
        }
    }

    public function shoppersWillComplete() { 
        $expires = Carbon::now()->subMinutes(120);

        return Shopper::statusId(Shopper::ACTIVE)
            ->filterLife($expires)
            ->get()
            ->toArray();
    }
}
