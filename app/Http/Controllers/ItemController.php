<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Number;
use Storage;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = Item::query();

            return DataTables::eloquent($items)
                ->addIndexColumn()
                ->addColumn('capital_price', function ($items) {
                    return 'Rp' . number_format($items->capital_price, 2, ',', '.');
                })
                ->addColumn('selling_price', function ($items) {
                    return 'Rp' . number_format($items->selling_price, 2, ',', '.');
                })
                ->addColumn('image', function ($items) {
                    if ($items->image_path) {
                        return '<img src="' . asset('storage/' . $items->image_path) . '" style="max-width: 50px; max-height: 50px;">';
                    } else {
                        return 'No Image';
                    }
                })
                ->addColumn('action', function ($items) {
                    return '
                    <a href="' . route('item.edit', ['item' => $items->id]) . '" class="btn btn-primary btn-sm">Edit</a>
                    <form id="delete-form-' . $items->id . '" action="' . route('item.destroy', ['item' => $items->id]) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $items->id . ')">Delete</button>
                    </form>
                ';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('item.index');
    }

    public function create(Request $request)
    {
        return view('item.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'qty' => ['required', 'integer', 'min:0'],
            'capital_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'desc' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/items', 'public');
            $validated['image_path'] = $imagePath;
        }

        Item::create($validated);

        return redirect()->route('item.index')->with('success', 'Item created.');
    }

    public function edit(Item $item)
    {
        return view('item.edit', ['item' => $item]);
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:50'],
            'qty' => ['nullable', 'integer', 'min:0'],
            'capital_price' => ['nullable', 'numeric', 'min:0'],
            'selling_price' => ['nullable', 'numeric', 'min:0'],
            'desc' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($item->image_path) {
                $oldImagePath = storage_path(path: 'app/public/' . $item->image_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $imagePath = $request->file('image')->store('images/items', 'public');
            $validated['image_path'] = $imagePath;
        }

        $item->update($validated);

        return redirect()->route('item.index')->with('success', 'Item updated.');
    }

    public function destroy(Item $item)
    {
        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();

        return redirect()->route('item.index')->with('success', 'Item deleted.');
    }
}
