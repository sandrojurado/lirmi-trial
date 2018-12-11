<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
	protected $table = 'classes';
	protected $appends = ['bullet_list'];

	public function bullet()
	{
		return $this->belongsToMany('App\Goal','class_goals','class_id');
	}
	public function getBulletListAttribute()
	{
		$bullets = $this->bullet;
		$list = [];
		foreach ($bullets as $bullet)
		{
			$list[] = $bullet->id;
		}
		return $list;
	}
}
