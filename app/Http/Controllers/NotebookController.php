<?php

namespace App\Http\Controllers;

use App\Models\Notebook;
use App\Models\OperatingSystem;
use App\Models\Processor;
use Illuminate\Http\Request;

class NotebookController extends Controller
{
    public function index(Request $request)
    {
        $notebooks = Notebook::with(['processor', 'operatingSystem'])
            ->when($request->filled('search'), fn ($query) => $query->where(fn ($q) => $q->where('manufacturer', 'like', '%'.$request->string('search').'%')->orWhere('model', 'like', '%'.$request->string('search').'%')))
            ->orderBy('manufacturer')->paginate(18)->withQueryString();

        return view($request->routeIs('admin.*') ? 'notebooks.admin-index' : 'notebooks.index', compact('notebooks'));
    }

    public function create()
    {
        return view('notebooks.form', ['notebook' => new Notebook, 'processors' => Processor::orderBy('manufacturer')->get(), 'systems' => OperatingSystem::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        Notebook::create($this->validated($request));
        return redirect()->route('admin.notebooks.index')->with('success', 'A notebookot hozzáadtuk.');
    }

    public function edit(Notebook $notebook)
    {
        return view('notebooks.form', ['notebook' => $notebook, 'processors' => Processor::orderBy('manufacturer')->get(), 'systems' => OperatingSystem::orderBy('name')->get()]);
    }

    public function update(Request $request, Notebook $notebook)
    {
        $notebook->update($this->validated($request));
        return redirect()->route('admin.notebooks.index')->with('success', 'A notebook adatait frissítettük.');
    }

    public function destroy(Notebook $notebook)
    {
        $notebook->delete();
        return back()->with('success', 'A notebookot töröltük.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'manufacturer' => 'required|string|max:100', 'model' => 'required|string|max:160',
            'screen_size' => 'required|numeric|min:5|max:30', 'memory_mb' => 'required|integer|min:256|max:131072',
            'disk_gb' => 'required|integer|min:1|max:10000', 'graphics' => 'required|string|max:180',
            'price' => 'required|integer|min:0', 'processor_id' => 'required|exists:processors,id',
            'operating_system_id' => 'required|exists:operating_systems,id',
        ]);
    }
}
