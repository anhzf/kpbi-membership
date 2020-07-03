@extends('dashboard')

@section('page')

@php
    $banPT = ['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik', 'Belum Terakreditasi'];
@endphp

<div class="col-span-2 p-16 pt-5 relative">
    <form action="{{ route('profile:update') }}" method="POST">
        @csrf

        {{-- <x-input.select name="jenjang" label="Jenjang" :choices="['S1', 'S2', 'S3']" value="{{ $data->jenjang ?? old('') }}">jenjang</x-input.select> --}}
        @include('components.input.select', ['name' => 'jenjang', 'label' => 'Jenjang', 'choices' => ['S1', 'S2', 'S3'], 'value' => $data->jenjang ?? old('jenjang')])
        <x-input.text name="nama_prodi" label="Nama Prodi" value="{{ $data->nama_prodi ?? old('nama_prodi') }}"></x-input.text>
        <x-input.text name="jurusan" label="Jurusan" value="{{ $data->jurusan ?? old('jurusan') }}"></x-input.text>
        <x-input.text name="fakultas" label="Fakultas" value="{{ $data->fakultas ?? old('fakultas') }}"></x-input.text>
        <div class="group-input">
            <x-input.text name="pt[lengkap]" label="Nama PT Lengkap" placeholder="Nama PT Lengkap" class="w-2/4" value="{{ $data->pt['lengkap'] ?? old('pt.lengkap') }}"></x-input.text>
            <x-input.text name="pt[singkat]" label="Singkat" placeholder="(misal UNS)" class="w-1/4" value="{{ $data->pt['singkat'] ?? old('pt.singkat') }}"></x-input.text>
        </div>
        {{-- <x-input.select name="status" label="Status Perguruan Tinggi" :choices="['Negeri', 'Swasta']" value="{{ $data->status ?? old('') }}">status</x-input.select> --}}
        @include('components.input.select', ['name' => 'status', 'label' => 'Status Perguruan Tinggi', 'choices' => ['Negeri', 'Swasta'], 'value' => $data->status ?? old('status')])
        <div class="group-input">
            {{-- <x-input.select name="akreditasi_prodi[akreditasi]" label="Akreditasi Prodi" :choices="$banPT" class="w-2/4" value="{{ $data->akreditasi_prodi['akreditasi'] ?? old('') }}">akreditasi_prodi</x-input.select> --}}
            @include('components.input.select', ['name' => 'akreditasi_prodi[akreditasi]', 'label' => 'Akreditasi Prodi', 'choices' => $banPT, 'value' => $data->akreditasi_prodi['akreditasi'] ?? old('akreditasi_prodi.akreditasi')])
            <x-input.text name="akreditasi_prodi[tanggal]" type="date" label="Tanggal Akreditasi" placeholder="Tanggal Akreditasi" class="w-2/4" value="{{ $data->akreditasi_prodi['tanggal'] ?? old('akreditasi_prodi.tanggal') }}"></x-input.text>
            <x-input.text name="akreditasi_prodi[internasional]" label="Akreditasi Internasional" placeholder="Akreditasi Internasional Prodi" class="w-full" value="{{ $data->akreditasi_prodi['internasional'] ?? old('akreditasi_prodi.internasional') }}"></x-input.text>
        </div>
        {{-- <x-input.select name="akreditasi_pt" label="Akreditasi Perguruan Tinggi" :choices="$banPT" value="{{ $data->akreditasi_pt ?? old('') }}">akreditasi_pt</x-input.select> --}}
        @include('components.input.select', ['name' => 'akreditasi_pt', 'label' => 'Akreditasi Perguruan Tinggi', 'choices' => $banPT, 'value' => $data->akreditasi_pt ?? old('akreditasi_pt')])
        <x-input.text name="web_prodi" type="url" label="Alamat Web Prodi" placeholder="Alamat Web Prodi" value="{{ $data->web_prodi ?? old('web_prodi') }}"></x-input.text>
        <div class="group-input">
            <x-input.text name="alamat_kampus[alamat]" label="Alamat Kampus" placeholder="Alamat Kampus" class="w-full" value="{{ $data->alamat_kampus['alamat'] ?? old('alamat_kampus.alamat') }}"></x-input.text>
            <x-input.text name="alamat_kampus[kota]" label="Kota/Kabupaten" placeholder="Kota/Kabupaten" class="w-1/3" value="{{ $data->alamat_kampus['kota'] ?? old('alamat_kampus.kota') }}"></x-input.text>
            <x-input.text name="alamat_kampus[provinsi]" label="Provinsi" placeholder="Provinsi" class="w-1/3" value="{{ $data->alamat_kampus['provinsi'] ?? old('alamat_kampus.provinsi') }}"></x-input.text>
        </div>
        <div class="group-input">
            <x-input.text name="kaprodi[nama]" label="Nama Lengkap dan Gelar Kaprodi" placeholder="Nama Lengkap dan Gelar Kaprodi" class="w-full" value="{{ $data->kaprodi['nama'] ?? old('kaprodi.nama') }}"></x-input.text>
            <x-input.text name="kaprodi[periode][mulai]" label="Periode Jabatan Kaprodi" placeholder="(tahun mulai)" class="w-2/4" value="{{ $data->kaprodi['periode']['mulai'] ?? old('kaprodi.periode.mulai') }}"></x-input.text>
            <x-input.text name="kaprodi[periode][purna]" label="Purna" placeholder="(tahun purna)" class="w-1/4" value="{{ $data->kaprodi['periode']['purna'] ?? old('kaprodi.periode.purna') }}"></x-input.text>
            <x-input.text name="kaprodi[email]" type="email" label="Email Kaprodi" placeholder="Email Kaprodi" class="w-full" value="{{ $data->kaprodi['email'] ?? old('kaprodi.email') }}"></x-input.text>
            <x-input.text name="kaprodi[no]" type="tel" label="Nomor HP Kaprodi" placeholder="Nomor HP Kaprodi" class="w-full" value="{{ $data->kaprodi['no'] ?? old('kaprodi.no') }}"></x-input.text>
        </div>
        
        <x-input.text name="email_prodi" type="email" label="Email Prodi" placeholder="Alamat email Prodi" value="{{ $data->email_prodi ?? old('email_prodi') }}"></x-input.text>
        <x-input.text name="no_telp_prodi" type="tel" label="Nomor Telpon Kantor" placeholder="Nomor Telpon Kantor" value="{{ $data->no_telp_prodi ?? old('no_telp_prodi') }}"></x-input.text>

        <div class="input-action-container flex justify-end px-10 w-full">
            <button type="submit" class="mx-3 md:mt-3 btn">Simpan</button>
        </div>

    </form>
</div>

<img class="rounded-full bg-gray-200 max-w-4/5 mx-auto" style="width: 25vh; height: 25vh;" src="" alt="">

@endsection