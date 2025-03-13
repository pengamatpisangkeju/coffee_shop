<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Number;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $items = Item::query();

            return DataTables::eloquent($items)
            ->addColumn('capital_price', function($items) {
                return 'Rp' . number_format($items->capital_price, 2, ',', '.');
            })
            ->addColumn('selling_price', function($items) {
                return 'Rp' . number_format($items->selling_price, 2, ',', '.');
            })
            ->addColumn('image', function($items) {
                if ($items->image_path) {
                    return '<img src="' . asset('storage/' . $items->image_path) . '" style="max-width: 50px; max-height: 50px;">';
                } else {
                    return 'No Image';
                }
            })
            ->addColumn('action', function($items) {
                return '
                    <a href="" class="btn btn-primary btn-sm">Edit</a>
                    <a href="" class="btn btn-danger btn-sm">Delete</a>
                ';
            })
            ->rawColumns(['image', 'action']) // Allow HTML in the image column
            ->make(true);
        }

        // $items = Item::all();
        return view('item.index');
    }
}
