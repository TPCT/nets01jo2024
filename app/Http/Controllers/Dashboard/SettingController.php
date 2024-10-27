<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Setting as ModelSetting;

class SettingController extends Controller
{
    private $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
        $this->middleware(['permission:read-settings'])->only('index');
        $this->middleware(['permission:create-settings'])->only('create');
        $this->middleware(['permission:update-settings'])->only('update');
        $this->middleware(['permission:delete-settings'])->only('destroy');

    }
    public function edit($id){
        $row = Setting::first();
        return view('dashboard.settings.edit', compact('row'));
    }

    public function update(Request $request)
    {
        $setting = $this->model->first();
        $request->validate([
            'ar.terms_and_conditions'          => ['required', 'min:3','max:7000'],
            'en.terms_and_conditions'          => ['required', 'min:3','max:7000'],
            'ar.privacy_policy'                => ['required', 'min:3','max:7000'],
            'en.privacy_policy'                => ['required', 'min:3','max:7000']
        ]);
        $setting->update( $request->all() );
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.settings.edit' , 1 );
    }
}
