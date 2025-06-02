<?php

namespace Modules\Certificate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Modules\Certificate\Entities\CertificateSetting;

class CertificateSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = [];
        $data['page_title'] = _trans('admin.Certificate Settings');
        $data['settings'] = CertificateSetting::get();
        return view('certificate::settings', $data);
    }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function storeOrUpdate(Request $request)
    {
        try {
            foreach ($request->key_value as $key => $value) {
                $setting = CertificateSetting::where('key', $key)->first();
                if (!$setting) {
                    $setting = new CertificateSetting();
                }
                $setting->key = $key;
                $setting->value = $value;
                $setting->save();
            }
            Toastr::success(_trans('certificate.Setting has been updated successfully'), _trans('common.Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error($th->getMessage(), _trans('common.Error'));
            return redirect()->back();
        }
    }
}
