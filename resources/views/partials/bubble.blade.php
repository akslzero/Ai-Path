<!-- Floating AI Assistant -->
<div x-data="{ open: false }" class="fixed bottom-6 right-6 z-50">

    <!-- Bubble Button (kosong dulu) -->
    <button @click="open = !open"
        class="bg-white hover:bg-gray-200 rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition">
        <!-- ikon bisa ditaruh di sini nanti -->
    </button>

    <!-- Box kosong -->
    <div x-show="open" x-transition @click.outside="open = false"
        class="absolute bottom-20 right-0 w-[400px] h-[500px] bg-white border border-gray-200 rounded-2xl shadow-2xl overflow-hidden">

        <!-- Header -->
        <div class="flex justify-between items-center border-b p-4">
            <h2 class="text-lg font-semibold text-gray-700">AI Assistant</h2>
            <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                ✕
            </button>
        </div>

        <!-- Kosongan -->
        <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
            (kosong — isi nanti di sini)
        </div>
    </div>
</div>
