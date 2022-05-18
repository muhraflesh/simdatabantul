<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengajuan extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengajuan_destinasi';

    protected $primaryKey = 'id_pengajuan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path_file_susunan_pengurus',
        'path_file_permohonan_registrasi',
        'path_file_foto_deskripsi',
        'tanggal_pengajuan',
        'status',
        'id_hotel',
        'id_wisata'
    ];

}