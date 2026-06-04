<x-admin-layout title="Edit Artis">

    {{-- Back button --}}
    <div class="mb-6">
        <a href="{{ route('admin.artists.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Artis
        </a>
    </div>

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

        {{-- FORM EDIT --}}
        <div class="lg:col-span-2">
            <form action="{{ route('admin.artists.update', $artist) }}" method="POST"
                  enctype="multipart/form-data"
                  x-data="{
                      previewUrl: '{{ $artist->image_url ? Storage::url($artist->image_url) : '' }}',
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
                @method('PUT')

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7 space-y-5">
                    <h2 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-4">Detail Artis</h2>

                    {{-- Foto Upload --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                            Foto Artis <span class="text-gray-400 font-normal normal-case">(opsional, ganti foto lama)</span>
                        </label>
                        <div x-show="previewUrl" class="mb-3">
                            <img :src="previewUrl" alt="Preview foto artis"
                                 class="w-24 h-24 object-cover rounded-2xl border-2 border-blue-200 shadow-sm">
                        </div>
                        <label class="flex items-center gap-3 w-full px-4 py-3 border-2 border-dashed @error('photo') border-red-400 @else border-gray-200 @enderror rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 transition-colors">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm text-gray-500">Klik untuk upload foto baru (JPG, PNG)</span>
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
                        <input type="text" name="name"
                               value="{{ old('name', $artist->name) }}"
                               @input="$refs.slugInput.value = generateSlug($event.target.value)"
                               placeholder="Nama artis"
                               class="w-full px-4 py-2.5 border @error('name') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">Slug</label>
                        <input type="text" name="slug" x-ref="slugInput"
                               value="{{ old('slug', $artist->slug) }}"
                               class="w-full px-4 py-2.5 border @error('slug') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 font-mono">
                        @error('slug')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Genre & Asal --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">Genre</label>
                            <input type="text" name="genre"
                                   value="{{ old('genre', $artist->genre) }}"
                                   placeholder="Pop, Rock, Jazz..."
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">Asal / Kota</label>
                            <input type="text" name="origin"
                                   value="{{ old('origin', $artist->origin) }}"
                                   placeholder="Jakarta, Bandung..."
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                        </div>
                    </div>

                    {{-- Instagram / Website --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">
                            Instagram / Website <span class="text-gray-400 font-normal normal-case">(opsional)</span>
                        </label>
                        <input type="url" name="instagram_url"
                               value="{{ old('instagram_url', $artist->instagram_url) }}"
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
                                       {{ old('is_active', $artist->is_active ? '1' : '0') === '1' ? 'checked' : '' }}
                                       class="text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Aktif</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="0"
                                       {{ old('is_active', $artist->is_active ? '1' : '0') === '0' ? 'checked' : '' }}
                                       class="text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Nonaktif</span>
                            </label>
                        </div>
                    </div>

                </div>

                {{-- Submit --}}
                <div class="flex items-center justify-end gap-3 mt-6">
                    <a href="{{ route('admin.artists.index') }}"
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

        {{-- SIDEBAR INFO --}}
        <div class="space-y-6">
            {{-- Current Photo --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-900 mb-3">Foto Saat Ini</h3>
                @if($artist->image_url)
                    <img src="{{ Storage::url($artist->image_url) }}"
                         alt="{{ $artist->name }}"
                         class="w-full aspect-square object-cover rounded-xl border border-gray-200">
                @else
                    <div class="w-full aspect-square bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-16 h-16 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-2">Belum ada foto</p>
                @endif
            </div>

            {{-- Artist Info --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">
                <h3 class="text-sm font-bold text-blue-800 mb-3">Informasi</h3>
                <ul class="space-y-2 text-xs text-blue-700">
                    <li class="flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Artis ini terhubung ke
                        <strong>{{ $artist->concerts()->count() }} konser</strong>.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Upload foto baru akan menggantikan foto lama.
                    </li>
                </ul>
            </div>
        </div>

    </div>
</x-admin-layout>
