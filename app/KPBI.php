<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KPBI extends Model
{
    protected $table = 'kpbi_member';


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

    /**
     * Edit Info KPBI / tambahkan Info
     *
     * Untuk menambah atau mengedit info
     * 
     * @param Array $data data untuk disimpan 
     * @param KPBI $KPBI_info 
     **/
    public static function save_info(Array $data)
    {
        KPBI::requiredDataValidator($data)->validate();

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

        if(isset($data['username'])) unset($data['username']);
        if(isset($data['email'])) unset($data['email']);
        if(isset($data['password'])) unset($data['password']);
        if(isset($data['password_confirmation'])) unset($data['password_confirmation']);

        return KPBI::updateOrCreate(
            ['user_id' => Auth::user()->id ?? $data['user_id']],
            $data + $profile_template
        );
    }

    public static function requiredDataValidator(Array $data)
    {
        return Validator::make($data, [
            'jenjang' => ['required'],
            'nama_prodi' => ['required'],
            'pt.lengkap' => ['required'],
            'pt.singkat' => ['required'],
            'email_prodi' => ['required', 'email'],
            'kaprodi.email' => ['required', 'email'],
            'username' => ['exists:App\User,name'],
            'email' => ['exists:App\User,email'],
        ], [
            'email' => [
                'exist' => ':attribute belum didaftarkan menjadi akun prodi',
            ]
        ], [
            'jenjang' => 'Jenjang Prodi',
            'nama_prodi' => 'Nama Prodi',
            'pt.lengkap' => 'Nama Lengkap Perguruan Tinggi',
            'pt.singkat' => 'Singkatan Nama Perguruan Tinggi',
            'email_prodi' => 'Email Prodi',
            'kaprodi.email' => 'Email Kaprodi',
        ]);
    }

    /**
     * Generate default Login Credential for KPBI Login from received data
     *
     * @param Array $data Data Received
     * @return String
     **/
    public static function generateLoginCredentials(Array $data)
    {
        return [
            'email' => $data['kaprodi']['email'],
            'username' => strtoupper("{$data['jenjang']} PBIO {$data['pt']['singkat']}"),
            'password' => strtolower("{$data['jenjang']}PBIO{$data['pt']['singkat']}"),
        ];
    }

    public static function current_profile()
    {
        return KPBI::where('user_id', Auth::user()->id)->first();
    }
}
