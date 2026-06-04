<x-admin-layout title="Edit Konser">

    {{-- Back button --}}
    <div class="mb-6">
        <a href="{{ route('admin.concerts.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Konser
        </a>
    </div>

    {{-- Error Alert --}}
    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl text-sm">
            <p class="font-bold mb-2">Terdapat kesalahan pada form:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ===== FORM EDIT ===== --}}
        <div class="lg:col-span-2">
            <form action="{{ route('admin.concerts.update', $concert) }}" method="POST"
                  enctype="multipart/form-data"
                  x-data="{
                      tickets: {{ json_encode($concert->ticketCategories->map(fn($c) => ['category_name' => $c->category_name, 'price' => $c->price, 'total_quota' => $c->total_quota])->values()) }},
                      addTicket() { this.tickets.push({ category_name: '', price: '', total_quota: '' }) },
                      removeTicket(i) { if (this.tickets.length > 1) this.tickets.splice(i, 1) },
                      previewUrl: '{{ $concert->banner_url ? Storage::url($concert->banner_url) : '' }}',
                      handleFile(e) {
                          const file = e.target.files[0];
                          if (file) this.previewUrl = URL.createObjectURL(file);
                      },
                      allArtists: @json($artists),
                      selectedArtists: @json($concert->artists->map(fn($a) => ['id' => $a->id, 'name' => $a->name, 'genre' => $a->genre])->values()),
                      artistSearch: '',
                      showArtistDropdown: false,
                      get filteredArtists() {
                          const q = this.artistSearch.toLowerCase();
                          return this.allArtists.filter(a =>
                              !this.selectedArtists.find(s => s.id === a.id) &&
                              a.name.toLowerCase().includes(q)
                          );
                      },
                      selectArtist(artist) {
                          this.selectedArtists.push(artist);
                          this.artistSearch = '';
                          this.showArtistDropdown = false;
                      },
                      removeArtist(id) {
                          this.selectedArtists = this.selectedArtists.filter(a => a.id !== id);
                      }
                  }">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7 space-y-5">
                    <h2 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-4">Detail Konser</h2>

                    {{-- Judul --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                            Judul Konser <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $concert->title) }}"
                               placeholder="Contoh: Dewa 19 Live in Concert"
                               class="w-full px-4 py-2.5 border @error('title') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                        @error('title')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Venue & Kota --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                Nama Venue <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="venue_name" value="{{ old('venue_name', $concert->venue_name) }}"
                                   class="w-full px-4 py-2.5 border @error('venue_name') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                            @error('venue_name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                Kota <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="city" value="{{ old('city', $concert->city) }}"
                                   class="w-full px-4 py-2.5 border @error('city') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                            @error('city')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Tanggal & Waktu --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                Tanggal Acara <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="event_date"
                                   value="{{ old('event_date', $concert->event_date->format('Y-m-d')) }}"
                                   class="w-full px-4 py-2.5 border @error('event_date') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                            @error('event_date')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                Waktu Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="event_time"
                                   value="{{ old('event_time', \Carbon\Carbon::parse($concert->event_time)->format('H:i')) }}"
                                   class="w-full px-4 py-2.5 border @error('event_time') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                            @error('event_time')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status"
                                class="w-full px-4 py-2.5 border @error('status') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                            <option value="draft"     {{ old('status', $concert->status) === 'draft'     ? 'selected' : '' }}>Draft</option>
                            <option value="active"    {{ old('status', $concert->status) === 'active'    ? 'selected' : '' }}>Aktif</option>
                            <option value="completed" {{ old('status', $concert->status) === 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                            Deskripsi <span class="text-gray-400 font-normal normal-case">(opsional)</span>
                        </label>
                        <textarea name="description" rows="3"
                                  placeholder="Ceritakan detail mengenai konser ini..."
                                  class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 resize-none">{{ old('description', $concert->description) }}</textarea>
                    </div>

                    {{-- Banner / Gambar --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                            Gambar Banner <span class="text-gray-400 font-normal normal-case">(opsional, maks 2 MB)</span>
                        </label>

                        {{-- Preview --}}
                        <div x-show="previewUrl" class="mb-3">
                            <img :src="previewUrl" alt="Preview Banner"
                                 class="w-full max-h-48 object-cover rounded-xl border border-gray-200">
                        </div>

                        <label class="flex items-center gap-3 w-full px-4 py-3 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 transition-colors">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm text-gray-500">Klik untuk upload gambar baru (JPG, PNG, WebP)</span>
                            <input type="file" name="banner" accept="image/*" class="hidden" @change="handleFile($event)">
                        </label>
                        @error('banner')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ===== ARTIS TAMPIL ===== --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7 mt-6">
                    <h2 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-4 mb-5">Artis Tampil</h2>

                    @error('artist_ids')
                        <p class="mb-3 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    {{-- Selected chips --}}
                    <div class="flex flex-wrap gap-2 mb-3" x-show="selectedArtists.length > 0">
                        <template x-for="artist in selectedArtists" :key="artist.id">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                <input type="hidden" name="artist_ids[]" :value="artist.id">
                                <span x-text="artist.name"></span>
                                <button type="button" @click="removeArtist(artist.id)"
                                        class="text-blue-400 hover:text-blue-600 transition-colors leading-none">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </span>
                        </template>
                    </div>

                    {{-- Search dropdown --}}
                    <div class="relative" @click.outside="showArtistDropdown = false">
                        <div class="flex items-center px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 gap-2">
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" x-model="artistSearch"
                                   @focus="showArtistDropdown = true"
                                   @input="showArtistDropdown = true"
                                   placeholder="Cari dan pilih artis..."
                                   class="w-full bg-transparent border-none focus:ring-0 text-sm outline-none text-gray-900 placeholder-gray-400">
                        </div>
                        <div x-show="showArtistDropdown && filteredArtists.length > 0"
                             class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg z-30 max-h-52 overflow-y-auto">
                            <template x-for="artist in filteredArtists" :key="artist.id">
                                <button type="button"
                                        @click="selectArtist(artist)"
                                        class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span x-text="artist.name"></span>
                                    <span x-show="artist.genre" class="ml-auto text-xs text-gray-400" x-text="artist.genre"></span>
                                </button>
                            </template>
                        </div>
                        <p x-show="showArtistDropdown && filteredArtists.length === 0 && artistSearch.length > 0"
                           class="mt-1 text-xs text-gray-400 px-1">Tidak ada artis ditemukan.</p>
                    </div>
                </div>

                {{-- ===== KATEGORI TIKET ===== --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7 mt-6">
                    <div class="flex items-center justify-between mb-5 border-b border-gray-100 pb-4">
                        <h2 class="text-base font-bold text-gray-900">Kategori Tiket</h2>
                        <button type="button" @click="addTicket()"
                                class="flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Tambah Kategori
                        </button>
                    </div>

                    @error('ticket_categories')
                        <p class="mb-3 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <div class="space-y-3">
                        <template x-for="(ticket, index) in tickets" :key="index">
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold text-gray-500 uppercase" x-text="'Kategori ' + (index + 1)"></span>
                                    <button type="button" @click="removeTicket(index)"
                                            x-show="tickets.length > 1"
                                            class="text-red-400 hover:text-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Nama Kategori</label>
                                        <input type="text"
                                               :name="'ticket_categories[' + index + '][category_name]'"
                                               x-model="ticket.category_name"
                                               placeholder="Contoh: VIP"
                                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Harga (Rp)</label>
                                        <input type="number"
                                               :name="'ticket_categories[' + index + '][price]'"
                                               x-model="ticket.price"
                                               placeholder="500000"
                                               min="0"
                                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Total Kuota</label>
                                        <input type="number"
                                               :name="'ticket_categories[' + index + '][total_quota]'"
                                               x-model="ticket.total_quota"
                                               placeholder="100"
                                               min="1"
                                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex items-center justify-end gap-3 mt-6">
                    <a href="{{ route('admin.concerts.index') }}"
                       class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

        {{-- ===== SIDEBAR INFO ===== --}}
        <div class="space-y-6">
            {{-- Current Banner --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-900 mb-3">Banner Saat Ini</h3>
                @if($concert->banner_url)
                    <img src="{{ Storage::url($concert->banner_url) }}"
                         alt="Banner {{ $concert->title }}"
                         class="w-full h-40 object-cover rounded-xl border border-gray-200">
                @else
                    <div class="w-full h-40 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-xs text-gray-400">Belum ada banner</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Info Card --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">
                <h3 class="text-sm font-bold text-blue-800 mb-2">Info</h3>
                <ul class="space-y-2 text-xs text-blue-700">
                    <li class="flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Mengubah kuota tiket akan mereset kuota yang tersedia ke nilai baru.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Upload gambar baru akan menggantikan gambar lama secara otomatis.
                    </li>
                </ul>
            </div>
        </div>

    </div>{{-- end grid --}}
</x-admin-layout>
