<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
			'user_id',
			'name',
			'phone_number'
		];

		public function user() {
			return $this->belongsTo(User::class);
		}

		public function pengajuans() {
			return $this->hasMany(Pengajuan::class, 'member_id');
		}
}
