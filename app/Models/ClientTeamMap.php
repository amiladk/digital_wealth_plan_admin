<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTeamMap extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent',
        'child',
        'side',
    ];

    public function client()
    {
        return $this->hasOne(Client::class,'id','child');
    }


    public $timestamps = false;

    protected $table = 'client_team_map';
}
