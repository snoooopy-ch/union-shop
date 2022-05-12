<div wire:init="init">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">Shopper Status: {{ $shopperStatus->name }}</div>
            </div>
            @if ($shopperStatus->id != 1)
                <div class="row">
                    <div class="col-12">Shopper Limit: {{ $shopperLimit }}</div>
                </div>
                <div class="row">
                    <div class="col-12">Current Active: {{ $activeShopperCount }}</div>
                </div>
                <div class="row">
                    <div class="col-12">Pending In Front Of Me: {{ $pendingInFrontOfMe }}</div>
                </div>
            @endif
        </div>
    </div>
    

    <div class="d-block text-center">
        Will update in {{ $sec }} seconds.
    </div>

    <script>
        let timer = undefined;

        window.onload = function() {
            if (timer !== undefined) {
                clearInterval(timer);
            }
            timer = setInterval(function () {
                if (@this.sec === 1){
                    @this.sec = 10;
                } else {
                    @this.sec = @this.sec - 1;
                }
            }, 1000)
        }
    </script>
</div>
