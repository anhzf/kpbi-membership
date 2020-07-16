@extends('layouts.app')

@section('content')
    
<div id="app" class="flex flex-col justify-start items-center w-full h-screen p-10">
    <div class="flex flex-col w-3/4 h-full shadow-2xl">
        <nav class="flex justify-start items-center bg-blue-600 text-white">
            <a href='{{ route('home') }}' class='btn bg-blue-600 hover:bg-blue-700 flex'>
                <img src="{{ asset('img/ICON_KPBI_no-text.png') }}" class="w-12" alt="[icon_kpbi]">
                <span class="my-auto px-3 text-xl">Konsorsium Pendidikan Biologi Indonesia</span>
            </a>
        </nav>
        <main class="justify-center overflow-y-auto h-full bg-white">
            <table class="col-span-3 w-full table-fixed">
                <thead>
                    <tr class="bg-gray-200 text-left border-b-2 border-gray-300">
                        <th class="py-5 font-semibold text-gray-700 uppercase text-xs" style="width: 5rem;"></th>
                        <th class="w-1/12 py-5 font-semibold text-gray-700 uppercase text-xs">Jenjang</th>
                        <th class="w-3/12 py-5 font-semibold text-gray-700 uppercase text-xs">Prodi</th>
                        <th class="w-4/12 py-5 font-semibold text-gray-700 uppercase text-xs">Perguruan Tinggi</th>
                        <th class="w-4/12 py-5 font-semibold text-gray-700 uppercase text-xs">Website Prodi</th>
                        <th class="w-2/12 py-5 font-semibold text-gray-700 uppercase text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @php $no = ($members->currentPage() - 1) * $members->perPage(); @endphp
                    @foreach ($members as $member)
                        @php $no++; @endphp
                        <tr class="hover:bg-gray-200">
                            <td class="py-4 bg-gray-100 text-center border-r border-gray-300">{{ $no }}</td>
                            <td class="px-2 py-3">{{ $member->jenjang }}</td>
                            <td class="px-2 py-3">{{ $member->nama_prodi }}</td>
                            <td class="px-2 py-3">{{ $member->pt['lengkap'] }}</td>
                            <td class="px-2 truncate group">
                                <a href="{{ $member->web_prodi }}" target="_blank" title="{{ $member->web_prodi }}" class="w-full h-full text-blue-400 lowercase align-middle">
                                    <span class="align-middle truncate w-full">{{ $member->web_prodi }}</span>
                                    <span class="material-icons align-text-bottom text-sm hidden group-hover:inline">open_in_new</span>
                                </a>
                            </td>
                            <td class="px-2 truncate">
                                <button class="btn px-3 py-1" onclick="showProfile({{ $member->id }})">Lihat detail</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
        <div class="bg-white pl-4 border-t-2 border-gray-300">
            {{-- <form action="route()" method="get"></form> --}}
            {{ $members->links() }}
        </div>
    </div>
    {{-- <Modal title="hmm">
        <profile-modalBody></profile-modalBody>
    </Modal> --}}
</div>

@include('member._modal-profile')
        
@endsection

@push('script')
<script defer>
    let profiles
    
    document.addEventListener('DOMContentLoaded', () => {
        detailModal.close()
    
        profiles = (@json($members)).data
    })

    function showProfile(id) {
        let profile = profiles.filter(profile => profile.id === id)
        profile = profile[profile.length - 1]
    
        detailModal.akreditasiInternasional = profile.akreditasi_prodi.internasional
        detailModal.akreditasiPT            = profile.akreditasi_pt
        detailModal.akreditasiProdi         = profile.akreditasi_prodi.akreditasi
        detailModal.alamat                  = profile.alamat_kampus.alamat
        detailModal.emailKaprodi            = profile.kaprodi.email
        detailModal.emailProdi              = profile.email_prodi
        detailModal.fakultas                = profile.fakultas
        detailModal.jenjangProdi            = profile.jenjang
        detailModal.jurusan                 = profile.jurusan
        detailModal.kota                    = profile.alamat_kampus.kota
        detailModal.mulaiKaprodi            = profile.kaprodi.periode.mulai
        detailModal.namaKaprodi             = profile.kaprodi.nama
        detailModal.noKaprodi               = profile.kaprodi.no
        detailModal.provinsi                = profile.alamat_kampus.provinsi
        detailModal.ptSingkat               = profile.pt.singkat
        detailModal.purnaKaprodi            = profile.kaprodi.periode.purna
        detailModal.status                  = profile.status
        detailModal.telpon                  = profile.no_telp_prodi
        detailModal.username                = `${profile.jenjang} ${profile.pt.singkat}`.toUpperCase()
        detailModal.web                     = profile.web_prodi

        detailModal.show()
    }
</script>
@endpush