<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Str;
use Cache;
use Yajra\DataTables\Exceptions\Exception;
class ContactController extends Controller
{
    public function index()
    {
        // return request();//this equal to Request $request
        $order_by = request()->orderby ?? 'desc'; //insread of adding the request with default like sort by

        $contacts = Contact::
            when(request()->keyword ?? null, function ($q) {
                $q->where('name', 'like', '%' . request()->keyword . '%')
                    ->orwhere('email', 'like', '%' . request()->keyword . '%');
            })
            ->when(!is_null(request()->status), function ($q) {
                $q->where('status', request()->status);
            })
            ->orderBy(request('sortby', 'id'), $order_by)
            ->paginate(request('limit', 5));

        return view('admin.contacts.index', compact('contacts'));
    }
    public function show(Contact $contact)
    {
        $contact->update([
            'status' => 1
        ]);
        return view('admin.contacts.show', compact('contact'));
    }
    public function destroy(Contact $contact)
    {

        $contact->delete();
        Session::flash('success', 'contact deleted');
        return redirect()->route('admin.contacts.index');
    }
}
