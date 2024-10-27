<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\JobTitlesExport;
use App\Imports\JobTitlesImport;
use App\Models\Client;
use App\Models\JobTitle;
use App\Http\Requests\StoreJobTitleRequest;
use App\Http\Requests\UpdateJobTitleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class JobTitleController extends BackEndController
{
    public function __construct(JobTitle $model)
    {
        parent::__construct($model);

    }
    public function index(Request $request)
    {
        $rows = $this->model->when($request->search,function($q) use ($request){
            $q->whereTranslationLike('name','%' .$request->search. '%');
        });
        $rows_count = $rows->count();
        $rows = $rows->paginate(25);
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural' , 'rows_count' ) );
    }
    public function store(Request $request)
    {
        $request->validate([
            'ar.name'          => 'required|min:3|max:60|unique:job_title_translations,name',
            'en.name'          => 'required|min:3|max:60|unique:job_title_translations,name',
        ]);
        $request_data = $request->except(['_token']);

        JobTitle::create($request_data);
        session()->flash('success', __('site.add_successfully'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }

    public function update(Request $request, $id)
    {
        $job_title = $this->model->findOrFail($id);
        $request->validate([
            'ar.name'          => ['required', 'min:3','max:60', Rule::unique('job_title_translations','name')->ignore( $job_title->id, 'job_title_id') ],
            'en.name'          => ['required', 'min:3','max:60', Rule::unique('job_title_translations','name')->ignore( $job_title->id, 'job_title_id') ],
        ]);
        $request_data = $request->except(['_token']);

        $job_title->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
    public function destroy($id, Request $request)
    {
        $job_title = $this->model->findOrFail($id);

        $client =  Client::where('job_title_id' , $job_title['id'] )->first();

        if( $client ){
            session()->flash('error', __('site.A Job Title with Clients cannot be deleted'));
            return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
        }
        $job_title->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
    public function import( Request $request)
    {
        Excel::import( new JobTitlesImport, $request['file'] );

        session()->flash('success', __('site.add_successfully'));
        return redirect()->back();
    }
    public function export()
    {
        return Excel::download( new JobTitlesExport , 'jobTitles.xlsx');
    }
    public function exportToCSV(){
        return Excel::download( new JobTitlesExport , 'jobTitles.csv');
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
