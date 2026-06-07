<x-admin-layout title="Management Konser">

    {{-- Success Alert --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3.5 rounded-xl text-sm font-semibold">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl text-sm">
            <p class="font-bold mb-2">Terdapat kesalahan pada form:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Action Bar --}}
    <div x-data="{
        openModal: {{ $errors->any() ? 'true' : 'false' }},
        deleteModal: false,
        deleteHasTransaction: false,
        deleteTitle: '',
        deleteAction: '',
        openDeleteModal(hasTransaction, title, action) {
            this.deleteHasTransaction = hasTransaction;
            this.deleteTitle = title;
            this.deleteAction = action;
            this.deleteModal = true;
        }
    }">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <form method="GET" action="{{ route('admin.concerts.index') }}"
                  class="flex items-center px-4 py-2 bg-white rounded-xl border border-gray-200 w-full sm:w-[350px]">
                <svg class="w-5 h-5 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" value="{{ $keyword }}"
                       placeholder="Cari acara berdasarkan nama"
                       class="w-full bg-transparent border-none focus:ring-0 text-sm outline-none text-gray-900 placeholder-gray-400">
                @if($keyword)
                    <a href="{{ route('admin.concerts.index') }}" class="text-gray-400 hover:text-gray-600 ml-1 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                @endif
            </form>

            <button @click="openModal = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Acara
            </button>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <div class="min-w-[900px]">
                    {{-- Table Header --}}
                    <div class="bg-blue-600 px-6 py-4 grid grid-cols-12 gap-4 items-center">
                <div class="col-span-4 text-sm font-semibold text-white">Detail Acara</div>
                <div class="col-span-2 text-sm font-semibold text-white">Lokasi</div>
                <div class="col-span-2 text-sm font-semibold text-white">Tanggal & Waktu</div>
                <div class="col-span-2 text-sm font-semibold text-white">Status</div>
                <div class="col-span-1 text-sm font-semibold text-white">Tiket</div>
                <div class="col-span-1 text-sm font-semibold text-white text-center">Aksi</div>
            </div>

            {{-- Table Body --}}
            <div class="divide-y divide-gray-50">
                @forelse($concerts as $concert)
                    <div class="px-6 py-5 grid grid-cols-12 gap-4 items-center hover:bg-blue-50/40 transition-colors duration-150">

                        {{-- Detail Acara (dengan gambar) --}}
                        <div class="col-span-4 flex items-center gap-4">
                            {{-- Banner thumbnail --}}
                            @if($concert->banner_url)
                                <img src="{{ Storage::url($concert->banner_url) }}"
                                     alt="{{ $concert->title }}"
                                     class="w-16 h-16 object-cover rounded-xl flex-shrink-0 border border-gray-200">
                            @else
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex-shrink-0 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2M15 11v2M15 17v2M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7a2 2 0 0 1 2-2z"/>
                                    </svg>
                                </div>
                            @endif

                            <div>
                                <p class="font-bold text-gray-900 text-sm mb-0.5">{{ $concert->title }}</p>
                                @if($concert->artists->count() > 0)
                                    <p class="text-xs text-blue-500 font-semibold mb-0.5">
                                        {{ $concert->artists->pluck('name')->join(' & ') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        <div class="col-span-2">
                            <p class="font-bold text-xs text-gray-900">{{ $concert->venue_name }}</p>
                            <p class="text-[10px] text-gray-500">{{ $concert->city }}</p>
                        </div>

                        {{-- Tanggal & Waktu --}}
                        <div class="col-span-2">
                            <p class="font-bold text-xs text-gray-900">
                                {{ $concert->event_date->translatedFormat('d M Y') }}
                            </p>
                            <p class="text-[10px] text-gray-500">
                                {{ \Carbon\Carbon::parse($concert->event_time)->format('H:i') }} WIB
                            </p>
                        </div>

                        {{-- Status --}}
                        <div class="col-span-2">
                            @php
                                $statusClass = match($concert->status) {
                                    'active'    => 'bg-green-100 text-green-700',
                                    'draft'     => 'bg-yellow-100 text-yellow-700',
                                    'completed' => 'bg-gray-100 text-gray-600',
                                    default     => 'bg-gray-100 text-gray-600',
                                };
                                $statusLabel = match($concert->status) {
                                    'active'    => 'Aktif',
                                    'draft'     => 'Draft',
                                    'completed' => 'Selesai',
                                    default     => $concert->status,
                                };
                            @endphp
                            <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        {{-- Jumlah Tiket --}}
                        <div class="col-span-1">
                            <p class="text-xs font-bold text-gray-700">{{ $concert->ticketCategories->count() }} kategori</p>
                            <p class="text-[10px] text-gray-400">
                                {{ $concert->ticketCategories->sum('available_quota') }} tersedia
                            </p>
                        </div>

                        {{-- Aksi --}}
                        <div class="col-span-1 flex items-center justify-center gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('admin.concerts.edit', $concert) }}"
                               class="text-gray-400 hover:text-blue-600 border border-gray-200 rounded-full p-1.5 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </a>

                            {{-- Hapus --}}
                            @php
                                $hasTransaction = $concert->ticketCategories->some(fn($c) => $c->transactionDetails->isNotEmpty());
                            @endphp
                            <button type="button"
                                    @click="openDeleteModal(
                                        {{ $hasTransaction ? 'true' : 'false' }},
                                        '{{ addslashes($concert->title) }}',
                                        '{{ route('admin.concerts.destroy', $concert) }}'
                                    )"
                                    class="text-gray-400 hover:text-red-600 border border-gray-200 rounded-full p-1.5 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>

                    </div>
                @empty
                    <div class="px-6 py-16 text-center">
                        <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-400 font-semibold text-sm mb-1">Belum ada konser</p>
                        <p class="text-gray-300 text-xs">Klik "Tambah Acara" untuk menambahkan konser pertama.</p>
                    </div>
                @endforelse
            </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- MODAL: Tambah Konser --}}
        {{-- ============================================================ --}}
        <div x-show="openModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             style="display: none;">

            {{-- Backdrop --}}
            <div @click="openModal = false" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

            {{-- Modal Panel --}}
            <div x-show="openModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto z-10">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between px-7 py-5 border-b border-gray-100 sticky top-0 bg-white z-10">
                    <h2 class="text-lg font-bold text-gray-900">Tambah Konser Baru</h2>
                    <button @click="openModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Form --}}
                <form action="{{ route('admin.concerts.store') }}" method="POST"
                      enctype="multipart/form-data"
                      x-data="{
                          tickets: {{ old('ticket_categories') ? json_encode(array_values(old('ticket_categories'))) : '[{ category_name: \'\', price: \'\', total_quota: \'\' }]' }},
                          addTicket() { this.tickets.push({ category_name: '', price: '', total_quota: '' }) },
                          removeTicket(i) { if (this.tickets.length > 1) this.tickets.splice(i, 1) },
                          previewUrl: '',
                          handleFile(e) {
                              const file = e.target.files[0];
                              if (file) this.previewUrl = URL.createObjectURL(file);
                          },
                          allArtists: [],
                          artistsLoaded: false,
                          selectedArtists: {{ json_encode(collect(old('artist_ids', []))->map(fn($id) => $artists->firstWhere('id', (int)$id))->filter()->values()) }},
                          artistSearch: '',
                          showArtistDropdown: false,
                          fetchArtists(q = '') {
                              fetch(`{{ route('admin.artists.search') }}?q=${encodeURIComponent(q)}`)
                                  .then(r => r.json())
                                  .then(data => { this.allArtists = data; this.artistsLoaded = true; });
                          },
                          get filteredArtists() {
                              return this.allArtists.filter(a =>
                                  !this.selectedArtists.find(s => s.id === a.id)
                              );
                          },
                          openDropdown() {
                              this.showArtistDropdown = true;
                              if (!this.artistsLoaded) this.fetchArtists();
                          },
                          onSearchInput() {
                              this.showArtistDropdown = true;
                              clearTimeout(this._debounce);
                              this._debounce = setTimeout(() => this.fetchArtists(this.artistSearch), 300);
                          },
                          selectArtist(artist) {
                              this.selectedArtists.push(artist);
                              this.artistSearch = '';
                              this.allArtists = this.allArtists.filter(a => a.id !== artist.id);
                              this.showArtistDropdown = false;
                          },
                          removeArtist(id) {
                              this.selectedArtists = this.selectedArtists.filter(a => a.id !== id);
                          }
                      }">
                    @csrf
                    <div class="px-7 py-6 space-y-5">

                        {{-- Judul --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                Judul Konser <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                   placeholder="Contoh: Dewa 19 Live in Concert"
                                   class="w-full px-4 py-2.5 border @error('title') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                            @error('title')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Venue & Kota --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                    Nama Venue <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="venue_name" value="{{ old('venue_name') }}"
                                       placeholder="Contoh: Gelora Bung Karno"
                                       class="w-full px-4 py-2.5 border @error('venue_name') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                                @error('venue_name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                    Kota <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="city" value="{{ old('city') }}"
                                       placeholder="Contoh: Jakarta"
                                       class="w-full px-4 py-2.5 border @error('city') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                                @error('city')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tanggal & Waktu --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                    Tanggal Acara <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="event_date" value="{{ old('event_date') }}"
                                       min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
                                       class="w-full px-4 py-2.5 border @error('event_date') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                                @error('event_date')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                    Waktu Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="event_time" value="{{ old('event_time') }}"
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
                                <option value="">-- Pilih Status --</option>
                                <option value="draft"     {{ old('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
                                <option value="active"    {{ old('status') === 'active'    ? 'selected' : '' }}>Aktif</option>
                                <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
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
                                      class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 resize-none">{{ old('description') }}</textarea>
                        </div>

                        {{-- Banner / Gambar --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                Gambar Banner <span class="text-gray-400 font-normal normal-case">(opsional)</span>
                            </label>

                            <div x-show="previewUrl" class="mb-2">
                                <img :src="previewUrl" alt="Preview"
                                     class="w-full max-h-36 object-cover rounded-xl border border-gray-200">
                            </div>

                            <label class="flex items-center gap-3 w-full px-4 py-3 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 transition-colors">
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm text-gray-500">Klik untuk upload gambar (JPG, PNG, WebP)</span>
                                <input type="file" name="banner" accept="image/*" class="hidden" @change="handleFile($event)">
                            </label>

                            @error('banner')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Artis Tampil --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                Artis Tampil <span class="text-red-500">*</span>
                            </label>

                            {{-- Error --}}
                            @error('artist_ids')
                                <p class="mb-2 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                            {{-- Selected chips --}}
                            <div class="flex flex-wrap gap-2 mb-2" x-show="selectedArtists.length > 0">
                                <template x-for="artist in selectedArtists" :key="artist.id">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
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
                                           @focus="openDropdown()"
                                           @input="onSearchInput()"
                                           placeholder="Cari dan pilih artis..."
                                           class="w-full bg-transparent border-none focus:ring-0 text-sm outline-none text-gray-900 placeholder-gray-400">
                                </div>
                                <div x-show="showArtistDropdown && filteredArtists.length > 0"
                                     class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg z-50 max-h-48 overflow-y-auto">
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

                        {{-- Kategori Tiket --}}
                        <div>

                            <div class="flex items-center justify-between mb-3">
                                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">
                                    Kategori Tiket <span class="text-red-500">*</span>
                                </label>
                                <button type="button" @click="addTicket()"
                                        class="flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Tambah Kategori
                                </button>
                            </div>

                            @error('ticket_categories')
                                <p class="mb-2 text-xs text-red-500">{{ $message }}</p>
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
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
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

                    </div>{{-- end px-7 --}}

                    {{-- Modal Footer --}}
                    <div class="flex items-center justify-end gap-3 px-7 py-5 border-t border-gray-100 sticky bottom-0 bg-white">
                        <button type="button" @click="openModal = false"
                                class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Konser
                        </button>
                    </div>

                </form>
            </div>{{-- end modal panel --}}
        </div>{{-- end modal overlay --}}

        {{-- ============================================================ --}}
        {{-- MODAL: Konfirmasi / Alert Hapus Konser --}}
        {{-- ============================================================ --}}
        <div x-show="deleteModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             style="display: none;">

            {{-- Backdrop --}}
            <div @click="deleteModal = false" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

            {{-- Modal Panel --}}
            <div x-show="deleteModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 overflow-hidden">

                {{-- Skenario: ADA transaksi — tidak bisa dihapus --}}
                <template x-if="deleteHasTransaction">
                    <div>
                        <div class="flex flex-col items-center px-8 pt-8 pb-6 text-center">
                            <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Tidak Dapat Dihapus</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Konser <span class="font-semibold text-gray-800" x-text="'\"' + deleteTitle + '\"'"></span>
                                tidak dapat dihapus karena konser belum terlaksana dan sudah ada yang membeli atau melakukan transaksi.
                            </p>
                        </div>
                        <div class="px-8 pb-6">
                            <button type="button" @click="deleteModal = false"
                                    class="w-full py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-semibold text-gray-700 transition-colors">
                                Mengerti
                            </button>
                        </div>
                    </div>
                </template>

                {{-- Skenario: TIDAK ada transaksi — bisa dihapus --}}
                <template x-if="!deleteHasTransaction">
                    <div>
                        <div class="flex flex-col items-center px-8 pt-8 pb-6 text-center">
                            <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Konser?</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Konser <span class="font-semibold text-gray-800" x-text="'\"' + deleteTitle + '\"'"></span>
                                akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                        <div class="flex gap-3 px-8 pb-6">
                            <button type="button" @click="deleteModal = false"
                                    class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <form :action="deleteAction" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition-colors">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </template>

            </div>{{-- end modal panel --}}
        </div>{{-- end delete modal --}}

    </div>{{-- end x-data openModal --}}
</x-admin-layout>
