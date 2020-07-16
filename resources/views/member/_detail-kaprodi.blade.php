<div class="grid grid-cols-1 sm:grid-cols-3 my-4 p-4 bg-white hover:bg-gray-100 rounded-lg shadow hover:shadow-xl transition-shadow ease-in duration-150">
    <div id="detailEl__kaprodi" class="row-start-2 sm:row-start-1 col-span-2">
        <table class="table-auto text-xs m-1">
            <tbody class="align-top">
                <tr>
                    <td class="w-24">{{ __('Kepala Program Studi') }}</td>
                    <td>:</td>
                    <td id="detail__namaKaprodi">Dr. Lorem, ipsum dolor</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">
                        (<span id="detail__mulaiKaprodi">2012</span> {{ __('sampai dengan') }} <span id="detail__purnaKaprodi">2013</span>)
                    </td>
                </tr>
                <tr>
                    <td class="w-24">{{ __('Email Kaprodi') }}</td>
                    <td>:</td>
                    <td>
                        <a id="detail__emailKaprodi" href="mailto:lorem@ipsum.co" target="_blank" class="text-blue-500 hover:underline">lorem@ipsum.co</a>
                    </td>
                </tr>
                <tr>
                    <td class="w-24">{{ __('Nomor HP Kaprodi') }}</td>
                    <td>:</td>
                    <td id="detail__noKaprodi">+62-xxx-xxxx-xxxx</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="detail__fotoKaprodi" class="flex flex-col items-center">
        <img id="detail__picture" class="bg-gray-400 m-2 p-4 w-24 h-24 rounded-full">
    </div>
</div>