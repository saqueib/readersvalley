<div class="story-list">
    @foreach($posts as $key => $post)
        <div class="story my-6 pb-4">

            @if(!isset($noThumb) || !$noThumb)
                <a class="block ml-3 w-32 h-32 bg-grey-light float-right no-underline" href="">
                    <img class="h-32" src="{{ $post->featured_image }}" alt="">
                </a>
            @endif

            <h4 class="text-2xl  mb-4">
                @if(isset($countIt))<span class="font-serif text-grey italic text-3xl">{{ $key + 1 }}</span>@endif
                <a class="text-black no-underline" href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
            </h4>

            @if(!isset($noThumb))
                <div class="text-grey-darker leading-normal mb-3">
                    {{ str_limit(strip_tags($post->body), 200) }}
                </div>
            @endif

            <p class="story-cat mb-2 text-grey-dark">
                By <a class="text-black no-underline hover:underline" href="">
                    {{ $post->user->name }}
                </a>
                in
                <a class="text-black no-underline hover:underline" href="">
                    {{ $tag->name }}
                </a>
            </p>

            <p class="story-time text-sm text-grey-dark">
                {{ $post->published_at->toFormattedDateString() }}
                &bull; {{ $post->read_time }}
            </p>
        </div>
    @endforeach
</div>
