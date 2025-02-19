<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Mailjet\Resources;
use App\Models\ebillet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\DomCrawler\Crawler;
use Mailjet\LaravelMailjet\Facades\Mailjet;
use Illuminate\Pagination\LengthAwarePaginator;

class ebilletController extends Controller
{
    private $client;
    /**
     * Class __contruct
     */
    public function __construct()
    {
        $this->client = new Client([
                'timeout'   => 10,
                'verify'    => false
            ]);
    }
    public function home()
    {
        $url='https://www.allocine.fr/salle/';
            $response = $this->client->get($url); 
            $content = $response->getBody()->getContents();
            $crawler = new Crawler( $content );
            
            $_this = $this;
            $data = $crawler->filter('.mdl-more-li')
                            ->each(function (Crawler $node, $i) use($_this) {
                                return $_this->getNodeContentDep($node);
                            }
                        );       
        sort($data);

        return view('ebillet/home',[
            'links'=>$data,
        ]);
    }
    public function regionCinema($dep){
            $url='https://www.allocine.fr/salle/cinema/'.$dep;
            $response = $this->client->get($url); 
            $content = $response->getBody()->getContents();
            $crawler = new Crawler( $content );
            $fistname=$crawler->filter('div.theater-infos .title')->text();
            $_this = $this;
            //dd($crawler);
            $data = $crawler->filter('div.theater-infos')
                            ->each(function (Crawler $node, $i) use($_this) {
                                return $_this->getNodeContentCine($node);
                            }
                        );


            $url='https://www.allocine.fr/salle/cinema/'.$dep.'/?page=2';
            $response = $this->client->get($url);
            $content = $response->getBody()->getContents();
            $crawler = new Crawler( $content );
            $i=2;
            
            while ($crawler->filter('title')->text()!="Salles de cinéma en France - AlloCiné" && $crawler->filter('div.theater-infos .title')->text()!=$data[0]["nom"] && $crawler->filter('div.theater-infos .title')->text()!=$fistname ) {
                $fistname=$crawler->filter('div.theater-infos .title')->text();
                $data2 = $crawler->filter('div.theater-infos')->each(function (Crawler $node, $i) use($_this) {
                    return $_this->getNodeContentCine($node);
                });
                $i++;
                $url='https://www.allocine.fr/salle/cinema/'.$dep.'/?page='.$i;
                $response = $this->client->get($url);
                $content = $response->getBody()->getContents();
                $crawler = new Crawler( $content );
                
                $data=array_merge($data, $data2);
            }
            $data = $this->paginate($data, 15);
            $data->withPath('');
           // dd($data);
        return view('ebillet.cinema', compact('data'));       
    }

    public function seanceCinema($urlCode){
        $url='https://www.allocine.fr/seance/salle_gen_csalle='.$urlCode.'.html';
        $response = $this->client->get($url); 
        $content = $response->getBody()->getContents();
        $crawler = new Crawler( $content );
        
        $_this = $this;
        $nomcine=$crawler->filter("div.theater-cover-title")->text();
        $data[] = $crawler->filter('div.movie-card-theater')
                        ->each(function (Crawler $node, $i) use($_this) {
                            return $_this->getNodeContentSeance($node);
                        }
                    );
        for ($i=1; $i < 7; $i++) { 
            $url='https://www.allocine.fr/seance/d-'.$i.'/salle_gen_csalle='.$urlCode.'.html';
            $response = $this->client->get($url); 
            $content = $response->getBody()->getContents();
            $crawler = new Crawler( $content ); 
            $_this = $this; 
            $data[] = $crawler->filter('div.movie-card-theater')->each(function (Crawler $node, $i) use($_this) {return $_this->getNodeContentSeance($node);});
        }
        $data=array_filter($data);
        $data = $this->paginate($data, 1);
        $data->withPath('');   
        return view('ebillet.seance', compact('data','nomcine'));    
        
    }

    private function getNodeContentDep($node)
    {
        $array = [
            'dep' => $this->hasContent($node->filter('a.mdl-more-item'))!= false ? $node->filter('a.mdl-more-item')->attr('title')  : '',
            'lien' => $this->hasContent($node->filter('a.mdl-more-item'))!= false ? $node->filter('a.mdl-more-item')->attr('href')  : '',  
        ];
        return $array;
    }

    private function getNodeContentCine($node)
    {

            
            $array = [
                'image' => $this->hasContent($node->filter('img')) != false ? $node->filter('img.thumbnail-img')->attr('data-src') : '',
                'nom' => $this->hasContent($node->filter(".title")) != false ? $node->filter(".title")->text() : '',
                'lien' => $this->hasContent($node->filter(".title")->children() )!= false ? $node->filter(".title")->children()->attr('href')  : '',
                'adresse' => $this->hasContent($node->filter('address.address')) != false ? $node->filter('address.address')->text() : '',
                'salle' => $this->hasContent($node->filter('div.screen-number')) != false ? $node->filter('div.screen-number')->text() : '',
            ];
            if ($node->filter(".title")->children()->attr('href')==null) {
                $dataCinema= $this->hasContent($node->filter("span.add-theater-anchor"))!= false ? $node->filter("span.add-theater-anchor")->attr('data-theater')  : '';
                $lien=explode('"' ,$dataCinema);
                $array['lien']=$lien[3];
            }else {
                $array['lien']=substr($array['lien'], 25,5);
            }

            return $array;
        
        
    }
    private function getNodeContentSeance($node)
    {
        $_this = $this;
        $array = [
            'image' => $this->hasContent($node->filter('img.thumbnail-img')) != false ? $node->filter('img.thumbnail-img')->attr('data-src') : '',
            'titreFilm' => $this->hasContent($node->filter(".meta-title")) != false ? $node->filter(".meta-title")->text() : '',
            'infoDivers' => $this->hasContent($node->filter('div.meta-body-info')) != false ? $node->filter('div.meta-body-info')->text() : '',
            'infoActeur' => $this->hasContent($node->filter('div.meta-body-actor')) != false ? $node->filter('div.meta-body-actor')->text() : '',
            'infoReal' => $this->hasContent($node->filter('div.meta-body-direction')) != false ? $node->filter('div.meta-body-direction')->text() : '',
            'synopsis' => $this->hasContent($node->filter('div.synopsis')) != false ? $node->filter('div.synopsis')->text() : '',
            'date' => $this->hasContent($node->filter('div.text')) != false ? $node->filter('div.text')->text() : '',
            'seance'=>$node->filter('div.showtimes-hour-block')->each(function (Crawler $node, $i) use($_this) {return $_this->getNodeContentSeanceH($node);}),
            
            //'salle' => $this->hasContent($node->filter('div.screen-number')) != false ? $node->filter('div.screen-number')->text() : '',
        ];
        if ($array['image']==null) {
            $array['image']=$node->filter('img.thumbnail-img')->attr('src');
        }
        return $array;
    }
    private function getNodeContentSeanceH($node)
    {
        $array = [
            'heure' => $this->hasContent($node->filter('span.showtimes-hour-item-value'))!= false ? $node->filter('span.showtimes-hour-item-value')->text()  : '',  
        ];
        return $array;
    }

    private function hasContent($node)
    {
        return $node->count() > 0 ? true : false;
    }
    public function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function reservationEbillet(Request $request){
       // $mj = new Mailjet(getenv('MAILJET_APIKEY'), getenv('MAILJET_APISECRET'),true,['version' => 'v3']);

        $ebillet=new ebillet;
        $ebillet->user_id=Auth::user()->id;
        $ebillet->ticket1=$request->quant[1];
        $ebillet->ticket2=$request->quant[2];
        $ebillet->ticket3=$request->quant[3];
        $ebillet->cine=$request->cine;
        $ebillet->titreFilm=$request->titre;
        $ebillet->seance= $request->date."".$request->heure;
        $ebillet->total=$request->totalPlace;
        $ebillet->save();
        
        $formdata=[
            'id'=>$ebillet->id,
            'name'=>Auth::user()->name,
            'billet1'=>"Nombre de billets plein tarif".$request->quant[1],
            'billet2'=>"Nombre de billets moins de 18ans".$request->quant[2],
            'billet3'=>"Nombre de billets etudiant".$request->quant[3],
            'cine'=>$request->cine,
            'titreFilm'=>$request->titre,
            'seance'=> $request->date." ".$request->heure,
            'total'=>$request->totalPlace."€",
            'date'=>Carbon::now(),
            'ticket1'=>$request->quant[1],
            'ticket2'=>$request->quant[2],
            'ticket3'=>$request->quant[3],
        ];
        $formdata1=[
            'id'=>$ebillet->id,
            'name'=>Auth::user()->name,
            'billet1'=>"Nombre de billets plein tarif".$request->quant[1],
            'billet2'=>"Nombre de billets moins de 18ans".$request->quant[2],
            'billet3'=>"Nombre de billets etudiant".$request->quant[3],
            'cine'=>$request->cine,
            'titre'=>$request->titre,
            'seance'=> $request->date." ".$request->heure,
            'total'=>$request->totalPlace."€",
            'date'=>Carbon::now(),
        ];


          
          $bodyResetMDP = [
              'FromEmail' => "noreply@movie-paradise.fr",
              'FromName' => "noreply",
              'Subject' => "Confirmation de commande",
              'MJ-TemplateID' => 4822770,
              'Vars' => json_decode(json_encode($formdata1), true),
              'MJ-TemplateLanguage' => true,
              'Recipients' => [['Email' => Auth::user()->email]]
            ];

       $stat=Mailjet::post(Resources::$Email, ['body' => $bodyResetMDP]);
        return view("ebillet.commandeConfirm", compact('formdata'))->with('message', 'Merci pour votre commande');
    }
}
