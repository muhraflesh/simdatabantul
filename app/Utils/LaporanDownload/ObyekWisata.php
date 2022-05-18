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

class ObyekWisata {
    public function downloadOperatorObyek($req, $data){
        $waktu = ($req->waktuTipe=='bulanan') ? $req->waktuBulan."-".$req->waktuTahun : $req->waktu;        
        $date = $waktu;

        Excel::create("Laporan_Wisatawan_".ucwords(\Auth::user()->pengelola[0]->wisata->nama)."_".$waktu, function($excel) use ($waktu, $date, $data, $req){
            // Set the title
            $title = "Laporan_Wisatawan_".ucwords(\Auth::user()->pengelola[0]->wisata->nama)."_".$waktu;
            $excel->setTitle($title)
                  ->setCreator(config('app.name', 'Larakuy'))
                  ->setCompany(config('app.name', 'Larakuy'))
                  ->setDescription($title);

            $excel->sheet(ucwords($req->waktuTipe)." - ".str_replace('/', '', $date), function($sheet) use ($date, $data, $req){
                $head1 = "Data Wisatawan Obyek Wisata ".ucwords(\Auth::user()->pengelola[0]->wisata->nama);

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
                    // $tglAwal = \Carbon\Carbon::parse($req->waktu);
                    // $tglAkhir = \Carbon\Carbon::parse($req->waktu)->addDays(7);

                    // $head2 = "Tanggal ".$tglAwal->format('d F Y')." sampai ".$tglAkhir->format('d F Y');
                    $tgl = \Carbon\Carbon::parse($req->waktuTahun."-".$req->waktuBulan);
                    // dd($tgl->format('F Y'));
                    $head2 = "Bulan ".$tgl->format('F Y');
                }elseif($req->waktuTipe=='harian'){
                    $tgl = \Carbon\Carbon::parse($req->waktu);
                    // dd($tgl->format('l, d F Y'));
                    $head2 = "Tanggal ".$tgl->format('d F Y');
                }

                if($req->waktuTipe=='tahunan'){
                    $jmlColWaktu = 11;
                    $head3 = ['No','Obyek Wisata','Alamat','Wisatawan','Bulan','','','','','','','','','','','','Total'];
                }elseif($req->waktuTipe=='bulanan'){
                    $a_date = $req->waktuTahun."-".$req->waktuBulan."-01";                    
                    $jmlColWaktu = date('t', strtotime($a_date))-1;
                    $head3 = ['No','Desa Wisata','Kecamatan','Wisatawan','Tanggal'];
                    for($i=0; $i<$jmlColWaktu; $i++){
                        $head3[5+$i] = '';
                    }
                    $head3[5+$jmlColWaktu+1] = 'Total';
                }elseif($req->waktuTipe=='mingguan'){
                    $jmlColWaktu = 4;
                    $head3 = ['No','Desa Wisata','Kecamatan','Wisatawan','Minggu Ke','','','','','Total'];
                }elseif($req->waktuTipe=='harian'){
                    $jmlColWaktu = 0;
                    $head3 = ['No','Desa Wisata','Kecamatan','Wisatawan','Tanggal','Total'];
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

                $sheet->cells('E4:'.$colCellDateAwal.'5', function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->mergeCells($colCellTotal.'4:'.$colCellTotal.'5');
                $sheet->cells($colCellTotal.'4:'.$colCellTotal.'5', function($cells) {
                    $cells->setValignment('center');
                });

                // dd($colCellDateAwal,$colCellTotal);
                
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
                    $b1 = [$no, $data->wisata->nama, $data->wisata->alamat, 'Wisman'];
                    $b2 = ['', '', '', 'Wisnus'];
                    $b3 = ['', '', '', 'Jumlah'];

                    if(!empty($req->waktuBulan)){
                        $waktunaa = $req->waktuBulan."|".$req->waktuTahun;
                    }else{
                        $waktunaa = $req->waktu ? $req->waktu : date('Y-m-d');
                    }

                    $dataStatistiks = $this->getStatistikObyekWisata($data->wisata_id, $req->waktuTipe, $waktunaa);
                    // inisiasi
                    foreach($dataStatistiks['mancanegara'] as $idx => $ds){
                        $b1[$idx+5] = 0;
                        $b2[$idx+5] = 0;
                        $b3[$idx+5] = 0;
                    }

                    // count
                    foreach($dataStatistiks['mancanegara'] as $idx => $ds){
                        $b1[$idx+5] += $dataStatistiks['mancanegara'][$idx];
                        $b2[$idx+5] += $dataStatistiks['nusantara'][$idx];
                        $b3[$idx+5] += $dataStatistiks['mancanegara'][$idx]+$dataStatistiks['nusantara'][$idx];
                    }
                    
                    $idx++;
                    
                    // buat total
                    $b1[$idx+5] = 0;
                    $b2[$idx+5] = 0;
                    $b3[$idx+5] = 0;

                    $sheet->appendRow($b1);
                    $sheet->appendRow($b2);
                    $sheet->appendRow($b3);

                    // jumlah orang
                    $sheet->cells($colCellTotal.$idxValue, function($cells) use ($idxValue, $colCellDateAwal) {
                        $cells->setValue('=SUM(E'.$idxValue.':'.$colCellDateAwal.$idxValue.')');
                    });
                    $idxValue++;
                    // lama
                    $sheet->cells($colCellTotal.$idxValue, function($cells) use ($idxValue, $colCellDateAwal) {
                        $cells->setValue('=SUM(E'.$idxValue.':'.$colCellDateAwal.$idxValue.')');
                    });
                    $idxValue++;
                    // jumlah
                    $sheet->cells($colCellTotal.$idxValue, function($cells) use ($idxValue, $colCellDateAwal) {
                        $cells->setValue('=SUM(E'.$idxValue.':'.$colCellDateAwal.$idxValue.')');
                    });
                    $idxValue++;
                    $no++;
                }
                
            });

        })->download('xls');
    }

    public function downloadObyek($req, $data){

        $waktu = ($req->waktuTipe=='bulanan') ? $req->waktuBulan."-".$req->waktuTahun : $req->waktu;        
        $date = $waktu;
       
        Excel::create("Laporan_ObyekWisata_".$waktu, function($excel) use ($waktu, $date, $data, $req){
            // Set the title
            $title = "Laporan_ObyekWisata_".$waktu;

            $excel->setTitle($title)
                  ->setCreator(config('app.name', 'Larakuy'))
                  ->setCompany(config('app.name', 'Larakuy'))
                  ->setDescription($title);
            
            $excel->sheet(ucwords($req->waktuTipe)." - ".str_replace('/', '', $date), function($sheet) use ($date, $data, $req){
                
                $head1 = "Data Wisatawan Obyek Wisata";

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
                    // $tglAwal = \Carbon\Carbon::parse($req->waktu);
                    // $tglAkhir = \Carbon\Carbon::parse($req->waktu)->addDays(7);

                    // $head2 = "Kabupaten Bantul Tanggal ".$tglAwal->format('d F Y')." sampai ".$tglAkhir->format('d F Y');
                    
                    $tgl = \Carbon\Carbon::parse($req->waktuTahun."-".$req->waktuBulan);
                    // dd($tgl->format('F Y'));
                    $head2 = "Kabupaten Bantul Bulan ".$tgl->format('F Y');
                }elseif($req->waktuTipe=='harian'){
                    $tgl = \Carbon\Carbon::parse($req->waktu);
                    // dd($tgl->format('l, d F Y'));
                    $head2 = "Kabupaten Bantul Tanggal ".$tgl->format('d F Y');
                }

                if($req->waktuTipe=='tahunan'){
                    $jmlColWaktu = 11;
                    $head3 = ['No','Obyek Wisata','Alamat','Wisatawan','Bulan','','','','','','','','','','','','Total'];
                }elseif($req->waktuTipe=='bulanan'){
                    $a_date = $req->waktuTahun."-".$req->waktuBulan."-01";                    
                    $jmlColWaktu = date('t', strtotime($a_date))-1;
                    $head3 = ['No','Desa Wisata','Kecamatan','Wisatawan','Tanggal'];
                    for($i=0; $i<$jmlColWaktu; $i++){
                        $head3[5+$i] = '';
                    }
                    $head3[5+$jmlColWaktu+1] = 'Total';
                }elseif($req->waktuTipe=='mingguan'){
                    $jmlColWaktu = 4;
                    $head3 = ['No','Desa Wisata','Kecamatan','Wisatawan','Minggu Ke','','','','','Total'];
                }elseif($req->waktuTipe=='harian'){
                    $jmlColWaktu = 0;
                    $head3 = ['No','Desa Wisata','Kecamatan','Wisatawan','Tanggal','Total'];
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

                $sheet->cells('E4:'.$colCellDateAwal.'5', function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->mergeCells($colCellTotal.'4:'.$colCellTotal.'5');
                $sheet->cells($colCellTotal.'4:'.$colCellTotal.'5', function($cells) {
                    $cells->setValignment('center');
                });

                // dd($colCellDateAwal,$colCellTotal);
                
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
                    $b1 = [$no, $data->wisata->nama, $data->wisata->alamat, 'Wisman'];
                    $b2 = ['', '', '', 'Wisnus'];
                    $b3 = ['', '', '', 'Jumlah'];

                    if(!empty($req->waktuBulan)){
                        $waktunaa = $req->waktuBulan."|".$req->waktuTahun;
                    }else{
                        $waktunaa = $req->waktu ? $req->waktu : date('Y-m-d');
                    }

                    $dataStatistiks = $this->getStatistikObyekWisata($data->wisata_id, $req->waktuTipe, $waktunaa);
                    // inisiasi
                    foreach($dataStatistiks['mancanegara'] as $idx => $ds){
                        $b1[$idx+5] = 0;
                        $b2[$idx+5] = 0;
                        $b3[$idx+5] = 0;
                    }

                    // count
                    foreach($dataStatistiks['mancanegara'] as $idx => $ds){
                        $b1[$idx+5] += $dataStatistiks['mancanegara'][$idx];
                        $b2[$idx+5] += $dataStatistiks['nusantara'][$idx];
                        $b3[$idx+5] += $dataStatistiks['mancanegara'][$idx]+$dataStatistiks['nusantara'][$idx];
                    }
                    
                    $idx++;
                    
                    // buat total
                    $b1[$idx+5] = 0;
                    $b2[$idx+5] = 0;
                    $b3[$idx+5] = 0;

                    $sheet->appendRow($b1);
                    $sheet->appendRow($b2);
                    $sheet->appendRow($b3);

                    // jumlah orang
                    $sheet->cells($colCellTotal.$idxValue, function($cells) use ($idxValue, $colCellDateAwal) {
                        $cells->setValue('=SUM(E'.$idxValue.':'.$colCellDateAwal.$idxValue.')');
                    });
                    $idxValue++;
                    // lama
                    $sheet->cells($colCellTotal.$idxValue, function($cells) use ($idxValue, $colCellDateAwal) {
                        $cells->setValue('=SUM(E'.$idxValue.':'.$colCellDateAwal.$idxValue.')');
                    });
                    $idxValue++;
                    // jumlah
                    $sheet->cells($colCellTotal.$idxValue, function($cells) use ($idxValue, $colCellDateAwal) {
                        $cells->setValue('=SUM(E'.$idxValue.':'.$colCellDateAwal.$idxValue.')');
                    });
                    $idxValue++;
                    $no++;
                }
            });
            
            
        })->download('xls');
    }

    static function getStatistikObyekWisata($wisataId, $jenisLaporan="tahunan", $waktu="2019-08-31"){

        $model = \App\WisataKunjungan::whereHas('wisata', function ($query){
            $query->where('tipe_wisata', 'obyek');
        })->where('wisata_id', $wisataId);

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
            'nusantara' => [],
            'mancanegara' => []
        ];

        if($jenisLaporan=='tahunan'){
            for($i=0; $i<12; $i++){
                array_push($data['nusantara'], 0);
                array_push($data['mancanegara'], 0);
            }
            foreach($hasil as $mdl){
                $bulan = Carbon::parse($mdl->tanggal)->format('m');
                
                $data[$mdl->tipe_kunjungan][$bulan-1] += (int) $mdl->jumlah_wisatawan;
            }
        }elseif($jenisLaporan=='bulanan'){
            $a_date = $waktuTahun."-".$waktuBulan."-01";
            for($i=0; $i<date('t', strtotime($a_date)); $i++){
                array_push($data['nusantara'], 0);
                array_push($data['mancanegara'], 0);
            }

            foreach($hasil as $mdl){
                $day = Carbon::parse($mdl->tanggal)->format('d');
                
                $data[$mdl->tipe_kunjungan][$day-1] += (int) $mdl->jumlah_wisatawan;
            }
        }elseif($jenisLaporan=='mingguan'){
            // Week1 = 1st to 5th
            // Week2 = 6th to 12th
            // Week3 = 13th to 19th
            // Week4 = 20th to 26th
            // Week5 = 27th to 30th

            $firstDate = $waktuTahun."-".$waktuBulan."-01";
            $lastDate = date('Y-m-t', strtotime($firstDate));
            $weekNumber = ObyekWisata::weekOfMonth($lastDate);

            for($i=0; $i<$weekNumber; $i++){
                array_push($data['nusantara'], 0);
                array_push($data['mancanegara'], 0);
            }

            foreach($hasil as $mdl){
                $datena = Carbon::parse($mdl->tanggal)->format('Y-m-d');
                $weekNumber = ObyekWisata::weekOfMonth($datena);
                
                $data[$mdl->tipe_kunjungan][$weekNumber-1] += (int) $mdl->jumlah_wisatawan;
            }
        }elseif($jenisLaporan=='harian'){
            array_push($data['nusantara'], 0);
            array_push($data['mancanegara'], 0);

            foreach($hasil as $mdl){
                $data[$mdl->tipe_kunjungan][0] += (int) $mdl->jumlah_wisatawan;
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