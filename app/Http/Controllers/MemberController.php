<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
	public function index(Request $request)
	{
		if ($request->ajax()) {
			$members = Member::query();

			return DataTables::eloquent($members)
				->addIndexColumn()
				->addColumn('action', function ($member) {
					return '
						<a href="' . route('member.edit', ['member' => $member->id]) . '" class="btn btn-primary btn-sm">Edit</a>
						<form id="delete-member-' . $member->id . '" action="' . route('member.destroy', ['member' => $member->id]) . '" method="POST" style="display: inline-block;">
								' . csrf_field() . '
								' . method_field('DELETE') . '
								<button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $member->id . ')">Delete</button>
						</form>
					';
				})
				->rawColumns(['action'])
				->make(true);
		}

		return view('member.index');
	}

	public function create(Request $request)
	{
		return view('member.create');
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:8'],
			'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
			'name' => ['required', 'string', 'max:100'],
			'phone_number' => ['required', 'string', 'max:20'],
		]);

		try {
			DB::beginTransaction();

			$user = User::create([
				'email' => $validated['email'],
				'password' => Hash::make($validated['password']),
				'role' => 'member',
				'image_path' => $request->hasFile('image') ? $request->file('image')->store('images/users', 'public') : null,
			]);

			Member::create([
				'user_id' => $user->id,
				'name' => $validated['name'],
				'phone_number' => $validated['phone_number'],
			]);

			DB::commit();

			return redirect()->route('member.index')->with('success', 'Member created.');
		} catch (\Exception $e) {
			DB::rollback();
			return redirect()->back()->with('error', 'Failed to create member. ' . $e->getMessage());
		}
	}

	public function edit(Member $member)
	{
		return view('member.edit', ['member' => $member]);
	}

	public function update(Request $request, Member $member)
	{
		$validated = $request->validate([
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $member->user->id],
			'password' => ['nullable', 'string', 'min:8', 'confirmed'],
			'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
			'name' => ['required', 'string', 'max:100'],
			'phone_number' => ['required', 'string', 'max:20'],
		]);

		$userData = [
			'email' => $validated['email'],
		];

		if ($request->filled('password')) {
			$userData['password'] = Hash::make($validated['password']);
		}

		if ($request->hasFile('image')) {
			$userData['image_path'] = $request->file('image')->store('images/users', 'public');
		}

		try {
			DB::beginTransaction();
	
			$member->user->update($userData);
	
			$member->update([ 
				'name' => $validated['name'],
				'phone_number' => $validated['phone_number'],
			]);
	
			DB::commit();
	
			return redirect()->route('member.index')->with('success', 'Member updated.');
		} catch (\Exception $e) {

		}

	}

	public function destroy(Member $member)
	{
		$member->delete();

		return redirect()->route('member.index')->with('success', 'Member deleted.');
	}
}