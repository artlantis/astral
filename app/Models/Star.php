<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Star extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'stars';

  public function user() {
    return $this->belongsTo('App\Models\User');
  }

  public function tags() {
    return $this->belongsToMany('App\Models\Tag');
  }
  protected static function boot()
  {
    parent::boot();
    static::creating(function($star)
    {
      $user = JWTAuth::parseToken()->authenticate();
      $star->user_id = Auth::id();
    });
    static::saving(function($star)
    {
      $user = JWTAuth::parseToken()->authenticate();
      $star->user_id = Auth::id();
    });
    static::deleting(function($star)
    {
      \DB::table('star_tag')->where('star_id', $star->id)->delete();
    });
  }
}
