<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-users')->only('index');
        $this->middleware('permission:create-users')->only('create');
        $this->middleware('permission:update-users')->only('edit');
        $this->middleware('permission:delete-users')->only('destroy');
    }

    public function index(Request $request)
    {
        $users=User::whereRoleIs('admin')->where(function($q) use ($request){
            return $q->when($request->search,function($query) use ($request) {
                return $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
            })->latest()->paginate(8);

        return view('dashboard.users.index',compact('users'));
    }//end of index


    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required|min:2|max:20',
            'last_name'=>'required|min:2|max:20',
            'email'=>'required|email|unique:users',
            'image'=>'image',
            'permissions'=>'required|min:1',
            'password'=>'required_with:password_confirmation|same:password_confirmation|min:6'
        ]);
        $request_data =$request->except(['password','password_confirmation','permissions','image']);
        $request_data['password']=bcrypt($request->password);
                if($request->image){
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/'.$request->image->hashName()));
            $request_data['image']=$request->image->hashName();
        }
//        dd($request->all());

        $user=User::create($request_data);
        //add permissions & Roles
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }//end of Add new user

    public function edit(User $user)
    {
//        $user=User::find($user_id);
        return view('dashboard.users.edit',compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name'=>'required|min:2|max:20',
            'last_name'=>'required|min:2|max:20',
            'email'=>'required|email',
            'image'=>'image',
            'permissions'=>'required|min:1',
        ]);
        $request_data =$request->except(['permissions','image']);
        if($request->image){
            if($request->image != 'default.png'){
                Storage::disk('public_uploads')->delete('/users_images/'.$user->image);
            }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/uploads/users_images/'.$request->image->hashName()));
            $request_data['image']=$request->image->hashName();
        }
        $user->update($request_data);
        //add permissions
        $user->syncPermissions($request->permissions);

        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }//end of update

    public function destroy(User $user)
    {
        if($user->image != 'default.png'){
            Storage::disk('public_uploads')->delete('/users_images/'.$user->image);
        }
        $user->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }
}//end of controller
