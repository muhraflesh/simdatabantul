<?php
namespace App\Utils\LaporanDownload;

/*
 * @Author      : Ferdhika Yudira 
 * @Date        : 2017-07-18 14:17:32 
 * @Web         : http://dika.web.id
 * @FileName    : HomeController.php
 */

use Excel;
use Carbon\Carbon;

class HotelBelanja {
    public function downloadOperatorBelanja($req, $data){
        $waktu = ($req->waktuTipe=='bulanan') ? $req->waktuBulan."-".$req->waktuTahun : $req->waktu;        
        $date = $waktu;

        Excel::create("Laporan_HotelBelanja_".ucwords(\Auth::user()->hotel->nama_hotel)."_".$waktu, function($excel) use ($waktu, $date, $data, $req){
            // Set the title
            $title = "Laporan_HotelBelanja_".ucwords(\Auth::user()->hotel->nama_hotel)."_".$waktu;
            $excel->setTitle($title)
                  ->setCreator(config('app.name', 'Larakuy'))
                  ->setCompany(config('app.name', 'Larakuy'))
                  ->setDescription($title);

            $excel->sheet(ucwords($req->waktuTipe)." - ".str_replace('/', '', $date), function($sheet) use ($date, $data, $req){
                $head1 = "Data Wisatawan Belanja di Hotel ".ucwords(\Auth::user()->hotel->nama_hotel);

                if($req->waktuTipe=='periodik'){
                    $tgl = explode('-', $req->waktu);
                    $tglAwal = \Carbon\Carbon::parse($tgl[0]);
                    $tglAkhir = \Carbon\Carbon::parse($tgl[1]);
                    $head2 = "Tanggal ".$tglAwal->format('d F Y')." sampai ".$tglAkhir->format('d F Y');
                }elseif($req->waktuTipe=='tahunan'){
                    $head2 = "Tahun ".$date;
                }elseif($req->waktuTipe=='bulanan'){
                    $tgl = \Carbon\Carbon::parse($req->waktuTahun."-".$req->waktuBulan);
                    // dd($tgl->format('F Y'));
                    $head2 = "Bulan ".$tgl->format('F Y');
                }elseif($req->waktuTipe=='mingguan'){
                    $tgl = \Carbon\Carbon::parse($req->waktuTahun."-".$req->waktuBulan);
                    // dd($tgl->format('F Y'));
                    $head2 = "Bulan ".$tgl->format('F Y');
                    // $tglAwal = \Carbon\Carbon::parse($req->waktu);
                    // $tglAkhir = \Carbon\Carbon::parse($req->waktu)->addDays(7);

                    // $head2 = "Tanggal ".$tglAwal->format('d F Y')." sampai ".$tglAkhir->format('d F Y');
                }elseif($req->waktuTipe=='harian'){
                    $tgl = \Carbon\Carbon::parse($req->waktu);
                    // dd($tgl->format('l, d F Y'));
                    $head2 = "Tanggal ".$tgl->format('d F Y');
                }

                if($req->waktuTipe=='tahunan'){
                    $jmlColWaktu = 11;
                    $head3 = ['No','Nama Hotel','Jenis Belanja','Wisatawan','Bulan','','','','','','','','','','','','Total'];
                }elseif($req->waktuTipe=='bulanan'){
                    $a_date = $req->waktuTahun."-".$req->waktuBulan."-01";                    
                    $jmlColWaktu = date('t', strtotime($a_date))-1;
                    $head3 = ['No','Nama Hotel','Jenis Belanja','Wisatawan','Tanggal'];
                    for($i=0; $i<$jmlColWaktu; $i++){
                        $head3[5+$i] = '';
                    }
                    $head3[5+$jmlColWaktu+1] = 'Total';
                }elseif($req->waktuTipe=='mingguan'){
                    $jmlColWaktu = 4;
                    $head3 = ['No','Nama Hotel','Jenis Belanja','Wisatawan','Minggu Ke','','','','','Total'];
                }elseif($req->waktuTipe=='harian'){
                    $jmlColWaktu = 0;
                    $head3 = ['No','Nama Hotel','Jenis Belanja','Wisatawan','Tanggal','Total'];
                }

                // dd($req->all());
                $sheet->appendRow([$head1]);
                $sheet->appendRow([$head2]);
                $sheet->appendRow([
                    ''
                ]);
                $sheet->appendRow($head3);

                $colCellDateAwal = "E";
                $colCellTotal = "F";
                // count cell col
                for($idxna=0;$idxna<$jmlColWaktu;$idxna++){
                    $colCellDateAwal++;
                    $colCellTotal++;
                }

                if($req->waktuTipe!='harian'){
                    $sheet->mergeCells('E4:'.$colCellDateAwal.'4');
                }
                
                if($req->waktuTipe=='tahunan'){
                    $sheet->appendRow(['','','','','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']);
                }elseif($req->waktuTipe=='bulanan'){
                    $rw = ['','','',''];
                    for($i=0; $i<=$jmlColWaktu; $i++){
                        $rw[5+$i] = $i+1;
                    }
                    $sheet->appendRow($rw);
                }elseif($req->waktuTipe=='mingguan'){
                    $sheet->appendRow(['','','','','1','2','3','4','5']);
                }elseif($req->waktuTipe=='harian'){
                    $sheet->appendRow(['','','','',$tgl->format('d-M-y')]);
                }
                
                // mergerow
                $sheet->mergeCells('A4:A5');
                $sheet->cells('A4:A5', function($cells) {
                    $cells->setValignment('center');
                });
                $sheet->mergeCells('B4:B5');
                $sheet->cells('B4:B5', function($cells) {
                    $cells->setValignment('center');
                });
                $sheet->mergeCells('C4:C5');
                $sheet->cells('C4:C5', function($cells) {
                    $cells->setValignment('center');
                });
                $sheet->mergeCells('D4:D5');
                $sheet->cells('D4:D5', function($cells) {
                    $cells->setValignment('center');
                });
                $sheet->cells('E4', function($cells) {
                    $cells->setAlignment('center');
                });                
                $sheet->mergeCells($colCellTotal.'4:'.$colCellTotal.'5');
                $sheet->cells($colCellTotal.'4:'.$colCellTotal.'5', function($cells) {
                    $cells->setValignment('center');
                });         

                // $sheet->setAllBorders('thin');
                $sheet->mergeCells('A1:'.$colCellTotal.'1');
                $sheet->cells('A1:'.$colCellTotal.'1', function($cells) {
                    $cells->setBackground('#B5B5B5');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });

                $sheet->mergeCells('A2:'.$colCellTotal.'2');
                $sheet->cells('A2:'.$colCellTotal.'2', function($cells) {
                    $cells->setBackground('#B5B5B5');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });

                $sheet->cells('A4:'.$colCellTotal.'5', function($cells) {
                    $cells->setBackground('#B5B5B5');
                    $cells->setFontWeight('bold');
                });
    
                // INSERT DATA HERE
                $idx = 1;
                $no=1;
                $idxValue = 6;
                foreach($data as $data){

                    if(!empty($req->waktuBulan)){
                        $waktunaa = $req->waktuBulan."|".$req->waktuTahun;
                    }else{
                        $waktunaa = $req->waktu ? $req->waktu : date('Y-m-d');
                    }

                    $dataStatistiks = $this->getStatistikBelanja($data->hotel_id, $req->waktuTipe, $waktunaa);

                    // dd($dataStatistiks);
                    // inisiasi
                    // append namawisata
                    $idxCol = 5;
                    foreach($dataStatistiks as $idx => $ds){
                        $b1 = [$no, $data->hotel->nama_hotel];
                        
                        $b1[2] = ucwords($idx);
                        $b1[3] = 'Wisman';
                        $b2 = ['','','', 'Wisnus'];
                        $b3 = ['','','', 'Jumlah'];

                        // count
                        foreach($ds as $idxColBulan => $dsBulan){
                            $b1[$idxCol+$idxColBulan] = $dsBulan['wisman'];
                            $b2[$idxCol+$idxColBulan] = $dsBulan['wisnus'];
                            $b3[$idxCol+$idxColBulan] = $dsBulan['jumlah'];
                        }

                        $sheet->appendRow($b1);
                        $sheet->appendRow($b2);
                        $sheet->appendRow($b3);
                    }

                    $sheet->mergeCells('A'.$idxValue.':A'.($idxValue+11));
                    $sheet->mergeCells('B'.$idxValue.':B'.($idxValue+11));
                    $sheet->cells('A'.$idxValue.':B'.($idxValue+11), function($cells) {
                        $cells->setValignment('center');
                    });

                    // Total
                    for($i=0;$i<12;$i++){
                        $sheet->cells($colCellTotal.($idxValue+$i), function($cells) use ($idxValue, $i, $colCellDateAwal) {
                            $cells->setValue('=SUM(E'.($idxValue+$i).':'.$colCellDateAwal.($idxValue+$i).')');
                        });
                    }
                    
                    $idxValue+=12;
                    $no++;
                }
                
            });

        })->download('xls');
    }
    
    public function downloadBelanja($req, $data){

        $waktu = ($req->waktuTipe=='bulanan') ? $req->waktuBulan."-".$req->waktuTahun : $req->waktu;        
        $date = $waktu;
       
        Excel::create("Laporan_Hotel_Belanja_".$waktu, function($excel) use ($waktu, $date, $data, $req){
            // Set the title
            $title = "Laporan_Hotel_Belanja_".$waktu;

            $excel->setTitle($title)
                  ->setCreator(config('app.name', 'Larakuy'))
                  ->setCompany(config('app.name', 'Larakuy'))
                  ->setDescription($title);
            
            $excel->sheet(ucwords($req->waktuTipe)." - ".str_replace('/', '', $date), function($sheet) use ($date, $data, $req){
                
                $head1 = "Data Wisatawan Hotel Belanja";

                if($req->waktuTipe=='periodik'){
                    $tgl = explode('-', $req->waktu);
                    $tglAwal = \Carbon\Carbon::parse($tgl[0]);
                    $tglAkhir = \Carbon\Carbon::parse($tgl[1]);
                    $head2 = "Kabupaten Bantul Tanggal ".$tglAwal->format('d F Y')." sampai ".$tglAkhir->format('d F Y');
                }elseif($req->waktuTipe=='tahunan'){
                    $head2 = "Kabupaten Bantul Tahun ".$date;
                }elseif($req->waktuTipe=='bulanan'){
                    $tgl = \Carbon\Carbon::parse($req->waktuTahun."-".$req->waktuBulan);
                    // dd($tgl->format('F Y'));
                    $head2 = "Kabupaten Bantul Bulan ".$tgl->format('F Y');
                }elseif($req->waktuTipe=='mingguan'){
                    $tgl = \Carbon\Carbon::parse($req->waktuTahun."-".$req->waktuBulan);
                    // dd($tgl->format('F Y'));
                    $head2 = "Kabupaten Bantul Bulan ".$tgl->format('F Y');
                    // $tglAwal = \Carbon\Carbon::parse($req->waktu);
                    // $tglAkhir = \Carbon\Carbon::parse($req->waktu)->addDays(7);

                    // $head2 = "Kabupaten Bantul Tanggal ".$tglAwal->format('d F Y')." sampai ".$tglAkhir->format('d F Y');
                }elseif($req->waktuTipe=='harian'){
                    $tgl = \Carbon\Carbon::parse($req->waktu);
                    // dd($tgl->format('l, d F Y'));
                    $head2 = "Kabupaten Bantul Tanggal ".$tgl->format('d F Y');
                }

                if($req->waktuTipe=='tahunan'){
                    $jmlColWaktu = 11;
                    $head3 = ['No','Nama Hotel','Jenis Belanja','Wisatawan','Bulan','','','','','','','','','','','','Total'];
                }elseif($req->waktuTipe=='bulanan'){
                    $a_date = $req->waktuTahun."-".$req->waktuBulan."-01";                    
                    $jmlColWaktu = date('t', strtotime($a_date))-1;
                    $head3 = ['No','Nama Hotel','Jenis Belanja','Wisatawan','Tanggal'];
                    for($i=0; $i<$jmlColWaktu; $i++){
                        $head3[5+$i] = '';
                    }
                    $head3[5+$jmlColWaktu+1] = 'Total';
                }elseif($req->waktuTipe=='mingguan'){
                    $jmlColWaktu = 4;
                    $head3 = ['No','Nama Hotel','Jenis Belanja','Wisatawan','Minggu Ke','','','','','Total'];
                }elseif($req->waktuTipe=='harian'){
                    $jmlColWaktu = 0;
                    $head3 = ['No','Nama Hotel','Jenis Belanja','Wisatawan','Tanggal','Total'];
                }

                // dd($req->all());
                $sheet->appendRow([$head1]);
                $sheet->appendRow([$head2]);
                $sheet->appendRow([
                    ''
                ]);
                $sheet->appendRow($head3);

                $colCellDateAwal = "E";
                $colCellTotal = "F";
                // count cell col
                for($idxna=0;$idxna<$jmlColWaktu;$idxna++){
                    $colCellDateAwal++;
                    $colCellTotal++;
                }

                if($req->waktuTipe!='harian'){
                    $sheet->mergeCells('E4:'.$colCellDateAwal.'4');
                }
                
                if($req->waktuTipe=='tahunan'){
                    $sheet->appendRow(['','','','','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']);
                }elseif($req->waktuTipe=='bulanan'){
                    $rw = ['','','',''];
                    for($i=0; $i<=$jmlColWaktu; $i++){
                        $rw[5+$i] = $i+1;
                    }
                    $sheet->appendRow($rw);
                }elseif($req->waktuTipe=='mingguan'){
                    $sheet->appendRow(['','','','','1','2','3','4','5']);
                }elseif($req->waktuTipe=='harian'){
                    $sheet->appendRow(['','','','',$tgl->format('d-M-y')]);
                }
                
                // mergerow
                $sheet->mergeCells('A4:A5');
                $sheet->cells('A4:A5', function($cells) {
                    $cells->setValignment('center');
                });
                $sheet->mergeCells('B4:B5');
                $sheet->cells('B4:B5', function($cells) {
                    $cells->setValignment('center');
                });
                $sheet->mergeCells('C4:C5');
                $sheet->cells('C4:C5', function($cells) {
                    $cells->setValignment('center');
                });
                $sheet->mergeCells('D4:D5');
                $sheet->cells('D4:D5', function($cells) {
                    $cells->setValignment('center');
                });
                $sheet->cells('E4', function($cells) {
                    $cells->setAlignment('center');
                });                
                $sheet->mergeCells($colCellTotal.'4:'.$colCellTotal.'5');
                $sheet->cells($colCellTotal.'4:'.$colCellTotal.'5', function($cells) {
                    $cells->setValignment('center');
                });         

                // $sheet->setAllBorders('thin');
                $sheet->mergeCells('A1:'.$colCellTotal.'1');
                $sheet->cells('A1:'.$colCellTotal.'1', function($cells) {
                    $cells->setBackground('#B5B5B5');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });

                $sheet->mergeCells('A2:'.$colCellTotal.'2');
                $sheet->cells('A2:'.$colCellTotal.'2', function($cells) {
                    $cells->setBackground('#B5B5B5');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });

                $sheet->cells('A4:'.$colCellTotal.'5', function($cells) {
                    $cells->setBackground('#B5B5B5');
                    $cells->setFontWeight('bold');
                });
    
                // INSERT DATA HERE
                $idx = 1;
                $no=1;
                $idxValue = 6;
                foreach($data as $data){

                    if(!empty($req->waktuBulan)){
                        $waktunaa = $req->waktuBulan."|".$req->waktuTahun;
                    }else{
                        $waktunaa = $req->waktu ? $req->waktu : date('Y-m-d');
                    }

                    $dataStatistiks = $this->getStatistikBelanja($data->hotel_id, $req->waktuTipe, $waktunaa);

                    // dd($dataStatistiks);
                    // inisiasi
                    // append namahotel
                    $idxCol = 5;
                    foreach($dataStatistiks as $idx => $ds){
                        $b1 = [$no, $data->hotel->nama_hotel];
                        
                        $b1[2] = ucwords($idx);
                        $b1[3] = 'Wisman';
                        $b2 = ['','','', 'Wisnus'];
                        $b3 = ['','','', 'Jumlah'];

                        // count
                        foreach($ds as $idxColBulan => $dsBulan){
                            $b1[$idxCol+$idxColBulan] = $dsBulan['wisman'];
                            $b2[$idxCol+$idxColBulan] = $dsBulan['wisnus'];
                            $b3[$idxCol+$idxColBulan] = $dsBulan['jumlah'];
                        }

                        $sheet->appendRow($b1);
                        $sheet->appendRow($b2);
                        $sheet->appendRow($b3);
                    }

                    $sheet->mergeCells('A'.$idxValue.':A'.($idxValue+11));
                    $sheet->mergeCells('B'.$idxValue.':B'.($idxValue+11));
                    $sheet->cells('A'.$idxValue.':B'.($idxValue+11), function($cells) {
                        $cells->setValignment('center');
                    });

                    // Total
                    for($i=0;$i<12;$i++){
                        $sheet->cells($colCellTotal.($idxValue+$i), function($cells) use ($idxValue, $i, $colCellDateAwal) {
                            $cells->setValue('=SUM(E'.($idxValue+$i).':'.$colCellDateAwal.($idxValue+$i).')');
                        });
                    }
                    
                    $idxValue+=12;
                    $no++;
                }
            });
            
            
        })->download('xls');
    }

    static function getStatistikBelanja($hotelId, $jenisLaporan="tahunan", $waktu="2019-08-31"){

        $model = \App\HotelBelanja::where('hotel_id', $hotelId);

        if($jenisLaporan=='periodik'){
            $tanggal = explode('-', $waktu);
            $tglAwal = str_replace('/', '-', trim($tanggal[0]));
            $tglAkhir = str_replace('/', '-', trim($tanggal[1]));
            $model->whereBetween('tanggal', [$tglAwal, $tglAkhir]);
        }else if($jenisLaporan=='tahunan'){
            $model->whereYear('tanggal', $waktu);
        }else if($jenisLaporan=='bulanan'){
            $tanggal = explode('|', $waktu);
            $waktuBulan = $tanggal[0];
            $waktuTahun = $tanggal[1];
            $model->whereMonth('tanggal', $waktuBulan);
            $model->whereYear('tanggal', $waktuTahun);
        }else if($jenisLaporan=='mingguan'){
            // $tglAwal = \Carbon\Carbon::parse($waktu);
            // $tglAkhir = \Carbon\Carbon::parse($waktu)->addDays(7);
            // $model->whereBetween('tanggal', [$tglAwal, $tglAkhir]);
            $tanggal = explode('|', $waktu);
            $waktuBulan = $tanggal[0];
            $waktuTahun = $tanggal[1];
            $model->whereMonth('tanggal', $waktuBulan);
            $model->whereYear('tanggal', $waktuTahun);
        }else if($jenisLaporan=='harian'){
            $model->where('tanggal', $waktu);
        }

        $hasil = $model->get();

        // inisiasi
        $data = [
            'kuliner' => [],
            'transportasi' => [],
            'oleholeh' => [],
            'paketwisata' => []
        ];
        
        if($jenisLaporan=='tahunan'){
            for($i=0; $i<12; $i++){
                array_push($data['kuliner'], [
                    'wisman' => 0,
                    'wisnus' => 0,
                    'jumlah' => 0,
                ]);
                array_push($data['transportasi'], [
                    'wisman' => 0,
                    'wisnus' => 0,
                    'jumlah' => 0,
                ]);
                array_push($data['oleholeh'], [
                    'wisman' => 0,
                    'wisnus' => 0,
                    'jumlah' => 0,
                ]);
                array_push($data['paketwisata'], [
                    'wisman' => 0,
                    'wisnus' => 0,
                    'jumlah' => 0,
                ]);
            }
            foreach($hasil as $mdl){
                $bulan = Carbon::parse($mdl->tanggal)->format('m');
                
                if($mdl->tipe_belanja=='mancanegara'){
                    $data[$mdl->kategori_belanja][$bulan-1]['wisman'] += (int) $mdl->jumlah_orang;
                }elseif($mdl->tipe_belanja=='nusantara'){
                    $data[$mdl->kategori_belanja][$bulan-1]['wisnus'] += (int) $mdl->jumlah_orang;
                }

                $data[$mdl->kategori_belanja][$bulan-1]['jumlah'] = $data[$mdl->kategori_belanja][$bulan-1]['wisman']+$data[$mdl->kategori_belanja][$bulan-1]['wisnus'];
            }
        }elseif($jenisLaporan=='bulanan'){
            $a_date = $waktuTahun."-".$waktuBulan."-01";
            for($i=0; $i<date('t', strtotime($a_date)); $i++){
                array_push($data['kuliner'], [
                    'wisman' => 0,
                    'wisnus' => 0,
                    'jumlah' => 0,
                ]);
                array_push($data['transportasi'], [
                    'wisman' => 0,
                    'wisnus' => 0,
                    'jumlah' => 0,
                ]);
                array_push($data['oleholeh'], [
                    'wisman' => 0,
                    'wisnus' => 0,
                    'jumlah' => 0,
                ]);
                array_push($data['paketwisata'], [
                    'wisman' => 0,
                    'wisnus' => 0,
                    'jumlah' => 0,
                ]);
            }

            foreach($hasil as $mdl){
                $day = Carbon::parse($mdl->tanggal)->format('d');
                
                if($mdl->tipe_belanja=='mancanegara'){
                    $data[$mdl->kategori_belanja][$day-1]['wisman'] += (int) $mdl->jumlah_orang;
                }elseif($mdl->tipe_belanja=='nusantara'){
                    $data[$mdl->kategori_belanja][$day-1]['wisnus'] += (int) $mdl->jumlah_orang;
                }

                $data[$mdl->kategori_belanja][$day-1]['jumlah'] = $data[$mdl->kategori_belanja][$day-1]['wisman']+$data[$mdl->kategori_belanja][$day-1]['wisnus'];
            }
        }elseif($jenisLaporan=='mingguan'){
            // Week1 = 1st to 5th
            // Week2 = 6th to 12th
            // Week3 = 13th to 19th
            // Week4 = 20th to 26th
            // Week5 = 27th to 30th

            $firstDate = $waktuTahun."-".$waktuBulan."-01";
            $lastDate = date('Y-m-t', strtotime($firstDate));
            $weekNumber = HotelBelanja::weekOfMonth($lastDate);

            for($i=0; $i<$weekNumber; $i++){
                array_push($data['kuliner'], [
                    'wisman' => 0,
                    'wisnus' => 0,
                    'jumlah' => 0,
                ]);
                array_push($data['transportasi'], [
                    'wisman' => 0,
                    'wisnus' => 0,
                    'jumlah' => 0,
                ]);
                array_push($data['oleholeh'], [
                    'wisman' => 0,
                    'wisnus' => 0,
                    'jumlah' => 0,
                ]);
                array_push($data['paketwisata'], [
                    'wisman' => 0,
                    'wisnus' => 0,
                    'jumlah' => 0,
                ]);
            }

            foreach($hasil as $mdl){
                $datena = Carbon::parse($mdl->tanggal)->format('Y-m-d');
                $weekNumber = HotelBelanja::weekOfMonth($datena);
                
                if($mdl->tipe_belanja=='mancanegara'){
                    $data[$mdl->kategori_belanja][$weekNumber-1]['wisman'] += (int) $mdl->jumlah_orang;
                }elseif($mdl->tipe_belanja=='nusantara'){
                    $data[$mdl->kategori_belanja][$weekNumber-1]['wisnus'] += (int) $mdl->jumlah_orang;
                }

                $data[$mdl->kategori_belanja][$weekNumber-1]['jumlah'] = $data[$mdl->kategori_belanja][$weekNumber-1]['wisman']+$data[$mdl->kategori_belanja][$weekNumber-1]['wisnus'];
            }
        }elseif($jenisLaporan=='harian'){
            array_push($data['kuliner'], [
                'wisman' => 0,
                'wisnus' => 0,
                'jumlah' => 0,
            ]);
            array_push($data['transportasi'], [
                'wisman' => 0,
                'wisnus' => 0,
                'jumlah' => 0,
            ]);
            array_push($data['oleholeh'], [
                'wisman' => 0,
                'wisnus' => 0,
                'jumlah' => 0,
            ]);
            array_push($data['paketwisata'], [
                'wisman' => 0,
                'wisnus' => 0,
                'jumlah' => 0,
            ]);

            foreach($hasil as $mdl){
                $bulan = 1;
                
                if($mdl->tipe_belanja=='mancanegara'){
                    $data[$mdl->kategori_belanja][$bulan-1]['wisman'] += (int) $mdl->jumlah_orang;
                }elseif($mdl->tipe_belanja=='nusantara'){
                    $data[$mdl->kategori_belanja][$bulan-1]['wisnus'] += (int) $mdl->jumlah_orang;
                }

                $data[$mdl->kategori_belanja][$bulan-1]['jumlah'] = $data[$mdl->kategori_belanja][$bulan-1]['wisman']+$data[$mdl->kategori_belanja][$bulan-1]['wisnus'];
            }
        }

        return $data;
    }

    static function weekOfMonth($date) {
        // estract date parts
        list($y, $m, $d) = explode('-', date('Y-m-d', strtotime($date)));
    
        // current week, min 1
        $w = 1;
    
        // for each day since the start of the month
        for ($i = 1; $i <= $d; ++$i) {
            // if that day was a sunday and is not the first day of month
            if ($i > 1 && date('w', strtotime("$y-$m-$i")) == 0) {
                // increment current week
                ++$w;
            }
        }
    
        // now return
        return $w;
    }
}