<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Member;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PengajuanController extends Controller
{
	public function index(Request $request)
	{
		if ($request->ajax()) {
			$pengajuans = Pengajuan::with('member')->get(); // Mengambil data pengajuan beserta relasi member

			return DataTables::of($pengajuans)
				->addIndexColumn()
				->addColumn('action', function ($pengajuan) {

					if ($pengajuan->status == 'pending') {
						return '<a href="' . route('pengajuan.edit', ['pengajuan' => $pengajuan->id]) . '" class="btn btn-primary btn-sm">Edit</a>
						<form id="delete-pengajuan-' . $pengajuan->id . '" action="' . route('pengajuan.destroy', ['pengajuan' => $pengajuan->id]) . '" method="POST" style="display: inline-block;">
								' . csrf_field() . '
								' . method_field('DELETE') . '
								<button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $pengajuan->id . ')">Delete</button>
						</form>';
					}

					return '-';
				})
				->addColumn('member_name', function ($pengajuan) {
					return $pengajuan->member->name;
				})
				->rawColumns(['action'])
				->make(true);
		}

		return view('pengajuan.index');
	}

	public function create(Request $request)
	{
		$members = Member::all();
		return view('pengajuan.create', ['members' => $members]);
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'nama_barang' => ['required', 'string', 'max:100'],
		]);

		$validated['member_id'] = Auth::user()->member->id;
		$validated['tanggal'] = now();
		$validated['status'] = 'pending';

		Pengajuan::create($validated);

		return redirect()->route('pengajuan.index')->with('success', 'Pengajuan created.');
	}

	public function edit(Pengajuan $pengajuan)
	{
		return view('pengajuan.edit', ['pengajuan' => $pengajuan]);
	}

	public function update(Request $request, Pengajuan $pengajuan)
	{
		$validated = $request->validate([
			'nama_barang' => ['nullable', 'string', 'max:100'],
			'status' => ['nullable', 'in:pending,accepted,declined'],
		]);

		$pengajuan->update($validated);

		return redirect()->route('pengajuan.index')->with('success', 'Pengajuan updated.');
	}

	public function destroy(Pengajuan $pengajuan)
	{
		$pengajuan->delete();

		return redirect()->route('pengajuan.index')->with('success', 'Pengajuan deleted.');
	}
}