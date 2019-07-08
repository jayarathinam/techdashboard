<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;


class UsersController extends Controller
{
    public function index(){
        $users = User::where('auth','!=','new')->where('auth','!=','blocked')->get();

        return response()->json($users);
    }

    public function requests(){
        $requests = User::where('auth','new')->get();

        return response()->json($requests);
    }

    public function getUser($id){
        $user = User::where('id', $id)->get();

        return response()->json($user);
    }

    public function blockedusers(){
        $busers = User::where('auth','blocked')->get();

        return response()->json($busers);
    }

    public function store(Request $request){

        $image = $request->imageFile;

        if($request->auth == ''){
            $auth = 'new';
        }

        else{
            $auth = $request->auth;
        }

        if($request->imageFile != ''){
            $name = time().'.'.explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->imageFile)->save(public_path('images/').$name);
            $imgpath = '/images/'.$name;
        }

        else{
            $imgpath = '/images/admin.png';
        }


        User::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'role' => $request->role,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'pimg' => $imgpath,
            'auth' => $auth
        ]);

    }

    public function bulkupload(Request $request){

        $csvFile = $request->csvFile;
        $fileName = $request->fileName;

        $csv = $this->csvToArray($csvFile);
        //$vrfdcsv = $this->process($csv);
            for($i=0; $i<count($csv); $i++){
                try{
                $dob = $csv[$i]['dob'];
                $dob = explode('/', $dob);
                $dob = $dob[2].'-'.$dob[0].'-'.$dob[1];
                $csv[$i]['dob'] = $dob;
                User::create($csv[$i]);
                }

                catch(\Exception $e){
                    return response()->json([
                        'status' => 'error',
                        'msg' => 'error',
                        'errors' => $e->getMessage(),
                    ],422);
                }
            }

            return 'Your CSV File Uploaded Successfully...!';

    }

    public function processCSV(Request $request){
        $csvFile = $request->csvFile;
        $fileName = $request->fileName;

        $csv = $this->csvToArray($csvFile);
        $vrfdcsv = $this->process($csv);

        if(is_array($vrfdcsv)){
            return response()->json($vrfdcsv);
        }

        else{
            return response()->json([
                'status' => 'error',
                'msg' => 'error',
                'errors' => $vrfdcsv,
            ],422);
        }

    }

    public function activate($id){
        $ids = explode(",", $id);
        return response()->json(User::whereIn('id',$ids)->update(['auth' => 'activated']));
    }

    public function block($id){
        $ids = explode(",", $id);
        return response()->json(User::whereIn('id',$ids)->update(['auth' => 'blocked']));
    }

    public function destroy($id){
            $ids = explode(",", $id);
            return response()->json(User::whereIn('id', $ids)->delete());
    }

    function csvToArray($filename = ''){

        $header = null;
        $data = array();

        $csv = array_map('str_getcsv', file($filename));

        for($i=0; $i<count($csv); $i++){
            if(!$header)
                $header = $csv[$i];
            else
                $data[] = array_combine($header, $csv[$i]);
        }

        return $data;
    }

    function process($csvname = ''){

        $demail = array();
        $dupemail = array();

        for($i = 0; $i< count($csvname); $i++){
            try{
                $demail[] = $csvname[$i]['email'];
            }

            catch(\Exception $e){
                $dupmsg = $e->getMessage();
                if(strpos($dupmsg, 'Undefined index') !== 'false'){
                    $dupemail[] = 'csvwrong';
                }

                else{
                    $dupemail[] = 'unknownerr';
                }
            }
        }
        $duplicaterows =  User::whereIn('email',$demail)->get()->toArray();


        for($i = 0; $i< count($duplicaterows); $i++){
            $dupemail[] = array('duplicate_email'=>$duplicaterows[$i]['email']);
        }

        if(empty($dupemail)){
            $dupemail[] = 'success';
        }

        return $dupemail;
    }

}
