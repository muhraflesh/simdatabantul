<?php
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2019-10-25 10:09:55 
 * @Email: fer@dika.web.id 
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengelola extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengelola';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function wisata(){
        return $this->belongsTo('App\Wisata');
    }
}