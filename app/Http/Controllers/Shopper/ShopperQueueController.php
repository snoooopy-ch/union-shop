<?php

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shopper\ShopperCheckInRequest;
use App\Models\Shopper\Shopper;
use App\Services\Shopper\ShopperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class ShopperQueueController extends Controller
{
    /**
     * ShopperService
     */
    protected $shopper;

    public function __construct(ShopperService $shopper) {
        $this->shopper = $shopper;
    }

    public function checkIn($locationUuid, ShopperCheckInRequest $request) {
        $shopper = $this->shopper->checkIn($locationUuid, $request->only('first_name', 'last_name', 'email'));
        return Redirect()->route('shopper.check-pending', [
                'shopperUuid' => $shopper['uuid']
            ])
            ->with('Success', 'You are checked in successfully')
            ->with('status', $shopper['status_id']);
    }

    public function checkOut($shopperUuid, Request $request) {
        $shopper = $this->shopper->checkOut($shopperUuid);
        return Redirect()->back()
            ->with('Success', 'You are checked out successfully');
    }

    public function checkPending($shopperUuid) {
        $shopper = Shopper::where('uuid', $shopperUuid)->firstOrFail();
        $location = $shopper->location;
        return view('stores.location.pending')
            ->withShopper($shopper)
            ->withLocation($location);
    }
}
