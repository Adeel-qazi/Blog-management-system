<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index(){
        return view('contact');
    }

    public function store(Request $request){


        $data = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);  // first apply the validation on form then get the data

        if($data->fails()){
            return redirect()->back()->withErrors($data)->withInput();
        }

        // Mail::to($request->user())->send(new MailableClass);
        Mail::to('aadeelraza21@gmail.com')->send(new Contact($request)); // we pass to data into mail then it leads to Contact mail

        session()->flash('success','Thank you you`ll be in touch soon');
        return redirect()->route('contact.index');



    }
}
