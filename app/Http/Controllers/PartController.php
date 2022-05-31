<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartRequest;
use App\Models\Part;
use App\Models\PartCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class PartController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ShowAll()
    {
        $query = $_GET['query'] ?? '';
        $categories = array_key_exists('categories', $_GET) ? explode(',', $_GET['categories']) : null;

        $parts = Part::where('status_id', '1');

        if ($query !== '') {
            $parts->where('title', 'LIKE', '%' . $query . '%')
                ->orwhere('description', 'LIKE', '%' . $query . '%');
        }

        if ($categories !== null) {
            $parts->where('category_id', $categories);
        }

        $allCategories = PartCategory::all();


        return view('layouts.app', [
            'page' => 'parts.showAll',
            'parts' => $parts->orderBy('created_at', 'desc')->paginate(20),
            'categories' => $allCategories,
        ]);
    }

    public function CreatePage()
    {
        $this->middleware('auth');

        $categories = PartCategory::all();

        return view('layouts.app', [
            'page' => 'parts.create',
            'categories' => $categories
        ]);
    }

    public function UpdateStatus(Request $request, $id)
    {
        $userId = Auth::user()->id;
        $part = Part::findOrFail($id);

        if (intval($userId) !== intval($part->user_id)){
            return;
        }

        $newStatus = $request->input('status');
        if ($newStatus === 'sold') {
            $part->status_id = 2;
        } elseif ($newStatus === 'deleted') {
            $part->status_id = 3;
        }

        $part->save();
    }

    public function CreatePageSubmit(PartRequest $request)
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

        $part = new Part();

        $part->title = $request->input('title');
        $part->description = $request->input('description');
        $part->category_id = $request->input('category');
        $part->status_id = 1; // active
        $part->user_id = $user->id;
        $part->image_name = $filenameToStore;
        $part->save();

        return redirect()->route('account');
    }


    public function EditPage($id)
    {
        $this->middleware('auth');

        $part = Part::findOrFail($id);
        $currentUserId = Auth::user()->id;

        if(intval($currentUserId) !== intval($part->user_id) || intval($part->status_id) !== 1) {
            return redirect('/parts');
        }

        $categories = PartCategory::all();


        return view('layouts.app', [
            'page' => 'parts.edit',
            'part' => $part,
            'categories' => $categories,
        ]);
    }

    public function EditPageSubmit(PartRequest $request, $id)
    {
        $this->middleware('auth');

        $part = Part::findOrFail($id);
        $currentUserId = Auth::user()->id;

        if(intval($currentUserId) !== intval($part->user_id) || intval($part->status_id) !== 1) {
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

        $part->title = $request->input('title');
        $part->description = $request->input('description');
        $part->category_id = $request->input('category');
        $part->status_id = 1; // active
        $part->user_id = 1;
        $part->image_name = $filenameToStore ?? $part->image_name;;
        $part->save();

        return redirect()->route('account');
    }
}
