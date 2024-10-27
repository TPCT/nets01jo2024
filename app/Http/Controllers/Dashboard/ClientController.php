<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends BackEndController
{
    ############################ START CONSTRUCTOR ######################
    public function __construct(Client $model)
    {
        parent::__construct($model);
    }
    ############################ END CONSTRUCTOR ########################
    ############################ START INDEX ############################
    public function index(Request $request)
    {
         $rows = $this->model->with(['country' , 'city' , 'jobTitle'])->when($request->search,function($query) use ($request){
            $query->where('first_name','like','%' .$request->search . '%')
                ->orWhere('last_name','like','%' .$request->search . '%')
                ->orWhere('email', 'like','%' . $request->search . '%')
                ->orWhere('phone', 'like','%' . $request->search . '%')
                ->orWhere('company_name', 'like','%' . $request->search . '%')
                ->orWhereHas('country',function($q) use($request){
                    $q->whereTranslationLike('name','%'.$request->search.'%');
                })
                ->orWhereHas('city',function($q) use($request){
                    $q->whereTranslationLike('name','%'.$request->search.'%');
                })
                ->orWhereHas('jobTitle',function($q) use($request){
                    $q->whereTranslationLike('name','%'.$request->search.'%');
                });
        })->whereNotNull('phone');
         $rows = $this->filter($rows,$request);
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural' ));
    }
    ############################ END INDEX   ############################
    ####################### START CHANGE STATUS   #######################
    protected function changeStatus( $id ){
        $client = Client::findOrFail( $id );
        $client['status'] *= -1;
        $client->save();
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
    #######################  END CHANGE STATUS    #######################
}
