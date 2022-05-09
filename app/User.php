<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Position;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'photo', 'position_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function loadImage($image, $imageOptimizer)
    {
        $source = file_get_contents($image);

        $name = Str::random(10) . $this->id;
        $imageDir = 'images/users/';
        $savePath = $imageDir . $name . '.' . $image->extension();

        $result = $imageOptimizer
            ->withApiKey(env('TINIFY_API_KEY'))
            ->optimize(array(
                "method" => "cover",
                "width" => 70,
                "height" => 70
            ), $source, $savePath);

        $this->photo = $result->location();
        $this->save();
        return $result->location();
    }

    public static function paginateWithOffset($offset, $count)
    {
        return self::where('id', '>=', function ($query) use($offset){
            $query->select('id')->from('users')->skip($offset)->take(1)->orderBy('id');
        })->paginate($count, ['*'], 'page', 1);
    }
}
