<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Mail\contactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class contactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function contactForm(){
        $userId=Auth::user()->id;
        $user=User::find($userId);
        return view('contact',[
            'user'=>$user,
        ]);
    }

    public function storeContactForm(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'user_id' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $input = $request->all();

        Contact::create($input);

        //  Send mail to admin
        $data=[
            'name' => $input['name'],
            'email' => $input['email'],
            'subject' => $input['subject'],
            'message' => $input['message'],
        ];
        $mailData = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => $data
        ];
        Mail::to('contact@movie-paradise.fr')->send(new contactMail($mailData));

           
        dd("Email is sent successfully.");
        /*Mail::send('contactMail', array(
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'subject' => $input['subject'],
            'message' => $input['message'],
        ), function($message) use ($request){
            $message->from($request->email);
            $message->to('contact@movie-paradise.fr', 'Admin')->subject($request->get('subject'));
        });

        return redirect()->back()->with(['success' => 'Contact Form Submit Successfully']);*/
    }
}
