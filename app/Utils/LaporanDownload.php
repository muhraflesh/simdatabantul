<?php
namespace App\Utils;

/*
 * @Author      : Ferdhika Yudira 
 * @Date        : 2017-07-18 14:17:32 
 * @Web         : http://dika.web.id
 * @FileName    : HomeController.php
 */

use App\Utils\LaporanDownload\DesaWisata;
use App\Utils\LaporanDownload\ObyekWisata;
use App\Utils\LaporanDownload\Belanja;
use App\Utils\LaporanDownload\Homestay;
use App\Utils\LaporanDownload\Hotel;

class LaporanDownload{
    private $desa;
    private $obyek;
    private $belanja;
    private $homestay;
    private $hotel;

    public function __construct(){
        $this->desa = new DesaWisata;
        $this->obyek = new ObyekWisata;
        $this->belanja = new Belanja;
        $this->homestay = new Homestay;
        $this->hotel = new Hotel;
    }

    public function __call($method, $args){
        $this->desa->$method($args[0], $args[1]);
        $this->obyek->$method($args[0], $args[1]);
        $this->belanja->$method($args[0], $args[1]);
        $this->homestay->$method($args[0], $args[1]);
        $this->hotel->$method($args[0], $args[1]);
    }
}