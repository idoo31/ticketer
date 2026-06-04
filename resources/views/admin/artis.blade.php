<x-admin-layout title="Manajemen Artis">

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

    <div x-data="{ openModal: {{ $errors->any() ? 'true' : 'false' }}, deleteArtistId: null, deleteArtistName: '', concertCount: 0 }">

        {{-- Action Bar --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            {{-- Search & Filter --}}
            <form method="GET" action="{{ route('admin.artists.index') }}" class="flex items-center gap-3 flex-wrap w-full sm:w-auto">
                <div class="flex items-center px-4 py-2 bg-white rounded-xl border border-gray-200 w-full sm:w-[280px]">
                    <svg class="w-5 h-5 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" value="{{ $keyword }}"
                           placeholder="Cari nama artis..."
                           class="w-full bg-transparent border-none focus:ring-0 text-sm outline-none text-gray-900 placeholder-gray-400">
                    @if($keyword)
                        <a href="{{ route('admin.artists.index', ['genre' => $genre]) }}" class="text-gray-400 hover:text-gray-600 ml-1 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>

                <select name="genre"
                        class="px-4 py-2 bg-white rounded-xl border border-gray-200 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        onchange="this.form.submit()">
                    <option value="">Semua Genre</option>
                    @foreach($genres as $g)
                        <option value="{{ $g }}" {{ $genre === $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                </select>
            </form>

            <button @click="openModal = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Artis
            </button>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <div class="min-w-[800px]">
                    {{-- Header --}}
                    <div class="bg-[#1f2937] px-6 py-4 grid grid-cols-12 gap-4 items-center">
                <div class="col-span-1 text-xs font-semibold text-gray-300">Foto</div>
                <div class="col-span-3 text-xs font-semibold text-gray-300">Nama Artis</div>
                <div class="col-span-2 text-xs font-semibold text-gray-300">Genre</div>
                <div class="col-span-2 text-xs font-semibold text-gray-300">Asal/Kota</div>
                <div class="col-span-2 text-xs font-semibold text-gray-300">Status</div>
                <div class="col-span-2 text-xs font-semibold text-gray-300 text-center">Aksi</div>
            </div>

            {{-- Body --}}
            <div class="divide-y divide-gray-100">
                @forelse($artists as $artist)
                    <div class="px-6 py-4 grid grid-cols-12 gap-4 items-center {{ $artist->trashed() ? 'bg-red-50/40' : '' }}">

                        {{-- Foto --}}
                        <div class="col-span-1">
                            @if($artist->image_url)
                                <img src="{{ Storage::url($artist->image_url) }}"
                                     alt="{{ $artist->name }}"
                                     class="w-12 h-12 object-cover rounded-xl border border-gray-200 {{ $artist->trashed() ? 'opacity-50' : '' }}">
                            @else
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center {{ $artist->trashed() ? 'opacity-50' : '' }}">
                                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Nama --}}
                        <div class="col-span-3">
                            <p class="font-bold text-sm text-gray-900 {{ $artist->trashed() ? 'line-through text-gray-400' : '' }}">{{ $artist->name }}</p>
                            @if($artist->instagram_url)
                                <a href="{{ $artist->instagram_url }}" target="_blank"
                                   class="text-xs text-blue-500 hover:underline truncate block max-w-[180px]">
                                    {{ $artist->instagram_url }}
                                </a>
                            @endif
                        </div>

                        {{-- Genre --}}
                        <div class="col-span-2">
                            <span class="text-xs text-gray-600 bg-gray-100 px-2.5 py-1 rounded-full">{{ $artist->genre ?: '—' }}</span>
                        </div>

                        {{-- Asal --}}
                        <div class="col-span-2">
                            <p class="text-xs text-gray-600">{{ $artist->origin ?: '—' }}</p>
                        </div>

                        {{-- Status --}}
                        <div class="col-span-2">
                            @if($artist->trashed())
                                <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-600">Dihapus</span>
                            @elseif($artist->is_active)
                                <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-500">Nonaktif</span>
                            @endif
                        </div>

                        {{-- Aksi --}}
                        <div class="col-span-2 flex items-center justify-center gap-2">
                            @unless($artist->trashed())
                                <a href="{{ route('admin.artists.edit', $artist) }}"
                                   class="text-gray-400 hover:text-blue-600 border border-gray-200 rounded-full p-1.5 transition-colors"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </a>

                                {{-- Delete button triggers Alpine confirm modal --}}
                                <button type="button"
                                        @click="deleteArtistId = {{ $artist->id }}; deleteArtistName = '{{ addslashes($artist->name) }}'; concertCount = {{ $artist->concerts()->count() }}; $dispatch('open-delete-modal')"
                                        class="text-gray-400 hover:text-red-600 border border-gray-200 rounded-full p-1.5 transition-colors"
                                        title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            @else
                                <span class="text-xs text-gray-400 italic">Nonaktif</span>
                            @endunless
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-16 text-center">
                        <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <p class="text-gray-400 font-semibold text-sm mb-1">Belum ada artis</p>
                        <p class="text-gray-300 text-xs">Klik "+ Tambah Artis" untuk menambahkan artis pertama.</p>
                    </div>
                @endforelse
            </div>
                </div>
            </div>

            {{-- Pagination --}}
            @if($artists->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $artists->links() }}
                </div>
            @endif
        </div>

        {{-- ============================================================ --}}
        {{-- CONFIRM DELETE MODAL --}}
        {{-- ============================================================ --}}
        <div x-data="{ open: false }"
             @open-delete-modal.window="open = true"
             x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             style="display: none;">

            <div @click="open = false" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 z-10">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Hapus Artis</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>

                <template x-if="concertCount > 0">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-5 text-sm text-yellow-800">
                        <strong x-text="deleteArtistName"></strong> terhubung dengan
                        <strong x-text="concertCount"></strong> konser.
                        Artis akan dinonaktifkan (soft delete) agar data konser lama tetap terjaga.
                    </div>
                </template>

                <template x-if="concertCount === 0">
                    <p class="text-sm text-gray-600 mb-5">
                        Apakah Anda yakin ingin menghapus artis <strong x-text="deleteArtistName"></strong>?
                    </p>
                </template>

                <div class="flex items-center justify-end gap-3">
                    <button type="button" @click="open = false"
                            class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <form :action="'/admin/artis/' + deleteArtistId" method="POST" x-ref="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition-colors">
                            <span x-text="concertCount > 0 ? 'Nonaktifkan' : 'Hapus'"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- MODAL: Tambah Artis --}}
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

            <div @click="openModal = false" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

            <div x-show="openModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto z-10">

                <div class="flex items-center justify-between px-7 py-5 border-b border-gray-100 sticky top-0 bg-white z-10">
                    <h2 class="text-lg font-bold text-gray-900">Tambah Artis Baru</h2>
                    <button @click="openModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.artists.store') }}" method="POST"
                      enctype="multipart/form-data"
                      x-data="{
                          previewUrl: '',
                          nameVal: '{{ old('name') }}',
                          handleFile(e) {
                              const file = e.target.files[0];
                              if (file) this.previewUrl = URL.createObjectURL(file);
                          },
                          generateSlug(name) {
                              return name.toLowerCase()
                                  .replace(/[^a-z0-9\s-]/g, '')
                                  .trim()
                                  .replace(/\s+/g, '-')
                                  .replace(/-+/g, '-');
                          }
                      }">
                    @csrf

                    <div class="px-7 py-6 space-y-5">

                        {{-- Foto Artis --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                Foto Artis <span class="text-red-500">*</span>
                                <span class="text-gray-400 font-normal normal-case">(JPG/PNG, maks 2 MB)</span>
                            </label>
                            <div x-show="previewUrl" class="mb-3">
                                <img :src="previewUrl" alt="Preview"
                                     class="w-24 h-24 object-cover rounded-2xl border-2 border-blue-200 shadow-sm">
                            </div>
                            <label class="flex items-center gap-3 w-full px-4 py-3 border-2 border-dashed @error('photo') border-red-400 @else border-gray-200 @enderror rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 transition-colors">
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm text-gray-500">Klik untuk upload foto artis</span>
                                <input type="file" name="photo" accept="image/jpg,image/jpeg,image/png" class="hidden" @change="handleFile($event)">
                            </label>
                            @error('photo')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nama Artis --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                Nama Artis <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="artist-name-add"
                                   value="{{ old('name') }}"
                                   x-model="nameVal"
                                   @input="$refs.slugInput.value = generateSlug(nameVal)"
                                   placeholder="Contoh: Dewa 19"
                                   class="w-full px-4 py-2.5 border @error('name') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Slug --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                Slug <span class="text-gray-400 font-normal normal-case">(auto dari nama)</span>
                            </label>
                            <input type="text" name="slug" x-ref="slugInput"
                                   value="{{ old('slug') }}"
                                   placeholder="dewa-19"
                                   class="w-full px-4 py-2.5 border @error('slug') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 font-mono">
                            @error('slug')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Genre & Asal --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">Genre</label>
                                <input type="text" name="genre" value="{{ old('genre') }}"
                                       placeholder="Contoh: Pop, Rock, Jazz"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">Asal / Kota</label>
                                <input type="text" name="origin" value="{{ old('origin') }}"
                                       placeholder="Contoh: Jakarta"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                            </div>
                        </div>

                        {{-- Instagram / Website --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                                Instagram / Website <span class="text-gray-400 font-normal normal-case">(opsional)</span>
                            </label>
                            <input type="url" name="instagram_url" value="{{ old('instagram_url') }}"
                                   placeholder="https://instagram.com/artis"
                                   class="w-full px-4 py-2.5 border @error('instagram_url') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                            @error('instagram_url')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Status</label>
                            <div class="flex items-center gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="is_active" value="1"
                                           {{ old('is_active', '1') === '1' ? 'checked' : '' }}
                                           class="text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-700">Aktif</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="is_active" value="0"
                                           {{ old('is_active') === '0' ? 'checked' : '' }}
                                           class="text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-700">Nonaktif</span>
                                </label>
                            </div>
                        </div>

                    </div>

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
                            Simpan Artis
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>{{-- end x-data --}}
</x-admin-layout>
