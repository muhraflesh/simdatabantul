<?php
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2019-10-25 10:09:55 
 * @Email: fer@dika.web.id 
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelBelanjaPaketWisata extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hotel_belanja_paket_wisata';

    public function belanja(){
        return $this->belongsTo('App\HotelBelanja', 'hotel_belanja_id');
    }

    public function paketWisata(){
        return $this->belongsTo('App\HotelPaketWisata', 'hotel_paket_wisata_id');
    }
}