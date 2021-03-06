<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RadiusIPPool extends Model {
    protected $table = 'radippool';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pool_name',
        'framedipaddress',
        'nasipaddress',
        'calledstationid',
        'callingstationid',
        'expiry_time',
        'username',
        'pool_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [''];
}