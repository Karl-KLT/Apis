<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Categories;
use App\Models\Future;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'Login','Register',
            'APP','UPDATE_APP',
            'SET_Product','GET_Categories',
            'SET_Categories',
            'GET_All']
        ]);
    }
    // APP
    public function APP()
    {
        if(App::all()){

            return response()->json([
                'status' => 200,
                'message' => 'successfully',
                'APP_NAME' => App::all()->first()->APP_NAME,
                'APP_IMAGE' => App::all()->first()->APP_IMAGE
            ],200);

        }

        return response()->json([
            'status' => 401,
            'message' => 'failed',
            'APP_NAME' => App::all()->first()->APP_NAME,
            'APP_IMAGE' => App::all()->first()->APP_IMAGE
        ]);

    }

    public function UPDATE_APP()
    {
        try{
            App::updateOrCreate(['id'=>1],request()->all());


            return response()->json([
                'status' => 200,
                'message' => 'successfully'
            ]);

        }catch(Throwable $e){

            return response()->json([
                'status' => 401,
                'message' => 'failed'
            ]);

        }
    }


    // Auth
    public function Profile()
    {
        return response()->json([
            'data'=>auth('api')->user(),
            'status'=>200,
            'message'=>'successfully',
            'created_at'=>getTimeFromNow(auth('api')->user()->created_at),
            'updated_at'=>getTimeFromNow(auth('api')->user()->updated_at)
        ]);
    }

    public function Login()
    {
        if($token = auth('api')->attempt(request()->all(),true)){

            return $this->respondWithToken($token);
        }

        return response()->json(['status'=>401,'message'=>'Unauthorized']);

    }

    public function Register()
    {
        if(Auth::attempt(request()->only('email','password'))){
            return response()->json(['status'=>500,'message'=>'this account has already created']);
        }


        try{
            $validate = Validator::make(request()->all(),[
                'name'=>'required',
                'email'=>'required|email',
                'password'=>'required',
                'confirm_password'=>'required|same:password',
            ]);

            if($validate->fails()){
                return response()->json(['status'=>500,'message'=>'something wrong','errors'=>$validate->messages()->get('*')]);
            }

            User::create([
                'name' => request()->name,
                'email' => request()->email,
                'password' => Hash::make(request()->password),
                'confirm_password' => request()->confirm_password,
            ]);

            return response()->json(['status'=>200,'message'=>'account has been created']);
        }catch(Throwable $e){
            return response()->json(['status'=>401,'error'=>$e]);
        }
    }

    // SLIDER
    public function SET_Slider()
    {

        $validate = Validator::make(request()->all(),[
            'image'=>'required',
            'url'=>'required|url',
        ]);

        if($validate->fails()){
            return response()->json(['status'=>500,'message'=>'something wrong','errors'=>$validate->messages()->get('*')]);
        }

        $slider = new Slider;
        $slider->fill(request()->all());
        $slider->save();

        return response()->json(['status'=>200,'message'=>'Slider has been created']);


    }

    // Categories
    public function SET_Categories()
    {
        $validate = Validator::make(request()->all(),[
            'name'=>'required',
        ]);

        if($validate->fails()){
            return response()->json(['status'=>500,'message'=>'something wrong','errors'=>$validate->messages()->get('*')]);
        }

        $Categories = new Categories;
        $Categories->fill(request()->all());
        $Categories->save();

        return response()->json(['status'=>200,'message'=>'Categories has been created']);

    }

    public function GET_Categories()
    {
        return Categories::all();
        return response()->json(['status'=>200,'message'=>'successfully','Categories'=>Categories::all()]);
    }
    // ////////////////////////////////////////////////////////
    // sub categories
    public function SET_Product()
    {
        $validate = Validator::make(request()->all(),[
            'title'=>'required',
            'price'=>'required',
            'image'=>'required',
            'id'=>'required',
        ]);

        if($validate->fails()){
            return response()->json(['status'=>500,'message'=>'something wrong','errors'=>$validate->messages()->get('*')]);
        }
        try{
            return Categories::find(request()->id)->getProduct()->create(request()->only('title','price','image'));
        }catch(Throwable $e){
            return response()->json(['status'=>401,'message'=>"can't find id for Category"]);
        }

    }

    public function GET_Product()
    {
        try{
            return response()->json(['data'=>Product::all(),'message'=>'successfully','status'=>200],200);
        }catch(Throwable $e){
            return response()->json(['status'=>500,'message'=>"failed"]);
        }

    }
    // ////////////////////////////////////////////////////////
    // futures
    public function SET_Future()
    {
        $validate = Validator::make(request()->all(),[
            'title'=>'required',
            'image'=>'required',
        ]);

        if($validate->fails()){
            return response()->json(['status'=>500,'message'=>'something wrong','errors'=>$validate->messages()->get('*')]);
        }

        $future = new Future;
        $future->fill(request()->all());
        $future->save();
    }

    public function GET_Future()
    {
        return Future::all();
    }
    // end futures

    // end

    // get_All
    public function GET_All()
    {
        return response()->json([
            'data'=>[
                'Categories'=>Categories::all(),
                'Products'=>Product::all(),
                'Futures'=>Future::all()
            ],
            'status'=>200,
            'message'=>'successfully'
            ]);
    }
    // //////////
    // JWT AUTH
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 200,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
