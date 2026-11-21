<?php
namespace App\Http\Controllers;
use App\Models\Notebook;
use Illuminate\Support\Facades\DB;
class PageController extends Controller
{
    public function home() { return view('home', ['count'=>Notebook::count(),'featured'=>Notebook::orderBy('price')->first()]); }
    public function chart() { $stats=Notebook::select('manufacturer',DB::raw('COUNT(*) as total'))->groupBy('manufacturer')->orderByDesc('total')->limit(10)->get(); return view('chart',['stats'=>$stats]); }
}
