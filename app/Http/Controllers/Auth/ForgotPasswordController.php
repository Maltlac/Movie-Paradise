<?php

 
namespace App\Http\Controllers\Auth; 
  
use Carbon\Carbon; 
use App\Models\User; 
use Mailjet\Resources;
use Illuminate\Support\Str;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Mailjet\LaravelMailjet\Facades\Mailjet;

use function PHPUnit\Framework\isNull;

class ForgotPasswordController extends Controller
{
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return view('auth/passwords/forgetPassword');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
        $mj = new Mailjet(getenv('MAILJET_APIKEY'), getenv('MAILJET_APISECRET'),true,['version' => 'v3']);
          $request->validate([
              'email' => 'required|email|exists:users',
          ]);
          $token=Str::random(64);
          $tokenMAil ="https://movieparadise.site/reset-password/".$token;
          
  
          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
            $user=User::where('email',$request->email)->get();
            $formdata=[
                'token'=>$tokenMAil,
                'name'=>$user[0]->name,
            ];
            
            $bodyResetMDP = [
                'FromEmail' => "noreply@movie-paradise.fr",
                'FromName' => "noreply",
                'Subject' => "Rénitialisation mot de passe",
                'MJ-TemplateID' => 4805544,
                'Vars' => json_decode(json_encode($formdata), true),
                'MJ-TemplateLanguage' => true,
                'Recipients' => [['Email' => $request->email]]
              ];

        Mailjet::post(Resources::$Email, ['body' => $bodyResetMDP]);
  
          return back()->with('message', 'We have e-mailed your password reset link!');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 
        $tokenValide=DB::select("Select * FROM password_resets WHERE token= '".$token."' limit 1");
        $dt = Carbon::now()->addHour(3);

       
          if (isNull($token[0]) || $tokenValide[0]->created_at>$dt  ) {
            $tokenValide[0]->delete();
            return abort(419);
          }else{
            return view('auth/passwords/forgetPasswordLink', ['token' => $token]);
          }
        
        
         
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {

          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:8|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
          return redirect('/login')->with('message', 'Your password has been changed!');
      }
}