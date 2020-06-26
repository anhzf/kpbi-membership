@extends('dashboard')

@section('page')

    <table class="col-span-3 w-full table-fixed">
        <thead>
            <tr class="bg-gray-200 border-b-2 border-gray-300">
                <th class="py-5 font-semibold text-gray-700 uppercase text-xs" style="width: 5rem;"></th>
                <th class="w-1/12 py-5 font-semibold text-gray-700 uppercase text-xs">Jenjang</th>
                <th class="w-3/12 py-5 font-semibold text-gray-700 uppercase text-xs">Prodi</th>
                <th class="w-4/12 py-5 font-semibold text-gray-700 uppercase text-xs">Perguruan Tinggi</th>
                <th class="w-4/12 py-5 font-semibold text-gray-700 uppercase text-xs">Website Prodi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($members as $member)
                <tr class="hover:bg-gray-200">
                    <td class="py-4 bg-gray-100 text-center border-r border-gray-300">{{ $no }}</td>
                    <td class="px-2 py-3">{{ $member->jenjang }}</td>
                    <td class="px-2 py-3">{{ $member->nama_prodi }}{{ $member->jurusan ? " - {$member->jurusan}":''  }}</td>
                    <td class="px-2 py-3">{{ $member->pt['lengkap'] }}</td>
                    <td class="px-2 truncate">
                        <a href="{{ $member->web_prodi }}" target="_blank" title="{{ $member->web_prodi }}" class="w-full h-full text-blue-400 lowercase align-middle">
                            <span class="align-middle truncate w-full">{{ $member->web_prodi }}</span>
                            <span class="material-icons align-text-bottom text-sm">open_in_new</span>
                        </a>
                    </td>
                </tr>
                @php $no++; @endphp
            @endforeach
        </tbody>
    </table>

@endsection