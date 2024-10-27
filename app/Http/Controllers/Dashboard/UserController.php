<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BackEndController
{
    ############################ START CONSTRUCTOR ######################
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    ############################ END CONSTRUCTOR ########################
    ############################ START INDEX ############################
    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model->when($request->search,function($query) use ($request){
            $query->where('name','like','%' .$request->search . '%')
                ->orWhere('email', 'like','%' . $request->search . '%')
                ->orWhere('phone', 'like','%' . $request->search . '%')
                ->orWhere('address', 'like','%' . $request->search . '%');

        });
        $rows = $this->filter($rows,$request);
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    }
    ############################ END INDEX   ############################
    ############################ START STORE   ##########################
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|max:255|min:5|string',
            'email'                 => 'required|email|unique:users,email|max:255|min:5',
            'phone'                 => 'required|unique:users,phone|min:5|max:255',
            'password'              => 'required|max:255|min:5|string|confirmed',
            'password_confirmation' => 'required|max:255|min:5|string|same:password',
            'address'               => 'nullable|max:255|min:5|string',
            'image'                 => 'nullable|mimes:jpg,jpeg,png,svg',
        ]);

        $request_data = $request->except(['_token', 'password', 'password_confirmation', 'role_id','image']);
        $request_data['password'] = bcrypt($request->password);
        if($request->has('image')){
            $path  = $this->uploadImage($request->file('image'),'users_images');

            $request_data['image']   = $path;
        }
        //$request_data['type']=1;
        $new_user = $this->model->create($request_data);
        if($request->role_id){
            $new_user->attachRoles($request->role_id);
        }
        session()->flash('success', __('site.add_successfully'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
    ############################ END STORE   ############################
    ############################ START UPDATE   #########################
    public function update(Request $request, $id)
    {
        $user = $this->model->find($id);

        $request->validate([
            'name'                    => 'required|max:255|min:5|string',
            'email'                   => 'required|max:255|email|unique:users,email,'.$user->id.'',
            'phone'                   => 'required|max:255|unique:users,phone,'.$user->id.'',
            'password_confirmation'   => 'same:password|max:255',
            'address'                 => 'nullable|max:255|min:5|string',
            'image'                   => 'nullable|mimes:jpg,jpeg,png,svg',
        ]);

        $request_data = $request->except(['_token', 'password', 'password_confirmation', 'role_id']);
        if($request->has('password') && $request->password !=null){

            $request_data['password'] = bcrypt($request->password);
        }
        if($request->image != null){
            if($user->image != null){
                if(file_exists(base_path('public/uploads/users_images/') . $user->image)){
                    unlink(base_path('public/uploads/users_images/') . $user->image);
                }
            }
            $path = rand(1000000,100000000) . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(base_path('public/uploads/users_images') , $path);
            $request_data['image']    = $path;
        }

        if($request->role_id){
            $user->syncRoles($request->role_id);
        }
        $user->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
    ############################ END UPDATE   ###########################
    ############################ START DESTROY   ########################
    public function destroy($id, Request $request)
    {
        $user = $this->model->findOrFail($id);
        if($user->image != null)
        {
            if(file_exists(base_path('public/uploads/users_images/') . $user->image)){
                unlink(base_path('public/uploads/users_images/') . $user->image);
            }
        }
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
    ############################ END DESTROY   ##########################
}
