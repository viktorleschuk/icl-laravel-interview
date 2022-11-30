<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            <!-- Post preview-->
            <div class="post-preview">
                <a href="#">
                    <h2 class="post-title">{{ $post->title }}</h2>

                    <div class="row justify-content-center mt-4 mb-4">
                        <div class="col-12">
                            @if($post->image)
                            <img src="{{ Storage::url($post->image) }}" class="rounded mx-auto d-block img-thumbnail">
                            @else
                                <img src="/images/post-image-placeholder.png" class="rounded mx-auto d-block img-thumbnail">
                            @endif
                        </div>
                    </div>

                    <h3 class="post-subtitle">{{ $post->body }}</h3>
                </a>
                <p class="post-meta">
                    Posted by
                    <a href="#">Admin</a>
                    on {{ $post->created_at }}
                </p>
                <p class="post-meta">
                    Kategoria: Nazwa
                </p>
                <p class="post-meta">
                    @foreach ($post->tags as $singleTag)
                        <span class="label label-info label-many badge bg-secondary">{{ $singleTag->name }}</span>
                    @endforeach
                </p>
            </div>

            <hr class="my-4" />
            <!-- Pager-->
            <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="{{ route('post.list') }}">Powrót →</a></div>
        </div>
    </div>
</div>
