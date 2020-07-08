<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KPBI extends Model
{
    protected $table = 'kpbi_member';

    const FIRST_ATTEMPT = 10;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'pt' => 'array',
        'akreditasi_prodi' => 'array',
        'alamat_kampus' => 'array',
        'kaprodi' => 'array',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function account()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Edit Info KPBI / tambahkan Info
     *
     * Untuk menambah atau mengedit info
     * 
     * @param Array $data data untuk disimpan 
     * @param Int $option opsi 
     * @param KPBI $KPBI_info 
     **/
    public static function save_info(array $data, int $option = 0)
    {
        KPBI::requiredDataValidator($data, $option)->validate();

        $profile_template = [
            // 'user_id' => Auth::user()->id,
            'jenjang' => '',
            'nama_prodi' => '',
            'jurusan' => '',
            'fakultas' => '',
            'pt' => [
                'lengkap' => '',
                'singkat' => '',
            ],
            'status' => '',
            'akreditasi_prodi' => [
                'akreditasi' => '',
                'tanggal' => '',
                'internasional' => '',
            ],
            'akreditasi_pt' => '',
            'web_prodi' => '',
            'alamat_kampus' => [
                'alamat' => '',
                'kota' => '',
                'provinsi' => '',
            ],
            'kaprodi' => [
                'nama' => '',
                'periode' => [
                    'mulai' => '',
                    'purna' => ''
                ],
                'email' => '',
                'no' => '',
            ],
            'email_prodi' => '',
            'no_telp_prodi' => '',
        ];

        if (isset($data['name'])) unset($data['name']);
        if (isset($data['email'])) unset($data['email']);
        if (isset($data['password'])) unset($data['password']);
        if (isset($data['password_confirmation'])) unset($data['password_confirmation']);

        return KPBI::updateOrCreate(
            ['user_id' => Auth::user()->id ?? $data['user_id']],
            $data + $profile_template
        );
    }

    public static function requiredDataValidator(array $data, int $option = 0)
    {
        $detailedData = [
            'validator' => [
                'jurusan'                           => [],
                'fakultas'                          => ['required'],
                'akreditasi_prodi.akreditasi'       => ['required'],
                'akreditasi_prodi.tanggal'          => ['required'],
                'akreditasi_prodi.internasional'    => [],
                'akreditasi_pt'                     => ['required'],
                'status'                            => ['required'],
                'web_prodi'                         => ['required'],
                'alamat_kampus.alamat'              => ['required'],
                'alamat_kampus.kota'                => ['required'],
                'alamat_kampus.provinsi'            => ['required'],
                'kaprodi.nama'                      => ['required'],
                'kaprodi.periode.mulai'             => ['required'],
                'kaprodi.periode.purna'             => ['required'],
                'kaprodi.no'                        => ['required'],
                'no_telp_prodi'                     => ['required'],
            ],
            'messages' => [],
            'custom-attributes' => [
                'jurusan'                           => __('Jurusan'),
                'fakultas'                          => __('Fakultas'),
                'akreditasi_prodi.akreditasi'       => __('Akreditasi Prodi'),
                'akreditasi_prodi.tanggal'          => __('Tanggal Akreditasi'),
                'akreditasi_prodi.internasional'    => __('Akreditasi Internasional Prod'),
                'akreditasi_pt'                     => __('Akreditasi Perguruan Tinggi'),
                'web_prodi'                         => __('Alamat Web Prodi'),
                'alamat_kampus.alamat'              => __('Alamat Kampus'),
                'alamat_kampus.kota'                => __('Kota/Kabupaten Kampus'),
                'alamat_kampus.provinsi'            => __('Provinsi Kampus'),
                'kaprodi.nama'                      => __('Nama Kaprodi'),
                'kaprodi.periode.mulai'             => __('Tahun mulai periode Kaprodi'),
                'kaprodi.periode.purna'             => __('Tahun purna periode Kaprodi'),
                'kaprodi.no'                        => __('No telpon/HP Kaprodi'),
                'no_telp_prodi'                     => __('No Telpon Kantor Prodi'),
            ],
        ];

        $registerRequire = [
            'validator' => [
                'jenjang'       => ['required'],
                'nama_prodi'    => ['required'],
                'pt.lengkap'    => ['required'],
                'pt.singkat'    => ['required'],
                'email_prodi'   => ['required', 'email'],
                'kaprodi.email' => ['required', 'email'],
                'username'      => ['exists:App\User,name'],
                'email'         => ['exists:App\User,email'],
            ],
            'messages' => [
                'email' => [
                    'exist' => ':attribute belum didaftarkan menjadi akun prodi',
                ],
            ],
            'custom-attributes' => [
                'jenjang'       => __('Jenjang Prodi'),
                'nama_prodi'    => __('Nama Prodi'),
                'pt.lengkap'    => __('Nama Lengkap Perguruan Tinggi'),
                'pt.singkat'    => __('Singkatan Nama Perguruan Tinggi'),
                'email_prodi'   => __('Email Prodi'),
                'kaprodi.email' => __('Email Kaprodi'),
            ],
        ];

        $validator          = ($option === KPBI::FIRST_ATTEMPT) ? $registerRequire['validator'] : $registerRequire['validator'] + $detailedData['validator'];
        $messages           = ($option === KPBI::FIRST_ATTEMPT) ? $registerRequire['messages'] : $registerRequire['messages'] + $detailedData['messages'];
        $customAttributes   = ($option === KPBI::FIRST_ATTEMPT) ? $registerRequire['custom-attributes'] : $registerRequire['custom-attributes'] + $detailedData['custom-attributes'];

        return Validator::make($data, $validator, $messages, $customAttributes);
    }

    /**
     * Generate default Login Credential for KPBI Login from received data
     *
     * @param Array $data Data Received
     * @return String
     **/
    public static function generateLoginCredentials(array $data)
    {
        return [
            'email' => $data['kaprodi']['email'],
            'name' => strtoupper("{$data['jenjang']} PBIO {$data['pt']['singkat']}"),
            'password' => strtolower("{$data['jenjang']}PBIO{$data['pt']['singkat']}"),
        ];
    }

    public static function current_profile()
    {
        return KPBI::where('user_id', Auth::user()->id)->first();
    }
}
