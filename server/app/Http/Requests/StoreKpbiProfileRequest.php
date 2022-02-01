<?php

namespace App\Http\Requests;

use App\Models\AkreditasiPerguruanTinggi;
use App\Models\AkreditasiProdi;
use App\Models\KpbiProfile;
use App\Models\PerguruanTinggi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKpbiProfileRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return array_merge(
      $this->essentialRules(),
      $this->perguruanTinggiRules(),
      $this->akreditasiPerguruanTinggiRules(),
      $this->kaprodiRules(),
      $this->akreditasiProdiRules(),
    );
  }

  protected function essentialRules() {
    return [
      'jenjang' => ['required', Rule::in(KpbiProfile::jenjangValues)],
      'nama_prodi' => 'required|string|max:255',
      'nama_jurusan' => 'nullable|string|max:255',
      'nama_fakultas' => 'nullable|string|max:255',
      'nama_perguruan_tinggi_singkat' => 'required|string|max:255',
      'nama_perguruan_tinggi_lengkap' => 'required|string|max:255',
      'link' => 'nullable|url|max:255',
      'email_kantor_prodi' => 'required|email',
      'notelp_kantor_prodi' => 'nullable|string|max:255',
    ];
  }

  protected function perguruanTinggiRules()
  {
    return [
      'nama_perguruan_tinggi_singkat' => 'required|string|max:255',
      'nama_perguruan_tinggi_lengkap' => 'required|string|max:255',
      'status_perguruan_tinggi' => ['nullable', Rule::in(PerguruanTinggi::statusValues)],
      'kota_perguruan_tinggi' => 'nullable|string|max:255',
      'provinsi_perguruan_tinggi' => 'nullable|string|max:255',
      'alamat_perguruan_tinggi' => 'nullable|string|max:255',
    ];
  }

  protected function akreditasiPerguruanTinggiRules()
  {
    return [
      'tipe_akreditasi_perguruan_tinggi' => 'nullable|string|max:255',
      'peringkat_akreditasi_perguruan_tinggi' => ['nullable', Rule::in(AkreditasiPerguruanTinggi::peringkatValues)],
      'tanggal_aktif_akreditasi_perguruan_tinggi' => 'nullable|date',
      'tanggal_kadaluarsa_akreditasi_perguruan_tinggi' => 'nullable|date',
    ];
  }

  protected function kaprodiRules()
  {
    return [
      'nama_kaprodi' => 'nullable|string|max:255',
      'periode_mulai_kaprodi' => 'nullable|date',
      'periode_purna_kaprodi' => 'nullable|date',
      'email_kaprodi' => 'nullable|email',
      'notelp_kaprodi' => 'nullable|string|max:255',
    ];
  }

  protected function akreditasiProdiRules()
  {
    return [
      'tipe_akreditasi_prodi' => 'nullable|string|max:255',
      'peringkat_akreditasi_prodi' => ['nullable', Rule::in(AkreditasiProdi::peringkatValues)],
      'tanggal_aktif_akreditasi_prodi' => 'nullable|date',
      'tanggal_kadaluarsa_akreditasi_prodi' => 'nullable|date',
    ];
  }
}
