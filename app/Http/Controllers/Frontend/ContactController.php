<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;
use App\Models\Admin;
use App\Models\Autherization;
use App\Models\Contact;
use App\Notifications\NewContactNotify;
use Illuminate\Http\Request;
use Notification;
use Session;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact-us');
    }
    public function store(ContactRequest $request)
    {
        // $data = $request->validated(); //return validated data only without token if the phone not in the validation the data not contain the phone
        // $data['ip_address'] = $request->ip();
        // Contact::create($data);

        //anthor solution
        $request->validated();
        $request->merge([
            'ip_address' => $request->ip()
        ]);
        $contact = Contact::create($request->all()); //$request->all() validated data and if there is a key not in validtion will be appear with token
        if (!$contact) {
            Session::flash('error', 'Contact us faild');
        }
        $rolesIds=[];
        foreach(Autherization::all() as $authrization){
            foreach ($authrization->permessions as $permession) {
                if($permession=="contacts"){
                    $rolesIds[] = $authrization->id;
                }
            }
        }

        $admins = Admin::whereIn('autherization_id',$rolesIds)->where('status', 1)->get();
        Notification::send($admins, new NewContactNotify($contact));

        Session::flash('success', 'Contact you soon');
        return redirect()->back();
    }
}
