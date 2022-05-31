<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactInfoRequest;
use App\Http\Requests\PcRequest;
use App\Mail\ContactMail;
use App\Models\Contact;
use App\Models\Pc;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;


class PcController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
            'computers' => $pcs->orderBy('created_at', 'desc')->paginate(20),
        ]);
    }

    public function CreatePage()
    {
        $this->middleware('auth');

        return view('layouts.app', [
            'page' => 'pcs.create',
        ]);
    }

    public function UpdateStatus(Request $request, $id)
    {
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
        $this->middleware('auth');

        if($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            Image::make($request->file('image'))
                ->save('uploads/' . $filenameToStore);
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
        $this->middleware('auth');

        $pc = Pc::findOrFail($id);
        $currentUserId = Auth::user()->id;

        if(intval($currentUserId) !== intval($pc->user_id) || intval($pc->status_id) !== 1) {
            return redirect('/pcs');
        }

        return view('layouts.app', [
            'page' => 'pcs.edit',
            'computer' => $pc,
        ]);
    }

    public function EditPageSubmit(PcRequest $request, $id)
    {
        $this->middleware('auth');

        $pc = Pc::findOrFail($id);
        $currentUserId = Auth::user()->id;

        if(intval($currentUserId) !== intval($pc->user_id) || intval($pc->status_id) !== 1) {
            return;
        }

        if($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            Image::make($request->file('image'))
                ->save('uploads/' . $filenameToStore);
        }

        $pc->title = $request->input('title');
        $pc->description = $request->input('description');
        $pc->status_id = 1; // active
        $pc->user_id = 1;
        $pc->image_name = $filenameToStore ?? $pc->image_name;;
        $pc->save();

        return redirect()->route('account');
    }
}
