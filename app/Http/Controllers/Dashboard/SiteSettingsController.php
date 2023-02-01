<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdateSiteSettingRequest;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function edit()
    {
        $this->authorize('manage', SiteSetting::class);

        $tradeFeeSetting = SiteSetting::tradeFee();

        return view('dashboard.site_settings.settings', compact('tradeFeeSetting'));
    }

    public function update(UpdateSiteSettingRequest $request)
    {
        $this->authorize('manage', SiteSetting::class);

        SiteSetting::updateTradeFee($request->validated());

        return redirect()->back()->with('success', trans('dashboard/site_settings.form.trade_fee.success'));
    }
}
