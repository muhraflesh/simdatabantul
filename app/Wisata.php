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

class Wisata extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wisata';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'alamat',
        'kelurahan',
        'kecamatan',
        'foto',
        'tipe_wisata'
    ];

    public function kelurahan(){
        return $this->belongsTo('App\Kelurahan');
    }

    public function akomodasi(){
        return $this->hasMany('App\Akomodasi');
    }
    
    public function pengelola(){
        return $this->hasMany('App\Pengelola');
    }

    public function kunjungan(){
        return $this->hasMany('App\WisataKunjungan');
    }

    public function belanja(){
        return $this->hasMany('App\Belanja');
    }

    public function fotos(){
        return $this->hasMany('App\WisataFoto');
    }
}