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

class WisataKunjungan extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wisata_kunjungan';

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
        'tanggal',
        'jumlah_wisatawan',
        'keterangan',
        'foto',
        'tipe_kunjungan'
    ];

    public function wisata(){
        return $this->belongsTo('App\Wisata');
    }

    public function fotos(){
        return $this->hasMany('App\WisataKunjunganFoto');
    }
}