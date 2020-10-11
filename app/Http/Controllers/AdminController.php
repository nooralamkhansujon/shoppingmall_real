<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->input();
             if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'admin' => '1'])) {
                return redirect()->route('admin.dashboard');
            }else{
                return redirect(route('admin'))->with('flash_message_error','Invalid Username or Password');
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard(){
        return view('admin.dashboard');
    }

    public function settings(){
        return view('admin.settings');
    }

    public function chkPassword(Request $request){

        $current_password =  $request->current_pwd;
        $check_password = User::where(['admin'=>'1','email'=>auth()->user()->email])->pluck('password')->first();
        if(Hash::check($current_password,$check_password)){
            return response('true');
        }else {
            return response('false');
        }
    }

    public function updatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $check_password = User::where(['email' => Auth::user()->email])->pluck('password')->first();
            $current_password = $data['current_pwd'];
            if(Hash::check($current_password, $check_password)){
                $password = bcrypt($data['new_pwd']);
                User::where('id','1')->update(['password'=>$password]);
                return redirect(route('admin.settings'))->with('flash_message_success','Password updated Successfully!');
            }else {
                return redirect(route('admin.settings'))->with('flash_message_error','Incorrect Current Password!');
            }
        }
    }


    public function logout(){
        Auth::logout();
        return redirect(route('admin'))->with('flash_message_success','Logged out Successfully');
    }
}
