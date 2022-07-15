<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
class HomeController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard');
    }

    public function print()
    {
    $pdf = Pdf::loadView('pdf.purchaseorder', []);
    return $pdf->stream();
    }
}
