<div class="story-author mb-6 flex justify-start align-middle">
    <a href="">
        <img class="rounded-full w-12 h-12 mr-4" src="{{ $post->user->avatar }}&s=46" alt="">
    </a>
    <div class="story-author-meta flex justify-center flex-col">
        <p class="mb-2">
            <a class="text-black no-underline text-sm" href="">{{ $post->user->name }}</a>
            <a href="" class="border rounded border-black px-2 py-1 ml-2 text-sm no-underline text-black">Follow</a>
        </p>
        <p class="text-grey-dark no-underline text-sm">
            {{ $post->published_at ? $post->published_at->toFormattedDateString() : 'Draft' }}
            &bull; {{ $post->read_time }}
        </p>
    </div>
</div>
