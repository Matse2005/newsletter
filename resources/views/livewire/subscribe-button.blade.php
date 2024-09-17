<div>
    @if ($loading)
        <button type="button" class="px-6 py-3 text-white bg-red-700 shadow-lg cursor-not-allowed rounded-xl">
            <svg class="inline-block w-5 h-5 mr-3 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 118 8 8 8 0 01-8-8zm8-4a4 4 0 00-4 4H4a8 8 0 018-8V4z"></path>
            </svg>
            Subscribe again
        </button>
    @else
        <button type="button" wire:click="unsubscribe"
            class="px-6 py-3 text-white transition-all duration-300 ease-in-out transform bg-red-600 shadow-lg rounded-xl hover:bg-red-700">
            Subscribe again
        </button>
    @endif
</div>
