<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Pc;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;


class AccountController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ShowAll()
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        }

        $pcs = Pc::where('status_id', '1')->get();
        $parts = Part::where('status_id', '1')->get();

        $listing = new Collection();

        foreach($pcs as $pc) {
            $pc->type = 'pcs';
            $listing->push($pc);
        }

        foreach($parts as $part) {
            $part->type = 'parts';
            $listing->push($part);
        }

        $listing->sortBy('created_at');

        return view('layouts.app', [
            'page' => 'account.showAll',
            'listings' => $listing,
        ]);
    }
}
