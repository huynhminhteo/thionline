<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MNotification extends Model
{
	protected $table = 'm_notification';
	protected $dateFormat = 'Y-m-d H:i:s.v';
	public static $snakeAttributes = false;

	protected $casts = [
	
	];

	protected $dates = [
		'insert_at',
		'update_at'
	];

	protected $fillable = [
		'insert_user',
		'insert_at',
		'update_user',
		'update_at',
		'title',
		'content',
		'status'
	];
	protected $appends = ['content_mobile'];
	public function mUser()
	{
		return $this->hasOne(MUser::class, 'id','insert_user')->withTrashed();
	}

	public function mUserRead(){
		return $this->belongsToMany(MUser::class,'t_users_notification','id_notification','id_user');
	}

	public function getContentMobileAttribute(){
		$pattern = '~[a-z]+://\S+~';
		$out  = [];
		$num_found = preg_match_all($pattern, $this->content, $out);

		$content = str_replace("\r\n", "<br>", $this->content);

		if($num_found > 0){
			for($i = 0; $i < $num_found; $i++) {
				$content = str_replace($out[0][$i],'<a href="'.$i.'">'.$i.'</a>', $content);
			}
			for($i = 0; $i < $num_found; $i++) {
				$content = str_replace('<a href="'.$i.'">'.$i.'</a>','<a href="'.$out[0][$i].'" style="line-break: anywhere;">'.$out[0][$i].'</a>', $content);
			}
		}

		return $content;
	}
}
