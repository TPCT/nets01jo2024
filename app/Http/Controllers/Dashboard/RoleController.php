<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;




class RoleController extends BackEndController
{
    ############################ START CONSTRUCTOR ######################
    public function __construct(Role $model)
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
                ->orWhere('description', 'like','%' . $request->search . '%');

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
            'name'           => 'required|string|max:255|min:2|unique:roles,name',
            'description'    => 'required|string|max:255|min:1',
        ]);
        if($request->permissions == null)
        {
            session()->flash('error',__('site.add_permission_please'));
            return redirect()->route('dashboard.roles.create');
        }
        $newRole = new Role();

        $newRole->name         =  $request->name;
        $newRole->display_name = ucfirst($request->name);
        $newRole->description  =  $request->description;
        $newRole->save();

        $newRole->attachPermissions($request->permissions);

        session()->flash('success', __('site.add_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
    ############################ END STORE   ############################
    ############################ START UPDATE   #########################
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'           => ['required','string','max:255','min:2',Rule::unique('roles','name')->ignore($id)],
            'description'    => 'required|string|max:255|min:1',
        ]);
        $updateRole = $this->model->findOrFail($id);
        if($request->permissions == null)
        {
            session()->flash('error',__('site.add_permission_please'));
            $module_name_plural = $this->getClassNameFromModel();
            $module_name_singular = $this->getSingularModelName();
            $row=$updateRole;
            return view('dashboard.' . $this->getClassNameFromModel() . '.edit', compact('row', 'module_name_singular', 'module_name_plural'));
        }

        $updateRole->name         =  $request->name;
        $updateRole->display_name = ucfirst($request->name);
        $updateRole->description  =  $request->description;
        $updateRole->save();
        $updateRole->syncPermissions($request->permissions);
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
    ############################ END UPDATE   ###########################
    ############################ START DESTROY   ########################
    public function destroy($id,Request $request)
    {
        $role=Role::findOrFail($id);
        $role->delete();
        session()->flash('success',__('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');


    }
    ############################ END DESTROY   ##########################
}
