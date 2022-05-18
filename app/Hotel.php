<?php
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2019-10-25 10:09:55 
 * @Email: fer@dika.web.id 
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hotel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_hotel',
        'alamat_hotel',
        'kontak_hotel',
        'email_hotel',
        'jenis_hotel'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function kamar(){
        return $this->hasMany('App\Kamar');
    }
}