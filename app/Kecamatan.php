<?php
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2019-10-25 10:09:55 
 * @Email: fer@dika.web.id 
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kecamatan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama'
    ];

    public function kelurahan(){
        return $this->hasMany('App\Kelurahan');
    }
}