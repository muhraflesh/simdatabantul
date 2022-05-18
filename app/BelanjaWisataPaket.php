<?php
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2019-10-25 10:09:55 
 * @Email: fer@dika.web.id 
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class BelanjaWisataPaket extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'belanja_wisata_paket';

    public function belanja(){
        return $this->belongsTo('App\Belanja');
    }

    public function wisataPaket(){
        return $this->belongsTo('App\WisataPaket');
    }
}