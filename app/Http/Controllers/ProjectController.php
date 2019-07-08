<?php

namespace App\Http\Controllers;

use App\Additionalcontent;
use App\Callforpaper;
use App\Confgallery;
use App\Download;
use App\Idatemenu;
use App\Importantdate;
use App\Quicklink;
use App\Registration;
use App\Regsubmenu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Targetorg;
use App\Ocm;
use App\Ocmsubtitle;
use App\Ocmtitle;
use App\Registrationmenu;
use App\Regcategory;
use App\Regtype;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getbyUser($userid)
    {
        $projbyUser = Targetorg::where('user_id', $userid)->get();

        return response()->json($projbyUser);
    }

    public function getProject($id)
    {
        $projdetails = Targetorg::where('id', $id)->with(array('impdates' => function($query){
            $query->select('id','targetorg_id','idatemenus_id','impdate','priority')->orderby('priority')
                ->with(array('idatemenu' => function($query){
                    $query->select('id','idatemenu');
                }));
        }))->with(array('downloads' => function($query){
            $query->select('id', 'targetorg_id','filename','download_link','priority')->orderby('priority');
        }))->with(array('quicklinks' => function($query){
            $query->select('id','targetorg_id','link_label','link','priority')->orderby('priority');
        }))->with(array('cpapers' => function($query){
            $query->select('id','targetorg_id','topic','callforpaper');
        }))->with(array('additionalcontents' => function($query){
            $query->select('id','targetorg_id','titleplace','title','content','content_type','image_path');
        }))->with(array('galleries' => function($query){
        $query->select('id','targetorg_id','gallery_title','gallery');
    }))->get();



        $ocmtitles = Targetorg::select('id')->where('id',$id)->with(array(''));

        return response()->json(['projdetails' => $projdetails]);
    }

    public function getOcm($id)
    {

        $ocm = Targetorg::select('id')->where('id', $id)->with(array('ocmtitles' => function($query){
            $query->select('id','targetorg_id','ocmtitle','priority')->with(array('ocmsubtitles' => function($query){
                $query->select('id','ocmtitle_id','ocmsubtitle','priority')->with(array('ocms' => function($query){
                    $query->select('id','targetorg_id','ocmsubtitle_id','name','designation','department','profile_image_path','college','place','country','priority')
                        ->orderby('priority');
                }))->orderby('priority');
            }))->orderby('priority');
        }))->get();

        $ocmtitles = Targetorg::select('id')->where('id',$id)->with(array(''));

        return response()->json(['ocms' => $ocm]);
    }

    public function getReg($id)
    {
        $reg = Targetorg::select('id')->where('id', $id)->with(array('regmenus' => function($query){
            $query->select('id','targetorg_id','regmenu')->with(array('regsmenus' => function($query){
                $query->select('id','regmenu_id','regsubmenu')->with(array('categories' => function($query){
                    $query->select('id','regsubmenu_id','category')->with(array('registrations' => function($query){
                        $query->select('id', 'regcat_id', 'amount');
                    }));
                }));
            }))->with(array('regtypes' => function($query){
                $query->select('id','regmenu_id', 'reg_type', 'currency_type',  'reg_type_date')->orderBy('currency_type','desc'); }));
        }))->get();

        $menus = Registrationmenu::select('id')->where('targetorg_id',4)->with(array('regsmenus' => function($query){
            $query->select('regmenu_id','regsubmenu');
        }))->get();

        return response()->json(['regs' => $reg, 'menus' => $menus]);
    }

    public function addRCategory($tid, $regmenuid, $regsmenuid, Request $request){

        $match = ['targetorg_id' => $tid, 'regmenu_id' => $regmenuid];

        $rtype = Regtype::select('id')->where($match)->get()->toArray();

        $regtype = array();

        for($i = 0; $i<sizeof($rtype); $i++ ){
            array_push($regtype, $rtype[$i]['id']);
        }

       // dd($regtype);

        $regcatid = Regcategory::create([
            'targetorg_id' => $tid,
            'regsubmenu_id' => $regsmenuid,
            'category' => $request->category
        ]);

        foreach ($regtype as $row){
            $reg[] = [
                'targetorg_id' => $tid,
                'regcat_id' => $regcatid->id,
                'regtype_id' => $row,
                'amount' => 100
            ];
        }

        if(!empty($reg)){
            Registration::insert($reg);
        }



    }

    public function addRCurtype($tid, $regmenuid, Request $request){

        $match1 = ['targetorg_id' => $tid, 'regmenu_id' => $regmenuid];
        $match2 = ['targetorg_id' => $tid];

        $rtype = Regtype::select('id','reg_type','reg_type_date')->where($match1)->get()->toArray();
        //$rtype = array_unique($rtype);
        $rtypestatic = array(['reg_type' => 'Early Bird Registration', 'reg_type_date' => Carbon::now()->format('Y-m-d')],
            ['reg_type' => 'Standard Registration', 'reg_type_date' => Carbon::now()->format('Y-m-d')],
            ['reg_type' => 'Late Registration', 'reg_type_date' => Carbon::now()->format('Y-m-d')]);
        $regtype = array();
        $regtupdated = array();
        $reghelp = array();

        //dd($rtypestatic);

        if(!empty($rtype)){
            for($i = 0; $i<sizeof($rtype); $i++ ){
                $regtype[$rtype[$i]['id']] = $rtype[$i]['reg_type'];

                if(!in_array($rtype[$i]['reg_type'], $reghelp)){
                    array_push($regtupdated, array_search($rtype[$i]['reg_type'], $regtype));

                    $rtyp[] = [
                        'targetorg_id' => $tid,
                        'regmenu_id' => $regmenuid,
                        'reg_type' => $rtype[$i]['reg_type'],
                        'currency_type' => $request->curtype,
                        'reg_type_date' => $rtype[$i]['reg_type_date'],
                    ];
                }

                array_push($reghelp, $rtype[$i]['reg_type']);

            }
        }

        else{
            for($i=0; $i<sizeof($rtypestatic); $i++){

                $rtyp[] = [
                    'targetorg_id' => $tid,
                    'regmenu_id' => $regmenuid,
                    'reg_type' => $rtypestatic[$i]['reg_type'],
                    'currency_type' => 'USD',
                    'reg_type_date' => $rtypestatic[$i]['reg_type_date'],
                ];
            }
        }



        //$regtype = array_unique($regtype);
        //dd($rtyp);


        $rsubm = Regsubmenu::select('id')->where($match1)->get()->toArray();

        $rsmenu = array();

        for($i = 0; $i<sizeof($rsubm); $i++ ){
            array_push($rsmenu, $rsubm[$i]['id']);
        }


        //dd($rcategory);

        $rcat = Regcategory::select('id')->whereIn('regsubmenu_id',$rsmenu)->get()->toArray();

        $rcategory = array();

        for($i = 0; $i<sizeof($rcat); $i++ ){
            array_push($rcategory, $rcat[$i]['id']);
        }

        //dd($rcategory);

        Regtype::insert($rtyp);

        $lastIds = Regtype::orderBy('id','desc')->take(count($rtyp))->pluck('id')->toArray();

        //dd($lastIds);

        for($i=0; $i < sizeof($rcategory); $i++){
            for($j=0; $j < sizeof($lastIds); $j++){
                $reg[] = [
                    'targetorg_id' => $tid,
                    'regcat_id' => $rcategory[$i],
                    'regtype_id' => $lastIds[$j],
                    'amount' => 100
                ];
            }
        }


        Registration::insert($reg);
    }

    public function addRegtype($tid, $regmenuid, Request $request){
        $match1 = ['targetorg_id' => $tid, 'regmenu_id' => $regmenuid];
        $match2 = ['targetorg_id' => $tid];

        $regcur = Regtype::select('currency_type')->where($match1)->groupBy('currency_type')->get()->toArray();
        $cur = array();

        for($i=0; $i < sizeof($regcur); $i++){
            array_push($cur,$regcur[$i]['currency_type']);
        }

        for($i=0; $i < sizeof($cur); $i++){
            $rtyp[] = [
                'targetorg_id' => $tid,
                'regmenu_id' => $regmenuid,
                'reg_type' => $request->regtype,
                'currency_type' => $cur[$i],
                'reg_type_date' => $request->regdate,
            ];
        }

        Regtype::insert($rtyp);

        $lastIds = Regtype::orderBy('id','desc')->take(count($rtyp))->pluck('id')->toArray();

        //dd($lastIds);

        $rsubm = Regsubmenu::select('id')->where($match1)->get()->toArray();

        $rsmenu = array();

        for($i = 0; $i<sizeof($rsubm); $i++ ){
            array_push($rsmenu, $rsubm[$i]['id']);
        }

        $rcat = Regcategory::select('id')->whereIn('regsubmenu_id',$rsmenu)->get()->toArray();
        $rcategory = array();

        for($i = 0; $i<sizeof($rcat); $i++ ){
            array_push($rcategory, $rcat[$i]['id']);
        }


        for($i=0; $i < sizeof($rcategory); $i++){
            for($j=0; $j < sizeof($lastIds); $j++){
                $reg[] = [
                    'targetorg_id' => $tid,
                    'regcat_id' => $rcategory[$i],
                    'regtype_id' => $lastIds[$j],
                    'amount' => 100
                ];
            }
        }

        Registration::insert($reg);
    }

    public function addRSubmenu($tid, $regmenuid, Request $request)
    {
        $regsmenu = $request->regsmenu;

        Regsubmenu::create([
            'targetorg_id' => $tid,
            'regmenu_id' => $regmenuid,
            'regsubmenu' => $regsmenu
        ]);
    }

    public function addRMenu($tid, Request $request)
    {
        $regmenu = $request->regmenu;
        Registrationmenu::create([
            'targetorg_id' => $tid,
            'regmenu' => $regmenu,
        ]);
    }

    public function addImpDate($tid, Request $request)
    {
        $idmenu = $request->idatemenu;

        $data =Idatemenu::create([
            'targetorg_id' => $tid,
            'idatemenu' => $idmenu
        ]);

        Importantdate::create([
            'targetorg_id' => $tid,
            'idatemenus_id' => $data->id,
            'impdate' => $request->idate,
            'priority' => 1
        ]);
    }

    public function addCFpaper($tid, Request $request)
    {
        $topic = $request->topic;
        $cpaper = $request->cpaper;
        $cpaper = explode(',', $cpaper);

        //dd($cpaper);

        Callforpaper::create([
            'targetorg_id' => $tid,
            'topic' => $topic,
            'callforpaper' => $cpaper
        ]);
    }

    public function addQlinks($tid, Request $request)
    {
        $llabel = $request->linklabel;
        $link = $request->link;

        Quicklink::create([
            'targetorg_id' => $tid,
            'link_label' => $llabel,
            'link' => $link,
            'priority' => 1
        ]);
    }

    public function addDownload($tid, Request $request)
    {
        $dlabel = $request->downlabel;
        $dlink = $request->downlink;

        Download::create([
            'targetorg_id' => $tid,
            'filename' => $dlabel,
            'download_link' => $dlink,
            'priority' => 1
        ]);
    }

    public function addAcontent($tid, Request $request)
    {
        $title = $request->title;
        $acontent = $request->acontent;
        $acontent = explode(',', $acontent);
        $imgpath = array();

        Additionalcontent::create([
            'targetorg_id' => $tid,
            'titleplace' => 'place',
            'title' => $title,
            'content' => $acontent,
            'content_type' => 'paragraph',
            'image_path' => $imgpath,
        ]);
    }

    public function addCGallery($tid, Request $request)
    {
        $images = array();
        $imgpath = array();
        $images = $request->images;
        $gtitle = $request->gtitle;
        //dd($images);

        for($i=0; $i < sizeof($images); $i++ ){

            if($images[$i] != ''){
                $name = rand().'.'.explode('/', explode(':', substr($images[$i], 0, strpos($images[$i], ';')))[1])[1];
                \Image::make($images[$i])->save(public_path('images/confgallery/').$name);
                $imgpath[] = '/images/confgallery/'.$name;
            }

        }

        //dd($imgpath);

        Confgallery::create([
            'targetorg_id' => $tid,
            'gallery_title' => $gtitle,
            'gallery' => $imgpath,
        ]);


    }

    public function addCImages($tid, $gid, Request $request)
    {
        $images = array();
        $gallery = array();
        $imgpath = array();
        $images = $request->images;

        for($i=0; $i < sizeof($images); $i++ ){

            if($images[$i] != ''){
                $name = rand().'.'.explode('/', explode(':', substr($images[$i], 0, strpos($images[$i], ';')))[1])[1];
                \Image::make($images[$i])->save(public_path('images/confgallery/').$name);
                $imgpath[] = '/images/confgallery/'.$name;
            }

        }

        $confgal = Confgallery::where('id', $gid)->firstOrFail();

        $gallery = $confgal->gallery;

        //dd($imgpath);

        $imgpath = array_merge($gallery, $imgpath);

        //dd($imgpath);

        $confgal->update(['gallery' => $imgpath]);
        $confgal->save();
    }

    public function deleteRCategory($catid){
        $regcat = Regcategory::find($catid);
        $regcat->registrations()->delete();
        $regcat->delete();
        return response()->json($regcat);
    }

    public function deleteCRtype($regtypeid){
        $regtype = Regtype::find($regtypeid);
        $regtype->registrations()->delete();
        $regtype->delete();
        return response()->json($regtype);
    }

    public function deleteRsmenu($regsmenuid)
    {
        $regsmenu = Regsubmenu::find($regsmenuid);
        $regcat = Regcategory::where('regsubmenu_id',$regsmenuid)->with('registrations');
        $regcat->delete();
        $regsmenu->delete();
        //dd($regcat->with('registrations'));
    }

    public function deleteRmenu($regmenuid)
    {
        $regmenu = Registrationmenu::where('id',$regmenuid)->with('regtypes');
        $regsmenu = Regsubmenu::where('regmenu_id', $regmenuid)->with(array('categories' => function($query){
            $query->with('registrations');
        }));

        $regsmenu->delete();
        $regmenu->delete();
    }

    public function deleteIdate($idmenuid)
    {
        $idmenu = Idatemenu::where('id', $idmenuid)->with('importantdates');
        $idmenu->delete();
    }

    public function deleteCFPaper($cfpid)
    {
        $cpaper = Callforpaper::where('id', $cfpid)->delete();
    }

    public function deleteQlinks($qlid)
    {
        $qlinks = Quicklink::where('id', $qlid)->delete();
    }

    public function deleteDownload($did)
    {
        $download = Download::where('id', $did)->delete();
    }

    public function deleteAContent($acid)
    {
        $acontent = Additionalcontent::where('id', $acid)->delete();
    }

    public function deleteGallery($gid)
    {
        $confgal = Confgallery::where('id', $gid)->firstOrFail();
        $status = null;

        $gallery = $confgal->gallery;

        foreach($gallery as $image){
           // dd($image);
            if(File::exists(public_path($image))){
                //dd($image);
                File::delete(public_path($image));
                $status = 'deleted';
            }
        }

        if($status == 'deleted') {
            $confgal->delete();
        }



        //dd($gallery);
    }

    public function deleteGImage($gid, $gname)
    {
        $confgal = Confgallery::where('id', $gid)->firstOrFail();
        $gallery = $confgal->gallery;

        $ugallery = $gallery;
    }

    public function insertOcm($tid, $ocmsubid, Request $request)
    {
        $image = $request->imageFile;

        if($request->imageFile != ''){
            $name = time().'.'.explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->imageFile)->save(public_path('images/ocm/').$name);
            $imgpath = '/images/ocm/'.$name;
        }

        else{
            $imgpath = '/images/admin.png';
        }

        Ocm::create([
            'targetorg_id' => $tid,
            'ocmsubtitle_id' => $ocmsubid,
            'name' => $request->name,
            'designation' => $request->dnation,
            'profile_image_path' => $imgpath,
            'college' => $request->college,
            'department' => $request->dept,
            'place' => $request->place,
            'country' => $request->country,
            'priority' => '1',
            'user_id' => 102
        ]);

    }

    public function insertOcmtitle($tid, Request $request)
    {
        Ocmtitle::create([
            'targetorg_id' => $tid,
            'ocmtitle' => $request->title,
            'priority' => '1'
        ]);
    }

    public function insertOcmsub($tid, $ocmtid, Request $request)
    {
        Ocmsubtitle::create([
            'targetorg_id' => $tid,
            'ocmtitle_id' => $ocmtid,
            'ocmsubtitle' => $request->stitle,
            'priority' => '1'
        ]);
    }

    public function updateOcm($tid, $ocmid, Request $request)
    {
        $name = $request->name;
        $dnation = $request->dnation;
        $college = $request->college;
        $dept = $request->dept;
        $place = $request->place;
        $country = $request->country;

        $uocm = Ocm::where('id', $ocmid)->update(['name' => $name, 'designation' => $dnation, 'college' => $college,
            'department' => $dept, 'place' => $place, 'country' => $country]);
        return response()->json($uocm);
    }

    public function updateOcmtitle($tid, $ocmtid, Request $request)
    {
        $title = $request->title;
        $uocmtitle = Ocmtitle::where('id', $ocmtid)->update(['ocmtitle' => $title]);
        return response()->json($uocmtitle);
    }

    public function updateOcmsub($tid, $ocmsid, Request $request)
    {
        $stitle = $request->stitle;
        $uocmsub = Ocmsubtitle::where('id', $ocmsid)->update(['ocmsubtitle' => $stitle]);
        return response()->json($uocmsub);
    }

    public function updateOcmPriority($tid, $ocmid, Request $request)
    {
        //$ocmid = $request->id;
        //dd($ocmid);
        $priority = $request->priority;
        $ocm = Ocm::where('id',$ocmid)->update(['priority' => $priority]);
        return response()->json($ocm);

    }

    public function updateOcmImage($tid, $ocmid, Request $request)
    {
        $image = $request->imageFile;

        if($request->imageFile != ''){
            $name = time().'.'.explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->imageFile)->save(public_path('images/ocm/').$name);
            $imgpath = '/images/ocm/'.$name;
        }

        else{
            $imgpath = '/images/admin.png';
        }

        $ocm = Ocm::where('id', $ocmid)->update(['profile_image_path' => $imgpath]);

        return response()->json($ocm);
    }

    public function updateOcmsubPriority($tid, $ocmsubid, Request $request)
    {
        $priority = $request->priority;
        $ocmstitle = Ocmsubtitle::where('id', $ocmsubid)->update(['priority' => $priority]);
        return response()->json($ocmstitle);
    }

    public function updateOcmtitlePriority($tid, $ocmtid, Request $request)
    {
        $priority = $request->priority;
        $ocmtitle = Ocmtitle::where('id', $ocmtid)->update(['priority' => $priority]);
        return response()->json($ocmtitle);
    }

    public function updateRamount($tid, $regid, Request $request)
    {
        $amount = $request->amount;
        $registration = Registration::where('id', $regid)->update(['amount' => $amount]);
        return response()->json($registration);
    }

    public function updateRcategory($tid, $catid, Request $request)
    {
        $category = $request->category;
        $categories = Regcategory::where('id', $catid)->update(['category' => $category]);
        return response()->json($categories);
    }

    public function updateRegtype($tid, $regtypeid, Request $request)
    {
        $regtype = $request->regtype;
        $regdate = $request->regdate;
        $rtype = Regtype::where('id', $regtypeid)->update(['reg_type' => $regtype, 'reg_type_date' => $regdate]);
        return response()->json($rtype);
    }

    public function updateRegsubmenu($tid, $regsmenuid, Request $request)
    {
        $regsmenu = $request->regsmenu;
        $rsmenu = Regsubmenu::where('id', $regsmenuid)->update(['regsubmenu' => $regsmenu]);
        return response()->json($rsmenu);
    }

    public function updateRegmenu($tid, $regmenuid, Request $request)
    {
        $regmenu = $request->regmenu;
        $rmenu = Registrationmenu::where('id', $regmenuid)->update(['regmenu' => $regmenu]);
        return response()->json($rmenu);
    }

    public function updateBConfdetails($tid, Request $request)
    {
        $name = $request->fullname;
        $title = $request->title;
        $conftype = $request->conftype;
        $city = $request->city;
        $country = $request->country;
        $venue = $request->venue;
        $torg = Targetorg::where('id', $tid)->update(['name' => $title, 'fullname' => $name, 'type' => $conftype, 'country' => $country,
            'city' => $city, 'venue' => $venue]);
        return response()->json($torg);
    }

    public function updateCDname($tid, $idmenuid, Request $request)
    {
        $idmenu = $request->idatemenu;
        $idatemenu = Idatemenu::where('id', $idmenuid)->update(['idatemenu' => $idmenu]);
        return response()->json($idatemenu);
    }

    public function updateCdate($tid, $idateid, Request $request)
    {
        $idate = $request->idate;
        $impdate = Importantdate::where('id', $idateid)->update(['impdate' => $idate]);
        return response()->json($impdate);
    }

    public function updateCDorder($tid, $idateid, Request $request)
    {
        $priority = $request->priority;
        //DB::enableQueryLog();
        $impdate = Importantdate::where('id', $idateid)->update(['priority' => $priority]);
        //$query = DB::getQueryLog();
        //print_r($query);
        return response()->json($impdate);
    }

    public function updateCDownorder($tid, $did, Request $request)
    {
        $priority = $request->priority;
        //DB::enableQueryLog();
        $download = Download::where('id', $did)->update(['priority' => $priority]);
        //$query = DB::getQueryLog();
        //print_r($query);
        return response()->json($download);
    }

    public function updateQLOrder($tid, $qlid, Request $request)
    {
        $priority = $request->priority;
        $qlink = Quicklink::where('id', $qlid)->update(['priority' => $priority]);
        return response()->json($qlink);
    }

    public function updateConfDate($tid, Request $request)
    {
        $sdate = $request->sdate;
        $edate = $request->edate;

        $torg = Targetorg::where('id', $tid)->update(['sdate' => $sdate, 'edate' => $edate]);

        return response()->json($torg);
    }

    public function updateCFPaper($tid, $cpid, Request $request)
    {
        $topic = $request->topic;
        $cpaper = $request->cpaper;

        if(!is_array($cpaper))
        {
            $cpaper = explode(',', $cpaper);
        }
        //dd($cpaper);

        $callpaper = Callforpaper::find($cpid)->update(['topic' => $topic, 'callforpaper' => $cpaper]);

        return response()->json($callpaper);
    }

    public function updateQLinks($tid, $qlid, Request $request)
    {
        $llabel = $request->linklabel;
        $link = $request->link;

        $qlinks = Quicklink::where('id',$qlid)->update(['link_label' => $llabel, 'link' => $link]);

        return response()->json($qlinks);
    }

    public function updateDownload($tid, $did, Request $request)
    {
        $dlabel = $request->downlabel;
        $dlink = $request->downlink;

        $download = Download::where('id', $did)->update(['filename' => $dlabel, 'download_link' => $dlink]);

        return response()->json($download);
    }

    public function updateAContent($tid, $acid, Request $request)
    {
        $title = $request->title;
        $acontent = $request->acontent;
        //$acontent = explode(',', $acontent);

        if(!is_array($acontent))
        {
            $acontent = explode(',', $acontent);
        }

        //dd($acontent);
        DB::enableQueryLog();
        $adcon = Additionalcontent::find($acid)->update(['title' => $title, 'content' => $acontent]);
        $query = DB::getQueryLog();
        print_r($query);
        return response()->json($adcon);
    }

    public function updateACPriority($tid, $acid, Request $request)
    {
        $tplace = $request->tplace;
        $ctype = $request->ctype;

        $adcon = Additionalcontent::find($acid)->update(['titleplace' => $tplace, 'content_type' => $ctype]);

        return response()->json($adcon);

    }

    public function deleteOcm($ocmid)
    {
        return response()->json(Ocm::where('id', $ocmid)->delete());
    }

    public function deleteOcmtitle($ocmtitleid)
    {
        $ocmtitle = Ocmtitle::find($ocmtitleid);
        $ocmtitle->ocmsubtitles()->delete();
        $ocmtitle->delete();
        return response()->json($ocmtitle);
    }

    public function deleteOcmsubtitle($ocmsubid)
    {
        $ocmsub = Ocmsubtitle::find($ocmsubid);
        $ocmsub->delete();
        return response()->json($ocmsub);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
