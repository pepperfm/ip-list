<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Database\Eloquent\Model;
use App\Models\Address;

class StoreNetworkAddressesAction
{
    /**
     * @param \App\Http\Requests\NetworkRequest $request
     * @param \App\Models\Network $network
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function handle(ValidatesWhenResolved $request, Model $network)
    {
        $mask = \Str::of($request->input('addresses_mask'));
        $networkIp = (string) $mask->beforeLast('.');
        $loops = $mask->afterLast('.')->explode('/');
        $arr = range($loops[0], $loops[1]);
        $res = [];

        foreach ($arr as $item) {
            $res[] = [
                'name' => $networkIp . ".$item",
                'network_id' => $network->id,
            ];
        }
        if (!Address::upsert($res, ['network_id'], ['name'])) {
            throw new \DomainException('Save addresses error');
        }
    }
}
