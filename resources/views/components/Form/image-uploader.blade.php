@props([
    'name',
    'label',
    'multiple' => false,
    'required' => false,
    'helper' => 'PNG, JPG atau WebP (Maks. 2MB)',
    'id' => null
])

@php
    $id = $id ?? $name;
@endphp

<div class="space-y-4" x-data="imageUploader('{{ $id }}', {{ $multiple ? 'true' : 'false' }})">
    <div class="flex items-center justify-between">
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $label }} {!! $required ? '<span class="text-red-500">*</span>' : '' !!}</label>
        <span class="text-[10px] text-gray-300 font-bold uppercase tracking-wider" x-text="countText"></span>
    </div>

    <div 
        @dragover.prevent="isDragging = true" 
        @dragleave.prevent="isDragging = false" 
        @drop.prevent="handleDrop($event)"
        :class="{'border-[#FF7304] bg-orange-50': isDragging, 'border-gray-100 dark:border-dark-border bg-gray-50 dark:bg-[#121212]': !isDragging}"
        class="relative min-h-[160px] rounded-3xl border-2 border-dashed flex flex-col items-center justify-center transition-all cursor-pointer group hover:border-[#FF7304] hover:bg-orange-50 dark:hover:bg-[#2A2A2A]/30">
        
        <input 
            type="file" 
            name="{{ $name }}{{ $multiple ? '[]' : '' }}" 
            id="{{ $id }}" 
            @change="handleFileSelect($event)"
            class="absolute inset-0 opacity-0 cursor-pointer z-10"
            {{ $multiple ? 'multiple' : '' }}
            {{ $required ? 'required' : '' }}
            accept="image/jpeg,image/png,image/webp">

        <div class="flex flex-col items-center text-center p-6 space-y-2 pointer-events-none">
            <div class="w-12 h-12 bg-white dark:bg-dark-card rounded-2xl flex items-center justify-center text-gray-300 group-hover:text-[#FF7304] shadow-sm transition-color transition-colors duration-300s">
                <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
            </div>
            <div>
                <p class="text-[11px] font-black text-gray-800 dark:text-white uppercase tracking-widest">Tarik Gambar atau Klik</p>
                <p class="text-[10px] text-gray-400 font-medium mt-1">{{ $helper }}</p>
            </div>
        </div>

        <!-- Upload Progress Indicator -->
        <div x-show="isUploading" class="absolute bottom-0 left-0 right-0 p-4 z-20">
            <div class="bg-white dark:bg-dark-card/90 backdrop-blur rounded-xl p-3 shadow-lg border border-orange-100 transition-colors duration-300">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[9px] font-black text-[#FF7304] uppercase tracking-widest">Memproses Gambar...</span>
                    <span class="text-[9px] font-black text-[#FF7304]" x-text="progress + '%'"></span>
                </div>
                <div class="w-full bg-orange-50 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-[#FF7304] h-full transition-all duration-300" :style="'width: ' + progress + '%'"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Grid -->
    <template x-if="previews.length > 0">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <template x-for="(preview, index) in previews" :key="index">
                <div class="relative aspect-square rounded-2xl overflow-hidden border border-gray-100 dark:border-dark-border group shadow-sm">
                    <img :src="preview" class="w-full h-full object-cover">
                    <button 
                        @click.prevent="removeImage(index)"
                        class="absolute top-2 right-2 w-6 h-6 bg-red-500 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:scale-110 active:scale-90">
                        <i class="fa-solid fa-xmark text-[10px]"></i>
                    </button>
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                </div>
            </template>
        </div>
    </template>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('imageUploader', (inputId, isMultiple) => ({
        isDragging: false,
        isUploading: false,
        progress: 0,
        previews: [],
        files: [],
        
        get countText() {
            if (!this.previews.length) return '';
            return isMultiple ? `${this.previews.length} File Terpilih` : 'Terpilih';
        },

        handleFileSelect(event) {
            this.processFiles(event.target.files);
        },

        handleDrop(event) {
            this.isDragging = false;
            this.processFiles(event.dataTransfer.files);
        },

        processFiles(newFiles) {
            if (!newFiles.length) return;
            
            this.isUploading = true;
            this.progress = 0;

            // Simulate progress
            let interval = setInterval(() => {
                this.progress += 10;
                if (this.progress >= 100) {
                    clearInterval(interval);
                    setTimeout(() => {
                        this.isUploading = false;
                        
                        Array.from(newFiles).forEach(file => {
                            if (!file.type.match('image.*')) return;
                            if (file.size > 2 * 1024 * 1024) {
                                alert('Ukuran file ' + file.name + ' terlalu besar (Maks 2MB)');
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = (e) => {
                                if (isMultiple) {
                                    this.previews.push(e.target.result);
                                } else {
                                    this.previews = [e.target.result];
                                }
                            };
                            reader.readAsDataURL(file);
                        });
                    }, 500);
                }
            }, 50);
        },

        removeImage(index) {
            this.previews.splice(index, 1);
            // Note: Actual removal from input file is complex if multiple, 
            // usually handled by creating a new DataTransfer object
        }
    }));
});
</script>
