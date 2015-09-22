<?php namespace vendocrat\Followers\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Followable
 * @package vendocrat\Followers\Models
 */
class Followable extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'followables';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'follower_id',
		'follower_type',
		'followable_id',
		'followable_type',
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];

	/**
	 * Morph followables
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function followable()
	{
		return $this->belongsTo($this->followable_type);
	}

	/**
	 * Morph followers
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function follower()
	{
		return $this->belongsTo($this->follower_type);
	}

	/**
	 * @param $query
	 * @param Model $followable
	 * @return mixed
	 */
	public function scopeFollowing( $query, $followable )
	{
		return $query
			->where( 'followable_id',   '=', $followable->id )
			->where( 'followable_type', '=', get_class($followable) );
	}

	/**
	 * @param $query
	 * @param Model $follower
	 * @return mixed
	 */
	public function scopeFollowedBy( $query, $follower )
	{
		return $query
			->where( 'follower_id',   '=', $follower->id )
			->where( 'follower_type', '=', get_class($follower) );
	}
}