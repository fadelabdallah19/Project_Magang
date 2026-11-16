<div class="mx-[26px] mt-4 mb-[26px] max-[800px]:mx-[18px] max-[560px]:mx-4 max-[560px]:mb-4">
    @if ($paginator->hasPages())
        <div class="flex flex-col items-center justify-between gap-3 border-t border-[#D9E1EB] pt-4 sm:flex-row">
            <p class="text-[12px] text-[#6D7B90]">
                Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
            </p>

            <div class="flex flex-wrap items-center gap-[6px]">
                @if ($paginator->onFirstPage())
                    <span class="inline-flex h-[32px] items-center rounded-[8px] border border-[#E5E7EB] px-[10px] text-[12px] font-semibold text-[#B0B7C3]">Sebelumnya</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex h-[32px] items-center rounded-[8px] border border-[#D9E1EB] px-[10px] text-[12px] font-semibold text-[#485A70] transition-colors hover:bg-[#F4F7FB]">Sebelumnya</a>
                @endif

                @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="inline-flex h-[32px] min-w-[32px] items-center justify-center rounded-[8px] bg-[#397BD8] px-[6px] text-[12px] font-semibold text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="inline-flex h-[32px] min-w-[32px] items-center justify-center rounded-[8px] border border-[#D9E1EB] px-[6px] text-[12px] font-semibold text-[#485A70] transition-colors hover:bg-[#F4F7FB]">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex h-[32px] items-center rounded-[8px] border border-[#D9E1EB] px-[10px] text-[12px] font-semibold text-[#485A70] transition-colors hover:bg-[#F4F7FB]">Berikutnya</a>
                @else
                    <span class="inline-flex h-[32px] items-center rounded-[8px] border border-[#E5E7EB] px-[10px] text-[12px] font-semibold text-[#B0B7C3]">Berikutnya</span>
                @endif
            </div>
        </div>
    @endif
</div>