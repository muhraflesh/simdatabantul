<?php


// Dashboard
Breadcrumbs::register('dashboard', function($breadcrumbs){
    $breadcrumbs->push('Dashboard', route('backend::dashboard'), ['icon' => 'fa fa-dashboard']);
});

// Profil
Breadcrumbs::register('profile', function($breadcrumbs){
    $breadcrumbs->push('Profil', route('backend::profile'), ['icon' => 'face']);
});

// Pengelola
Breadcrumbs::register('pengelola', function($breadcrumbs){
    $breadcrumbs->push('Pengelola', route('backend::pengelola'), ['icon' => 'face']);
});

// Home > About
Breadcrumbs::register('about', function($breadcrumbs){
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('About', route('backend::about'));
});

// Master Obyek Wisata
Breadcrumbs::register('list_master_obyek_wisata', function($breadcrumbs){
    $breadcrumbs->push('Master Obyek Wisata', route('backend::master.obyek_wisata.index'));
});

// Master Obyek Wisata > Create
Breadcrumbs::register('create_master_obyek_wisata', function($breadcrumbs){
    $breadcrumbs->parent('list_master_obyek_wisata');
    $breadcrumbs->push('Buat Obyek Wisata', route('backend::master.obyek_wisata.index'));
});

// Master Obyek Wisata > Edit
Breadcrumbs::register('edit_master_obyek_wisata', function($breadcrumbs){
    $breadcrumbs->parent('list_master_obyek_wisata');
    $breadcrumbs->push('Ubah Master Obyek Wisata', route('backend::master.obyek_wisata.index'));
});

// Master Obyek Wisata > Detail
Breadcrumbs::register('detail_master_obyek_wisata', function($breadcrumbs){
    $breadcrumbs->parent('list_master_obyek_wisata');
    $breadcrumbs->push('Detail Master Obyek Wisata', route('backend::master.obyek_wisata.index'));
});

// Master Desa Wisata
Breadcrumbs::register('list_master_desa_wisata', function($breadcrumbs){
    $breadcrumbs->push('Master Desa Wisata', route('backend::master.desa_wisata.index'));
});

// Master Desa Wisata > Create
Breadcrumbs::register('create_master_desa_wisata', function($breadcrumbs){
    $breadcrumbs->parent('list_master_desa_wisata');
    $breadcrumbs->push('Buat Desa Wisata', route('backend::master.desa_wisata.index'));
});

// Master Desa Wisata > Edit
Breadcrumbs::register('edit_master_desa_wisata', function($breadcrumbs){
    $breadcrumbs->parent('list_master_desa_wisata');
    $breadcrumbs->push('Ubah Master Desa Wisata', route('backend::master.desa_wisata.index'));
});

// Master Desa Wisata > Detail
Breadcrumbs::register('detail_master_desa_wisata', function($breadcrumbs){
    $breadcrumbs->parent('list_master_desa_wisata');
    $breadcrumbs->push('Detail Master Desa Wisata', route('backend::master.desa_wisata.index'));
});

// Master Homestay
Breadcrumbs::register('list_master_akomodasi', function($breadcrumbs){
    $breadcrumbs->push('Master Homestay', route('backend::master.akomodasi.index'));
});

// Master Homestay > Create
Breadcrumbs::register('create_master_akomodasi', function($breadcrumbs){
    $breadcrumbs->parent('list_master_akomodasi');
    $breadcrumbs->push('Buat Homestay', route('backend::master.akomodasi.index'));
});

// Master Homestay > Edit
Breadcrumbs::register('edit_master_akomodasi', function($breadcrumbs){
    $breadcrumbs->parent('list_master_akomodasi');
    $breadcrumbs->push('Ubah Master Homestay', route('backend::master.akomodasi.index'));
});

// Master Homestay > Detail
Breadcrumbs::register('detail_master_akomodasi', function($breadcrumbs){
    $breadcrumbs->parent('list_master_akomodasi');
    $breadcrumbs->push('Detail Master Homestay', route('backend::master.akomodasi.index'));
});

// Master Hotel
Breadcrumbs::register('list_master_hotel', function($breadcrumbs){
    $breadcrumbs->push('Master Hotel', route('backend::master.hotel.index'));
});

// Master Hotel > Create
Breadcrumbs::register('create_master_hotel', function($breadcrumbs){
    $breadcrumbs->parent('list_master_hotel');
    $breadcrumbs->push('Buat Hotel', route('backend::master.hotel.index'));
});

// Master Hotel > Edit
Breadcrumbs::register('edit_master_hotel', function($breadcrumbs){
    $breadcrumbs->parent('list_master_hotel');
    $breadcrumbs->push('Ubah Master Hotel', route('backend::master.hotel.index'));
});

// Master Hotel > Detail
Breadcrumbs::register('detail_master_hotel', function($breadcrumbs){
    $breadcrumbs->parent('list_master_hotel');
    $breadcrumbs->push('Detail Master Hotel', route('backend::master.hotel.index'));
});

// Master Jenis Kamar
Breadcrumbs::register('list_master_jenis_kamar', function($breadcrumbs){
    $breadcrumbs->push('Master Jenis Kamar', route('backend::master.jenis_kamar.index'));
});

// Master Jenis Kamar > Create
Breadcrumbs::register('create_master_jenis_kamar', function($breadcrumbs){
    $breadcrumbs->parent('list_master_jenis_kamar');
    $breadcrumbs->push('Buat Jenis Kamar', route('backend::master.jenis_kamar.index'));
});

// Master Jenis Kamar > Edit
Breadcrumbs::register('edit_master_jenis_kamar', function($breadcrumbs){
    $breadcrumbs->parent('list_master_jenis_kamar');
    $breadcrumbs->push('Ubah Master Jenis Kamar', route('backend::master.jenis_kamar.index'));
});

// Master Jenis Kamar > Detail
Breadcrumbs::register('detail_master_jenis_kamar', function($breadcrumbs){
    $breadcrumbs->parent('list_master_jenis_kamar');
    $breadcrumbs->push('Detail Master Jenis Kamar', route('backend::master.jenis_kamar.index'));
});

// Pengelola Desa Wisata
Breadcrumbs::register('list_pengelola_desa_wisata', function($breadcrumbs){
    $breadcrumbs->push('Pengelola Desa Wisata', route('backend::pengelola.desa_wisata.index'));
});

// Pengelola Desa Wisata > Create
Breadcrumbs::register('create_pengelola_desa_wisata', function($breadcrumbs){
    $breadcrumbs->parent('list_pengelola_desa_wisata');
    $breadcrumbs->push('Buat Desa Wisata', route('backend::pengelola.desa_wisata.index'));
});

// Pengelola Desa Wisata > Edit
Breadcrumbs::register('edit_pengelola_desa_wisata', function($breadcrumbs){
    $breadcrumbs->parent('list_pengelola_desa_wisata');
    $breadcrumbs->push('Ubah Pengelola Desa Wisata', route('backend::pengelola.desa_wisata.index'));
});

// Pengelola Desa Wisata > Detail
Breadcrumbs::register('detail_pengelola_desa_wisata', function($breadcrumbs){
    $breadcrumbs->parent('list_pengelola_desa_wisata');
    $breadcrumbs->push('Detail Pengelola Desa Wisata', route('backend::pengelola.desa_wisata.index'));
});

// Pengelola Obyek Wisata
Breadcrumbs::register('list_pengelola_obyek_wisata', function($breadcrumbs){
    $breadcrumbs->push('Pengelola Obyek Wisata', route('backend::pengelola.obyek_wisata.index'));
});

// Pengelola Obyek Wisata > Create
Breadcrumbs::register('create_pengelola_obyek_wisata', function($breadcrumbs){
    $breadcrumbs->parent('list_pengelola_obyek_wisata');
    $breadcrumbs->push('Buat Obyek Wisata', route('backend::pengelola.obyek_wisata.index'));
});

// Pengelola Obyek Wisata > Edit
Breadcrumbs::register('edit_pengelola_obyek_wisata', function($breadcrumbs){
    $breadcrumbs->parent('list_pengelola_obyek_wisata');
    $breadcrumbs->push('Ubah Pengelola Obyek Wisata', route('backend::pengelola.obyek_wisata.index'));
});

// Pengelola Obyek Wisata > Detail
Breadcrumbs::register('detail_pengelola_obyek_wisata', function($breadcrumbs){
    $breadcrumbs->parent('list_pengelola_obyek_wisata');
    $breadcrumbs->push('Detail Pengelola Obyek Wisata', route('backend::pengelola.obyek_wisata.index'));
});

// Kunjungan Desa Wisata Mancanegara
Breadcrumbs::register('list_kunjungan_desa_wisata_mancanegara', function($breadcrumbs){
    $breadcrumbs->push('Kunjungan Desa Wisata Mancanegara', route('backend::kunjungan.desa_wisata.index', ['tipe' => 'mancanegara']));
});

// Kunjungan Desa Wisata Mancanegara > Create
Breadcrumbs::register('create_kunjungan_desa_wisata_mancanegara', function($breadcrumbs){
    $breadcrumbs->parent('list_kunjungan_desa_wisata_mancanegara');
    $breadcrumbs->push('Buat', route('backend::kunjungan.desa_wisata.index', ['tipe' => 'mancanegara']));
});

// Kunjungan Desa Wisata Mancanegara > Edit
Breadcrumbs::register('edit_kunjungan_desa_wisata_mancanegara', function($breadcrumbs){
    $breadcrumbs->parent('list_kunjungan_desa_wisata_mancanegara');
    $breadcrumbs->push('Ubah', route('backend::kunjungan.desa_wisata.index', ['tipe' => 'mancanegara']));
});

// Kunjungan Desa Wisata Mancanegara > Detail
Breadcrumbs::register('detail_kunjungan_desa_wisata_mancanegara', function($breadcrumbs){
    $breadcrumbs->parent('list_kunjungan_desa_wisata_mancanegara');
    $breadcrumbs->push('Detail', route('backend::kunjungan.desa_wisata.index', ['tipe' => 'mancanegara']));
});

// Kunjungan Desa Wisata Nusantara
Breadcrumbs::register('list_kunjungan_desa_wisata_nusantara', function($breadcrumbs){
    $breadcrumbs->push('Kunjungan Desa Wisata Nusantara', route('backend::kunjungan.desa_wisata.index', ['tipe' => 'nusantara']));
});

// Kunjungan Desa Wisata Nusantara > Create
Breadcrumbs::register('create_kunjungan_desa_wisata_nusantara', function($breadcrumbs){
    $breadcrumbs->parent('list_kunjungan_desa_wisata_nusantara');
    $breadcrumbs->push('Buat', route('backend::kunjungan.desa_wisata.index', ['tipe' => 'nusantara']));
});

// Kunjungan Desa Wisata Nusantara > Edit
Breadcrumbs::register('edit_kunjungan_desa_wisata_nusantara', function($breadcrumbs){
    $breadcrumbs->parent('list_kunjungan_desa_wisata_nusantara');
    $breadcrumbs->push('Ubah', route('backend::kunjungan.desa_wisata.index', ['tipe' => 'nusantara']));
});

// Kunjungan Desa Wisata Nusantara > Detail
Breadcrumbs::register('detail_kunjungan_desa_wisata_nusantara', function($breadcrumbs){
    $breadcrumbs->parent('list_kunjungan_desa_wisata_nusantara');
    $breadcrumbs->push('Detail', route('backend::kunjungan.desa_wisata.index', ['tipe' => 'nusantara']));
});

// Kunjungan Obyek Wisata Mancanegara
Breadcrumbs::register('list_kunjungan_obyek_wisata_mancanegara', function($breadcrumbs){
    $breadcrumbs->push('Kunjungan Obyek Wisata Mancanegara', route('backend::kunjungan.obyek_wisata.index', ['tipe' => 'mancanegara']));
});

// Kunjungan Obyek Wisata Mancanegara > Create
Breadcrumbs::register('create_kunjungan_obyek_wisata_mancanegara', function($breadcrumbs){
    $breadcrumbs->parent('list_kunjungan_obyek_wisata_mancanegara');
    $breadcrumbs->push('Buat', route('backend::kunjungan.obyek_wisata.index', ['tipe' => 'mancanegara']));
});

// Kunjungan Obyek Wisata Mancanegara > Edit
Breadcrumbs::register('edit_kunjungan_obyek_wisata_mancanegara', function($breadcrumbs){
    $breadcrumbs->parent('list_kunjungan_obyek_wisata_mancanegara');
    $breadcrumbs->push('Ubah', route('backend::kunjungan.obyek_wisata.index', ['tipe' => 'mancanegara']));
});

// Kunjungan Obyek Wisata Mancanegara > Detail
Breadcrumbs::register('detail_kunjungan_obyek_wisata_mancanegara', function($breadcrumbs){
    $breadcrumbs->parent('list_kunjungan_obyek_wisata_mancanegara');
    $breadcrumbs->push('Detail', route('backend::kunjungan.obyek_wisata.index', ['tipe' => 'mancanegara']));
});

// Kunjungan Obyek Wisata Nusantara
Breadcrumbs::register('list_kunjungan_obyek_wisata_nusantara', function($breadcrumbs){
    $breadcrumbs->push('Kunjungan Obyek Wisata Nusantara', route('backend::kunjungan.obyek_wisata.index', ['tipe' => 'nusantara']));
});

// Kunjungan Obyek Wisata Nusantara > Create
Breadcrumbs::register('create_kunjungan_obyek_wisata_nusantara', function($breadcrumbs){
    $breadcrumbs->parent('list_kunjungan_obyek_wisata_nusantara');
    $breadcrumbs->push('Buat', route('backend::kunjungan.obyek_wisata.index', ['tipe' => 'nusantara']));
});

// Kunjungan Obyek Wisata Nusantara > Edit
Breadcrumbs::register('edit_kunjungan_obyek_wisata_nusantara', function($breadcrumbs){
    $breadcrumbs->parent('list_kunjungan_obyek_wisata_nusantara');
    $breadcrumbs->push('Ubah', route('backend::kunjungan.obyek_wisata.index', ['tipe' => 'nusantara']));
});

// Kunjungan Obyek Wisata Nusantara > Detail
Breadcrumbs::register('detail_kunjungan_obyek_wisata_nusantara', function($breadcrumbs){
    $breadcrumbs->parent('list_kunjungan_obyek_wisata_nusantara');
    $breadcrumbs->push('Detail', route('backend::kunjungan.obyek_wisata.index', ['tipe' => 'nusantara']));
});

// Menginap/Penginapan Mancanegara
Breadcrumbs::register('list_akomodasi_mancanegara', function($breadcrumbs){
    $breadcrumbs->push('Penginapan Mancanegara', route('backend::menginap.index', ['tipe' => 'mancanegara']));
});

// Menginap/Penginapan Mancanegara > Create
Breadcrumbs::register('create_akomodasi_mancanegara', function($breadcrumbs){
    $breadcrumbs->parent('list_akomodasi_mancanegara');
    $breadcrumbs->push('Buat', route('backend::menginap.index', ['tipe' => 'mancanegara']));
});

// Menginap/Penginapan Mancanegara > Edit
Breadcrumbs::register('edit_akomodasi_mancanegara', function($breadcrumbs){
    $breadcrumbs->parent('list_akomodasi_mancanegara');
    $breadcrumbs->push('Ubah', route('backend::menginap.index', ['tipe' => 'mancanegara']));
});

// Menginap/Penginapan Mancanegara > Detail
Breadcrumbs::register('detail_akomodasi_mancanegara', function($breadcrumbs){
    $breadcrumbs->parent('list_akomodasi_mancanegara');
    $breadcrumbs->push('Detail', route('backend::menginap.index', ['tipe' => 'mancanegara']));
});

// Menginap/Penginapan Nusantara
Breadcrumbs::register('list_akomodasi_nusantara', function($breadcrumbs){
    $breadcrumbs->push('Penginapan Nusantara', route('backend::menginap.index', ['tipe' => 'nusantara']));
});

// Menginap/Penginapan Nusantara > Create
Breadcrumbs::register('create_akomodasi_nusantara', function($breadcrumbs){
    $breadcrumbs->parent('list_akomodasi_nusantara');
    $breadcrumbs->push('Buat', route('backend::menginap.index', ['tipe' => 'nusantara']));
});

// Menginap/Penginapan Nusantara > Edit
Breadcrumbs::register('edit_akomodasi_nusantara', function($breadcrumbs){
    $breadcrumbs->parent('list_akomodasi_nusantara');
    $breadcrumbs->push('Ubah', route('backend::menginap.index', ['tipe' => 'nusantara']));
});

// Menginap/Penginapan Nusantara > Detail
Breadcrumbs::register('detail_akomodasi_nusantara', function($breadcrumbs){
    $breadcrumbs->parent('list_akomodasi_nusantara');
    $breadcrumbs->push('Detail', route('backend::menginap.index', ['tipe' => 'nusantara']));
});

// Belanja Wisatawan Mancanegara
Breadcrumbs::register('list_belanja_mancanegara', function($breadcrumbs){
    $breadcrumbs->push('Belanja Wisatawan Mancanegara', route('backend::belanja.index', ['tipe' => 'mancanegara']));
});

// Belanja Wisatawan Mancanegara > Create
Breadcrumbs::register('create_belanja_mancanegara', function($breadcrumbs){
    $breadcrumbs->parent('list_belanja_mancanegara');
    $breadcrumbs->push('Buat', route('backend::belanja.index', ['tipe' => 'mancanegara']));
});

// Belanja Wisatawan Mancanegara > Edit
Breadcrumbs::register('edit_belanja_mancanegara', function($breadcrumbs){
    $breadcrumbs->parent('list_belanja_mancanegara');
    $breadcrumbs->push('Ubah', route('backend::belanja.index', ['tipe' => 'mancanegara']));
});

// Belanja Wisatawan Mancanegara > Detail
Breadcrumbs::register('detail_belanja_mancanegara', function($breadcrumbs){
    $breadcrumbs->parent('list_belanja_mancanegara');
    $breadcrumbs->push('Detail', route('backend::belanja.index', ['tipe' => 'mancanegara']));
});

// Belanja Wisatawan Nusantara
Breadcrumbs::register('list_belanja_nusantara', function($breadcrumbs){
    $breadcrumbs->push('Belanja Wisatawan Nusantara', route('backend::belanja.index', ['tipe' => 'nusantara']));
});

// Belanja Wisatawan Nusantara > Create
Breadcrumbs::register('create_belanja_nusantara', function($breadcrumbs){
    $breadcrumbs->parent('list_belanja_nusantara');
    $breadcrumbs->push('Buat', route('backend::belanja.index', ['tipe' => 'nusantara']));
});

// Belanja Wisatawan Nusantara > Edit
Breadcrumbs::register('edit_belanja_nusantara', function($breadcrumbs){
    $breadcrumbs->parent('list_belanja_nusantara');
    $breadcrumbs->push('Ubah', route('backend::belanja.index', ['tipe' => 'nusantara']));
});

// Belanja Wisatawan Nusantara > Detail
Breadcrumbs::register('detail_belanja_nusantara', function($breadcrumbs){
    $breadcrumbs->parent('list_belanja_nusantara');
    $breadcrumbs->push('Detail', route('backend::belanja.index', ['tipe' => 'nusantara']));
});

// Fasilitas Umum
Breadcrumbs::register('list_fasilitas_umum', function($breadcrumbs){
    $breadcrumbs->push('Fasilitas Umum', route('backend::fasilitas_umum.index'));
});

// Fasilitas Umum > Create
Breadcrumbs::register('create_fasilitas_umum', function($breadcrumbs){
    $breadcrumbs->parent('list_fasilitas_umum');
    $breadcrumbs->push('Buat Fasilitas Umum', route('backend::fasilitas_umum.index'));
});

// Fasilitas Umum > Edit
Breadcrumbs::register('edit_fasilitas_umum', function($breadcrumbs){
    $breadcrumbs->parent('list_fasilitas_umum');
    $breadcrumbs->push('Ubah Fasilitas Umum', route('backend::fasilitas_umum.index'));
});

// Fasilitas Umum > Detail
Breadcrumbs::register('detail_fasilitas_umum', function($breadcrumbs){
    $breadcrumbs->parent('list_fasilitas_umum');
    $breadcrumbs->push('Detail Fasilitas Umum', route('backend::fasilitas_umum.index'));
});

// Paket Wisata
Breadcrumbs::register('list_wisata_paket', function($breadcrumbs){
    $breadcrumbs->push('Paket Wisata', route('backend::wisata_paket.index'));
});

// Paket Wisata > Create
Breadcrumbs::register('create_wisata_paket', function($breadcrumbs){
    $breadcrumbs->parent('list_wisata_paket');
    $breadcrumbs->push('Buat Paket Wisata', route('backend::wisata_paket.index'));
});

// Paket Wisata > Edit
Breadcrumbs::register('edit_wisata_paket', function($breadcrumbs){
    $breadcrumbs->parent('list_wisata_paket');
    $breadcrumbs->push('Ubah Paket Wisata', route('backend::wisata_paket.index'));
});

// Paket Wisata > Detail
Breadcrumbs::register('detail_wisata_paket', function($breadcrumbs){
    $breadcrumbs->parent('list_wisata_paket');
    $breadcrumbs->push('Detail Paket Wisata', route('backend::wisata_paket.index'));
});

// Pengguna
Breadcrumbs::register('list_pengguna', function($breadcrumbs){
    $breadcrumbs->push('Pengguna', route('backend::pengguna.index'));
});

// Pengguna > Create
Breadcrumbs::register('create_pengguna', function($breadcrumbs){
    $breadcrumbs->parent('list_pengguna');
    $breadcrumbs->push('Buat Pengguna', route('backend::pengguna.index'));
});

// Pengguna > Edit
Breadcrumbs::register('edit_pengguna', function($breadcrumbs){
    $breadcrumbs->parent('list_pengguna');
    $breadcrumbs->push('Ubah Pengguna', route('backend::pengguna.index'));
});

// Pengguna > Detail
Breadcrumbs::register('detail_pengguna', function($breadcrumbs){
    $breadcrumbs->parent('list_pengguna');
    $breadcrumbs->push('Detail Pengguna', route('backend::pengguna.index'));
});

// Laporan
Breadcrumbs::register('list_laporan', function($breadcrumbs){
    $breadcrumbs->push('Laporan', route('backend::laporan.desa'));
});

// Approval
Breadcrumbs::register('list_approval', function($breadcrumbs){
    $breadcrumbs->push('Persetujuan Registrasi Destinasi', route('backend::approval.index'));
});

// Approval > Edit
Breadcrumbs::register('edit_approval', function($breadcrumbs){
    $breadcrumbs->parent('list_approval');
    $breadcrumbs->push('Update Approval', route('backend::approval.index'));
});

// Approval > Detail
Breadcrumbs::register('detail_approval', function($breadcrumbs){
    $breadcrumbs->parent('list_approval');
    $breadcrumbs->push('Detail Approval', route('backend::approval.index'));
});