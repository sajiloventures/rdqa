<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use App\Models\Resource;
use Illuminate\Http\Request;use Dompdf\Dompdf;
use Dompdf\Options;

class FrontEndController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
    }
    public function faq()
    {
        $data['faq'] = FAQ::ByStatus()->orderBy('sort_order')->get();
        return view('frontend.faq', compact('data'));
    }
    public function userManual()
    {
        $data = null;
        $File = public_path('user-manual/user-manual.txt');
        if (\File::exists($File)) {
            $handle = file($File);
            $data = join(' ', $handle);
        }

        return view('frontend.user-manual', compact('data'));
    }
    public function downloadManual()
    {
        $data = null;
        $File = public_path('user-manual/user-manual.txt');
        if (\File::exists($File)) {
            $handle = file($File);
            $data = join(' ', $handle);
        }

        $data = str_replace(asset(''), public_path() .'/', $data);

        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => public_path() . '/temp_pdf/',
            'default_font_size' => 10,
            'mode' => 'ne',
            'default_font' => 'dejavusans'
        ]);
        $mpdf->WriteHTML($data);
        return $mpdf->Output('manual.pdf', 'D');
    }

    public function resources()
    {
        $resources = Resource::ByStatus()->get();

        return view('frontend.resources', compact('resources'));
    }
}
