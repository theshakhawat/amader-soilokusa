<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FontSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FontSettingController extends Controller
{
    public function index()
    {
        $fontSetting = FontSetting::getSettings();

        $bengaliFonts = [
            'Popular Bengali Fonts' => [
                'SolaimanLipi' => 'SolaimanLipi (সোলাইমান লিপি)',
                'Nikosh' => 'Nikosh (নিকোশ)',
                'Kalpurush' => 'Kalpurush (কালপুরুষ)',
                'Sonar Bangla' => 'Sonar Bangla (সোনার বাংলা)',
                'Bangla' => 'Bangla (বাংলা)',
                'AdorshoLipi' => 'AdorshoLipi (আদর্শলিপি)',
                'SutonnyMJ' => 'SutonnyMJ Unicode (সুতোন্বী এমজে লুক)',
                'Mukti' => 'Mukti (মুক্তি)',
                'Charukola' => 'Charukola (চারুকলা)',
                'BenSen' => 'BenSen (বেনসেন)',
            ],
            'Google Bengali Fonts' => [
                'Hind Siliguri' => 'Hind Siliguri (হিন্দ শিলিগুড়ি)',
                'Noto Sans Bengali' => 'Noto Sans Bengali (নোতো সানস বাংলা)',
                'Noto Serif Bengali' => 'Noto Serif Bengali (নোতো সেরিফ বাংলা)',
                'Tiro Bangla' => 'Tiro Bangla (তিরো বাংলা)',
                'Galada' => 'Galada (গালাদা)',
                'Mina' => 'Mina (মিনা)',
                'Atma' => 'Atma (আত্মা)',
                'Anek Bangla' => 'Anek Bangla (অনেক বাংলা)',
            ],
            'English / General Fonts' => [
                'Inter' => 'Inter',
                'Roboto' => 'Roboto',
                'Open Sans' => 'Open Sans',
                'Poppins' => 'Poppins',
            ],
        ];

        $fontWeights = [
            '100' => '100 - Thin',
            '200' => '200 - Extra Light',
            '300' => '300 - Light',
            '400' => '400 - Normal / Regular',
            '500' => '500 - Medium',
            '600' => '600 - Semi Bold',
            '700' => '700 - Bold',
            '800' => '800 - Extra Bold',
            '900' => '900 - Black (Max)',
        ];

        $fontStyles = [
            'normal' => 'Normal (স্বাভাবিক)',
            'italic' => 'Italic (ইটালিক)',
        ];

        return view('admin.settings.font', compact('fontSetting', 'bengaliFonts', 'fontWeights', 'fontStyles'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'admin_font_family' => 'required|string|max:100',
            'website_font_family' => 'required|string|max:100',
        ]);

        $fontSetting = FontSetting::getSettings();
        $fontSetting->update($validated);

        Cache::forget('global_font_settings');
        Cache::forget('global_font_settings_arr');

        return redirect()->route('admin.settings.font')->with('success', 'ফন্ট সেটিংস সফলভাবে আপডেট করা হয়েছে।');
    }
}
