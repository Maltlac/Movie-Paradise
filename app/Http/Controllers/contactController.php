<?php

namespace App\Http\Controllers;

use App\Models\User;
use Mailjet\Resources;
use App\Models\Contact;
use App\Mail\contactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Mailjet\LaravelMailjet\Facades\Mailjet;



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
        $mj = new Mailjet(getenv('MAILJET_APIKEY'), getenv('MAILJET_APISECRET'),true,['version' => 'v3']);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'user_id' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $input = $request->all();
        $formdata = $request->except('_token');

        $numeroDemande=Contact::create($input);

        //  Send mail to admin
        $data=[
            'name' => $input['name'],
            'email' => $input['email'],
            'subject' => $input['subject'],
            'message' => $input['message'],
            'id'=>$numeroDemande->id,
        ];
        $formdata['id']=$numeroDemande->id;
        $bodyToAdmin = [
        'FromEmail' => "noreply@movie-paradise.fr",
        'FromName' => "noreply",
        'Recipients' => [
            [
            'Email' => "contact@movie-paradise.fr",
            'Name' => "Admin"
            ]
        ],
        'Subject' => "Demande de contact ",
        'Html-part' => "<p>le numéro de demande : #".$numeroDemande->id." </p><br><p>Nom : ".$data['name']." </p><br> <p>Email : ".$data['email']." </p><br> <p>Objet : ".$data['subject']." </p><br> </p><br> <p>message : ".$data['message']." </p><br> "
        ];
        

            $bodyToCustomer = [
                'FromEmail' => "noreply@movie-paradise.fr",
                'FromName' => "noreply",
                'Subject' => $input['subject'],
                'MJ-TemplateID' => 4805440,
                'Vars' => json_decode(json_encode($formdata), true),
                'MJ-TemplateLanguage' => true,
                'Recipients' => [['Email' => $data['email']]]
              ];

        Mailjet::post(Resources::$Email, ['body' => $bodyToAdmin]);
        Mailjet::post(Resources::$Email, ['body' => $bodyToCustomer]);
        return redirect()->back()->with(['success' => 'Contact Form Submit Successfully']);
    }
}
