<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        $profile_template = [
            'user_id' => Auth::user()->id,
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

        return KPBI::updateOrCreate(
            ['user_id' => Auth::user()->id],
            $data + $profile_template
        );
    }

    public static function current_profile()
    {
        return KPBI::where('user_id', Auth::user()->id)->first();
    }
}
