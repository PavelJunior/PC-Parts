<?php

namespace App\Http\Controllers;

use App\Http\Requests\PcRequest;
use App\Http\Requests\PcRequestEdit;
use App\Http\Traits\PictureUtils;
use App\Models\Pc;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class PcController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, PictureUtils;

    public function ShowAll()
    {
        $query = $_GET['query'] ?? '';

        $pcs = Pc::where('status_id', '1');

        if ($query !== '') {
            $pcs->where('title', 'LIKE', '%' . $query . '%')
                ->orwhere('description', 'LIKE', '%' . $query . '%');
        }


        return view('layouts.app', [
            'page' => 'pcs.showAll',
            'computers' => $pcs->orderBy('created_at', 'desc')->paginate(2),
        ]);
    }

    public function CreatePage()
    {
        if (!Auth::check()) {
            return redirect()->route('pcs');
        }

        $this->middleware('auth');

        return view('layouts.app', [
            'page' => 'pcs.create',
        ]);
    }

    public function UpdateStatus(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('pcs');
        }

        $userId = Auth::user()->id;
        $pc = Pc::findOrFail($id);

        if (intval($userId) !== intval($pc->user_id)){
            return;
        }

        $newStatus = $request->input('status');
        if ($newStatus === 'sold') {
            $pc->status_id = 2;
        } elseif ($newStatus === 'deleted') {
            $pc->status_id = 3;
        }

        $pc->save();
    }

    public function CreatePageSubmit(PcRequest $request)
    {
        if (!Auth::check()) {
            return redirect()->route('pcs');
        }

        $this->middleware('auth');

        if($request->hasFile('image')) {
            $filenameToStore = $this->ConvertAndSaveImage($request->file('image'));
        }

        $user = Auth::user();

        $pc = new Pc();

        $pc->title = $request->input('title');
        $pc->description = $request->input('description');
        $pc->status_id = 1; // active
        $pc->user_id = $user->id;
        $pc->image_name = $filenameToStore;
        $pc->save();

        return redirect()->route('account');
    }


    public function EditPage($id)
    {
        if (!Auth::check()) {
            return redirect()->route('pcs');
        }

        $this->middleware('auth');

        $pc = Pc::findOrFail($id);
        $currentUserId = Auth::user()->id;

        if(intval($currentUserId) !== intval($pc->user_id) || intval($pc->status_id) !== 1) {
            return redirect('pcs');
        }

        return view('layouts.app', [
            'page' => 'pcs.edit',
            'computer' => $pc,
        ]);
    }

    public function EditPageSubmit(PcRequestEdit $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('pcs');
        }

        $this->middleware('auth');

        $pc = Pc::findOrFail($id);
        $currentUserId = Auth::user()->id;

        if(intval($currentUserId) !== intval($pc->user_id) || intval($pc->status_id) !== 1) {
            return;
        }

        if($request->hasFile('image')) {
            $filenameToStore = $this->ConvertAndSaveImage($request->file('image'));
        }

        $pc->title = $request->input('title');
        $pc->description = $request->input('description');
        $pc->status_id = 1; // active
        $pc->user_id = $currentUserId;
        $pc->image_name = $filenameToStore ?? $pc->image_name;;
        $pc->save();

        return redirect()->route('account');
    }
}
