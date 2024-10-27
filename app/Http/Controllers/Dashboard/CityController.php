<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\BackEndController;
use App\Models\City;
use App\Models\Client;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CityController extends BackEndController
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {
        $rows = $this->model->when($request->search,function($q) use ($request){
            $q->whereTranslationLike('name','%' .$request->search. '%')
                ->orWhereHas('country',function($q) use($request){
                    $q->whereTranslationLike('name','%'.$request->search.'%');
                });
        });
        $rows_count = $rows->count();
        $rows = $this->filter($rows,$request);
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural' , 'rows_count' ) );
    }
    public function store(Request $request)
    {
        $request->validate([
            'ar.name'          => 'required|min:3|max:60|unique:city_translations,name',
            'en.name'          => 'required|min:3|max:60|unique:city_translations,name',
            'country_id'       => 'required|exists:countries,id'
        ]);
        $data = $request->all();
        $data['status']   = 1;
        City::create( $data );
        session()->flash('success', __('site.add_successfully'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
    public function update(Request $request, $id)
    {
        $city = $this->model->findOrFail($id);
        $request->validate([
            'ar.name'          => ['required', 'min:3','max:60', Rule::unique('city_translations','name')->ignore($city->id, 'city_id') ],
            'en.name'          => ['required', 'min:3','max:60', Rule::unique('city_translations','name')->ignore($city->id, 'city_id') ],
            'country_id'       => 'required | exists:countries,id'

        ]);
        $city->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');


    }
    public function destroy($id, Request $request)
    {
        $city = $this->model->findOrFail($id);
        $client =  Client::where('city_id' , $city['id'] )->first();

        if( $client ){
            session()->flash('error', __('site.A city with Clients cannot be deleted'));
            return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
        }
        $city->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
    ####################### START CHANGE STATUS   #######################
    protected function changeStatus( $id ){
        $row = $this->model->findOrFail( $id );
        $row['status'] = ! $row['status'];
        $row->save();
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
    #######################  END CHANGE STATUS    #######################
}
