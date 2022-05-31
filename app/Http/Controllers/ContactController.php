<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactInfoRequest;
use App\Http\Requests\PcRequest;
use App\Mail\ContactMail;
use App\Models\Contact;
use App\Models\Part;
use App\Models\Pc;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;


class ContactController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function SendContactInfo(ContactInfoRequest $request)
    {
        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $id = $request->input('id');
        $type = $request->input('type');

        error_log($type);

        if ($type === "parts") {
            $previouslyContacted = Contact::where('part_id', $id)->where('email', $email)
                ->orwhere('part_id', $id)->where('phone', $phone)->get();
        } else {
            $previouslyContacted = Contact::where('pc_id', $id)->where('email', $email)
                ->orwhere('pc_id', $id)->where('phone', $phone)->get();
        }

        if (count($previouslyContacted) > 0) {
            return;
        }

        $contact = new Contact();

        $contact->name = $name;
        $contact->email = $phone;
        $contact->phone = $email;

        if ($type === "parts") {
            $contact->part_id = $id;
        } else {
            $contact->pc_id = $id;
        }

        $contact->save();

        if ($type === "parts") {
            $item = Part::findOrFail($id);
        } else {
            $item = Pc::findOrFail($id);
        }

        $listingOwner = \App\Models\User::findOrFail($item->user_id);

        $emailData = [
            'name'=> $name,
            'phone'=> $phone,
            'email'=> $email,
            'item_name'=> $item->title
        ];

        Mail::to($listingOwner->email)->send(new ContactMail($emailData));
    }

}
