<header class="p-4 bg-neutral-50">
    <div class="border-b mb-2 pb-2">
        <a href="/meta/{{ $id_colab }}/eda/{{ $id_eda }}"
            class="flex items-center gap-2 hover:bg-neutral-200 text-neutral-500 max-w-max px-3 rounded-xl">
            <svg width="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_iconCarrier">
                    <path d="M6 12H18M6 12L11 7M6 12L11 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </g>
            </svg>
            <h2 class="text-xl p-2 font-semibold">Objetivos</h2>
        </a>
    </div>
    <nav class="pt-2 flex gap-2">
        @if ($objetivos->sum('porcentaje') == 100)
            <button data-id="{{ $id_eda }}" id="enviar-eda-btn"
                class="text-white w-[200px] flex justify-center gap-2 items-center bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2 text-center "
                type="button">
                <svg width="20" viewBox="0 0 24 24" fill="none">
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M10.3009 13.6949L20.102 3.89742M10.5795 14.1355L12.8019 18.5804C13.339 19.6545 13.6075 20.1916 13.9458 20.3356C14.2394 20.4606 14.575 20.4379 14.8492 20.2747C15.1651 20.0866 15.3591 19.5183 15.7472 18.3818L19.9463 6.08434C20.2845 5.09409 20.4535 4.59896 20.3378 4.27142C20.2371 3.98648 20.013 3.76234 19.7281 3.66167C19.4005 3.54595 18.9054 3.71502 17.9151 4.05315L5.61763 8.2523C4.48114 8.64037 3.91289 8.83441 3.72478 9.15032C3.56153 9.42447 3.53891 9.76007 3.66389 10.0536C3.80791 10.3919 4.34498 10.6605 5.41912 11.1975L9.86397 13.42C10.041 13.5085 10.1295 13.5527 10.2061 13.6118C10.2742 13.6643 10.3352 13.7253 10.3876 13.7933C10.4468 13.87 10.491 13.9585 10.5795 14.1355Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </g>
                </svg>
                Enviar
            </button>
        @else
            <button data-modal-target="create-colab-modal" data-modal-toggle="create-colab-modal"
                class="text-white w-[200px] bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2 text-center "
                type="button">
                Agregar objetivo
            </button>
        @endif
        <div class="bg-neutral-300 font-medium px-4 rounded-xl p-2">
            Total porcentaje {{ $objetivos->sum('porcentaje') }}%
        </div>
    </nav>
</header>
