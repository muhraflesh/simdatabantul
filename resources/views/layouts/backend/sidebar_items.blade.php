@php
    $user = Auth::user();

    if($user->hasRole('superadmin')){
        $menus = [
            [
                'icon'  => 'settings_input_svideo',
                'uri'   => route('backend::dashboard'),
                'title' => 'Dashboard'
            ],
            [
                'icon'  => 'check_circle',
                'uri'   => route('backend::approval.index'),
                'title' => 'Approval'
            ],
            [
                'icon'  => 'business_center',
                'uri'   => '#',
                'title' => 'Master',
                'childs' => [
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::master.obyek_wisata.index'),
                        'title' => 'Obyek Wisata'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::master.desa_wisata.index'),
                        'title' => 'Desa Wisata'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::master.akomodasi.index'),
                        'title' => 'Homestay'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::master.hotel.index'),
                        'title' => 'Hotel'
                    ]
                ]
            ],
            [
                'icon'  => 'directions',
                'uri'   => '#',
                'title' => 'Desa Wisata',
                'childs' => [
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::kunjungan.desa_wisata.index', ['tipe' => 'mancanegara']),
                        'title' => 'Wisatawan Mancanegara'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::kunjungan.desa_wisata.index', ['tipe' => 'nusantara']),
                        'title' => 'Wisatawan Nusantara'
                    ]
                ]
            ],
            [
                'icon'  => 'hotel',
                'uri'   => '#',
                'title' => 'Menginap',
                'childs' => [
                    [
                        'icon'  => 'radio_button_checked',
                        'uri'   => '#',
                        'title' => 'Hotel',
                        'childs'=> [
                            [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::menginap_hotel.index', ['tipe' => 'mancanegara']),
                            'title' => 'Wisatawan Mancanegara'
                            ],
                            [
                                'icon'  => 'radio_button_unchecked',
                                'uri'   => route('backend::menginap_hotel.index', ['tipe' => 'nusantara']),
                                'title' => 'Wisatawan Nusantara'
                            ]
                        ]
                    ],
                    [
                        'icon'  => 'radio_button_checked',
                        'uri'   => '#',
                        'title' => 'Homestay',
                        'childs'=> [
                            [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::menginap.index', ['tipe' => 'mancanegara']),
                            'title' => 'Wisatawan Mancanegara'
                            ],
                            [
                                'icon'  => 'radio_button_unchecked',
                                'uri'   => route('backend::menginap.index', ['tipe' => 'nusantara']),
                                'title' => 'Wisatawan Nusantara'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'icon'  => 'shopping_basket',
                'uri'   => '#',
                'title' => 'Belanja Desa Wisata',
                'childs' => [
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::belanja.index', ['tipe' => 'mancanegara']),
                        'title' => 'Wisatawan Mancanegara'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::belanja.index', ['tipe' => 'nusantara']),
                        'title' => 'Wisatawan Nusantara'
                    ]
                ]
            ],
            [
                'icon'  => 'shopping_basket',
                'uri'   => '#',
                'title' => 'Belanja Hotel',
                'childs' => [
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::hotel_belanja.index', ['tipe' => 'mancanegara']),
                        'title' => 'Wisatawan Mancanegara'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::hotel_belanja.index', ['tipe' => 'nusantara']),
                        'title' => 'Wisatawan Nusantara'
                    ]
                ]
            ],
            [
                'icon'  => 'directions',
                'uri'   => '#',
                'title' => 'Obyek Wisata',
                'childs' => [
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::kunjungan.obyek_wisata.index', ['tipe' => 'mancanegara']),
                        'title' => 'Wisatawan Mancanegara'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::kunjungan.obyek_wisata.index', ['tipe' => 'nusantara']),
                        'title' => 'Wisatawan Nusantara'
                    ]
                ]
            ],
            [
                'icon'  => 'insert_drive_file',
                'uri'   => '#',
                'title' => 'Laporan',
                'childs' => [
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::laporan.desa'),
                        'title' => 'Wisatawan Desa Wisata'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::laporan.obyek'),
                        'title' => 'Wisatawan Obyek Wisata'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::laporan.belanja'),
                        'title' => 'Belanja Desa Wisata'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::laporan.hotel_belanja'),
                        'title' => 'Belanja Hotel'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::laporan.homestay'),
                        'title' => 'Homestay'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::laporan.hotel'),
                        'title' => 'Hotel'
                    ]
                ]
            ],
            [
                'icon'  => 'face',
                'uri'   => '#',
                'title' => 'Pengelola Wisata',
                'childs' => [
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::pengelola.desa_wisata.index'),
                        'title' => 'Desa Wisata'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::pengelola.obyek_wisata.index'),
                        'title' => 'Obyek Wisata'
                    ]
                ]
            ],
            [
                'icon'  => 'face',
                'uri'   => route('backend::pengguna.index'),
                'title' => 'Manajemen Pengguna'
            ]
        ];
    }elseif($user->hasRole('operator')){
        if(@$user->pengelola[0]->wisata->tipe_wisata=='desa'){
            $menus = [
                [
                    'icon'  => 'settings_input_svideo',
                    'uri'   => route('backend::dashboard'),
                    'title' => 'Dashboard'
                ],
                [
                    'icon'  => 'face',
                    'uri'   => route('backend::profile'),
                    'title' => 'Profil'
                ],
                [
                    'icon'  => 'face',
                    'uri'   => route('backend::pengelola'),
                    'title' => 'Pengelola'
                ],
                [
                    'icon'  => 'directions',
                    'uri'   => '#',
                    'title' => 'Kunjungan',
                    'childs' => [
                        [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::kunjungan.desa_wisata.index', ['tipe' => 'mancanegara']),
                            'title' => 'Wisatawan Mancanegara'
                        ],
                        [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::kunjungan.desa_wisata.index', ['tipe' => 'nusantara']),
                            'title' => 'Wisatawan Nusantara'
                        ]
                    ]
                ],
                [
                    'icon'  => 'business_center',
                    'uri'   => route('backend::master.akomodasi.index'),
                    'title' => 'Homestay'
                ],
                [
                    'icon'  => 'settings_input_composite',
                    'uri'   => route('backend::fasilitas_umum.index'),
                    'title' => 'Fasilitas Umum'
                ],
                [
                    'icon'  => 'card_travel',
                    'uri'   => route('backend::wisata_paket.index'),
                    'title' => 'Paket Wisata'
                ],
                [
                    'icon'  => 'shopping_basket',
                    'uri'   => '#',
                    'title' => 'Belanja',
                    'childs' => [
                        [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::belanja.index', ['tipe' => 'mancanegara']),
                            'title' => 'Wisatawan Mancanegara'
                        ],
                        [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::belanja.index', ['tipe' => 'nusantara']),
                            'title' => 'Wisatawan Nusantara'
                        ]
                    ]
                ],
                [
                    'icon'  => 'hotel',
                    'uri'   => '#',
                    'title' => 'Menginap',
                    'childs' => [
                        [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::menginap.index', ['tipe' => 'mancanegara']),
                            'title' => 'Wisatawan Mancanegara'
                        ],
                        [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::menginap.index', ['tipe' => 'nusantara']),
                            'title' => 'Wisatawan Nusantara'
                        ]
                    ]
                ],
                [
                    'icon'  => 'insert_drive_file',
                    'uri'   => '#',
                    'title' => 'Laporan',
                    'childs' => [
                        [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::laporan.desa'),
                            'title' => 'Wisatawan'
                        ],
                        [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::laporan.belanja'),
                            'title' => 'Belanja'
                        ],
                        [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::laporan.homestay'),
                            'title' => 'Menginap'
                        ]
                    ]
                ]
            ];
        }
        
        if(@$user->pengelola[0]->wisata->tipe_wisata=='obyek'){
            $menus = [
                [
                    'icon'  => 'settings_input_svideo',
                    'uri'   => route('backend::dashboard'),
                    'title' => 'Dashboard'
                ],
                [
                    'icon'  => 'face',
                    'uri'   => route('backend::profile'),
                    'title' => 'Profil'
                ],
                [
                    'icon'  => 'face',
                    'uri'   => route('backend::pengelola'),
                    'title' => 'Pengelola'
                ],
                [
                    'icon'  => 'directions',
                    'uri'   => '#',
                    'title' => 'Kunjungan',
                    'childs' => [
                        [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::kunjungan.obyek_wisata.index', ['tipe' => 'mancanegara']),
                            'title' => 'Wisatawan Mancanegara'
                        ],
                        [
                            'icon'  => 'radio_button_unchecked',
                            'uri'   => route('backend::kunjungan.obyek_wisata.index', ['tipe' => 'nusantara']),
                            'title' => 'Wisatawan Nusantara'
                        ]
                    ]
                ],
                [
                    'icon'  => 'settings_input_composite',
                    'uri'   => route('backend::fasilitas_umum.index'),
                    'title' => 'Fasilitas Umum'
                ],
                [
                    'icon'  => 'insert_drive_file',
                    'uri'   => route('backend::laporan.obyek'),
                    'title' => 'Laporan Kunjungan'
                ]
            ];
        }
    }elseif($user->hasRole('operator_hotel')){
        $menus = [
            [
                'icon'  => 'settings_input_svideo',
                'uri'   => route('backend::dashboard'),
                'title' => 'Dashboard'
            ],
            [
                'icon'  => 'business_center',
                'uri'   => route('backend::master.jenis_kamar.index'),
                'title' => 'Master Jenis Kamar',
            ],
            [
                'icon'  => 'hotel',
                'uri'   => '#',
                'title' => 'Menginap',
                'childs' =>[
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::menginap_hotel.index', ['tipe' => 'mancanegara']),
                        'title' => 'Wisatawan Mancanegara'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::menginap_hotel.index', ['tipe' => 'nusantara']),
                        'title' => 'Wisatawan Nusantara'
                    ]
                ]
            ],
            [
                'icon'  => 'face',
                'uri'   => route('backend::profile'),
                'title' => 'Profil'
            ],
            [
                'icon'  => 'settings_input_composite',
                'uri'   => route('backend::hotel_fasilitas.index'),
                'title' => 'Fasilitas Umum'
            ],
            [
                'icon'  => 'card_travel',
                'uri'   => route('backend::hotel_paket_wisata.index'),
                'title' => 'Paket Wisata'
            ],
            [
                'icon'  => 'shopping_basket',
                'uri'   => '#',
                'title' => 'Belanja',
                'childs' => [
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::hotel_belanja.index', ['tipe' => 'mancanegara']),
                        'title' => 'Wisatawan Mancanegara'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::hotel_belanja.index', ['tipe' => 'nusantara']),
                        'title' => 'Wisatawan Nusantara'
                    ]
                ]
            ],
            [
                'icon'  => 'insert_drive_file',
                'uri'   => '#',
                'title' => 'Laporan',
                'childs'=> [
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::laporan.hotel_belanja'),
                        'title' => 'Belanja Hotel'
                    ],
                    [
                        'icon'  => 'radio_button_unchecked',
                        'uri'   => route('backend::laporan.hotel'),
                        'title' => 'Menginap Hotel'
                    ]
                ]
            ]
        ];
    }else{
        $menus = [];
    }
@endphp 

@foreach($menus as $menu)
    @if(!empty($menu['childs']))
    @php
    $active = '';
    $styleActive = '';
    foreach($menu['childs'] as $children){
        if(Request::url()==$children['uri']){
            $active = ' active open';
            $styleActive = 'display: block;';
            break;
        }
    }
    @endphp
    <li class="bold{{ $active }}">
        <a class="collapsible-header waves-effect waves-cyan" href="#">
            <i class="material-icons">{{ $menu['icon'] }}</i>
            <span class="menu-title" data-i18n="">{!! $menu['title'] !!}</span>    
        </a>
        <div class="collapsible-body" style="{{ $styleActive }}">
            <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                @foreach($menu['childs'] as $child)
                
                @if(!empty($child['childs']))
                <li class="{{ $active = (Request::url()==$child['uri']) ? 'active' : ''}}">
                    <a class="collapsible-body collapsible-header waves-effect waves-cyan" href="#" data-i18n="">
                        <i class="material-icons">{{ $child['icon'] }}</i>
                        <span>{!! $child['title'] !!}</span>
                    </a>
                    <div class="collapsible-body">
                        <ul class="collapsible" data-collapsible="accordion">
                        @foreach($child['childs'] as $subChild)
                            <li class="{{ $active = (Request::url()==$subChild['uri']) ? 'active' : ''}}">
                                <a class="collapsible-body{{ $active = (Request::url()==$subChild['uri']) ? ' active' : ''}}" href="{{ $subChild['uri'] }}" data-i18n="">
                                    <i class="material-icons">{{ $subChild['icon'] }}</i>
                                    <span>{!! $subChild['title'] !!}</span>
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </li>
                @else
                <li class="bold">
                    <a class="waves-effect waves-cyan {{ $active = (Request::url()==$child['uri']) ? 'active' : ''}}" href="{{ $child['uri'] }}">
                        <i class="material-icons">{{ $child['icon'] }}</i>
                        <span class="menu-title" data-i18n="">
                            {!! $child['title'] !!}
                        </span>
                    </a>
                </li>
                @endif

                @endforeach 
            </ul>
        </div>
    </li>
    @else
    <li class="bold">
        <a class="waves-effect waves-cyan {{ $active = (Request::url()==$menu['uri']) ? 'active' : ''}}" href="{{ $menu['uri'] }}">
            <i class="material-icons">{{ $menu['icon'] }}</i>
            <span class="menu-title" data-i18n="">
                {!! $menu['title'] !!}
            </span>
        </a>
    </li>
    @endif
@endforeach