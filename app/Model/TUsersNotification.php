<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TUsersNotification extends Model
{
    protected $table = 't_users_notification';
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $casts = [
	
	];


	protected $fillable = [
		'id_notification',
		'id_user'
	];

	public function mUser()
	{
		return $this->hasMany(MUser::class, 'id_user');
	}

    public function MNotification()
	{
		return $this->hasMany(MNotification::class, 'id_notification');
	}
}
