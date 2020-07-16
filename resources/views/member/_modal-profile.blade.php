<div
    id="detail__modal"
    class="
        modal__container fixed
        top-0 left-0
        w-screen h-screen
        grid grid-center
        grid-cols-1 md:grid-cols-5 lg:grid-cols-7 xl:grid-cols-3
    "
>
    <div class="modal__overlay absolute w-full h-full bg-gray-500 opacity-25" onclick="detailModal.close()"></div>

    <div
        class="
            modal relative overflow-y-auto
            col-start-1 md:col-start-2 lg:col-start-3 xl:col-start-2
            col-span-1 md:col-span-3 xl:col-span-1
            sm:w-3/4 md:w-full
            max-h-screen
            bg-white rounded-lg shadow-lg
            flex flex-col justify-between
        "
    >

        <div class="modal__header m-2 mb-0 px-4 py-2 border-b-2 border-gray-300">
            <div class="modal__header__title">
                <h1 id="detail__title" class="text-lg">Detail</h1>
            </div>
            
            <div
                onclick="detailModal.close()"
                class="modal__header__close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 p-1 text-gray-800 text-sm z-50 rounded-full hover:text-white hover:bg-red-400"
            >
                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </div>
        </div>

        <div class="modal__body m-2 px-2 py-1 pb-4 flex flex-col overflow-y-auto leading-relaxed">
            <div class="grid grid-cols-1 sm:grid-cols-2">
                @include('member._detail-prodi')
                @include('member._detail-pt')
            </div>
            @include('member._detail-kaprodi')
            <div class="text-xs">
                <span>Info Lengkap silahkan klik tautan ini</span>
                <a id="detail__web" href="http://example.com" target="_blank" class="text-blue-500 hover:underline">http://example.com</a>
            </div>
        </div>
    </div>

</div>