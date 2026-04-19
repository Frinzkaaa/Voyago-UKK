<div class="relative overflow-hidden rounded-3xl h-full min-h-[400px] group shadow-2xl transition-all duration-500">
    <!-- Background Image -->
    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80" 
         alt="Explore Bali"
         class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent transition-opacity duration-300 group-hover:opacity-90"></div>
    
    <!-- Content Overlay -->
    <div class="relative h-full p-8 flex flex-col justify-end items-start gap-4 text-white">
        <!-- Badge -->
        <span class="bg-orange-500/90 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-[2px] shadow-lg">
            Special Promo
        </span>

        <!-- Title & Description -->
        <div class="space-y-2">
            <h2 class="text-3xl font-black leading-[1.1] tracking-tighter uppercase italic">
                Explore <br> <span class="text-orange-400 text-4xl">The Paradise</span>
            </h2>
            <p class="text-xs text-gray-200/90 leading-relaxed font-medium max-w-[200px]">
                Dapatkan paket liburan eksklusif mulai dari <b>Rp 1.5jt-an</b> hanya di Voyago.
            </p>
        </div>
        
        <!-- Button -->
        <a href="{{ route('booking.page') }}" 
           class="w-full mt-2 bg-white text-orange-600 px-6 py-4 rounded-2xl font-extrabold text-sm shadow-2xl shadow-orange-600/40 transform active:scale-95 transition-all duration-300 hover:bg-orange-50 uppercase tracking-wider text-center block">
            Plan Your Trip
        </a>

        <!-- Small Footer Info -->
        <div class="flex items-center gap-2 mt-2 opacity-50 group-hover:opacity-100 transition-opacity">
            <div class="flex -space-x-2">
                <img src="https://i.pravatar.cc/50?u=1" class="w-5 h-5 rounded-full border border-white">
                <img src="https://i.pravatar.cc/50?u=2" class="w-5 h-5 rounded-full border border-white">
                <img src="https://i.pravatar.cc/50?u=3" class="w-5 h-5 rounded-full border border-white">
            </div>
            <span class="text-[9px] font-bold">1.2k+ Travelers joined</span>
        </div>
    </div>
</div>  