<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            @foreach($posts ?? [] as $post)
            <!-- Post preview-->
            <div class="post-preview">
                <a href=" {{ route('post.show', ['slug' => $post->slug]) }} ">
                    <h2 class="post-title">{{ $post->title }}</h2>
                    <h3 class="post-subtitle">{{ $post->description }}</h3>
                </a>
                <p class="post-meta">
                    Posted by
                    <a href="#!">Admin</a>
                    on {{ $post->created_at }} | Tags:
                    @foreach ($post->tags as $singleTag)
                        <span class="label label-info label-many badge bg-secondary">{{ $singleTag->name }}</span>
                    @endforeach
                </p>
            </div>
            <!-- Divider-->
            <hr class="my-4" />
            @endforeach
            <!-- Pager-->
            <div class="d-flex justify-content-center">{{ $posts->links() }}</div>
        </div>
    </div>
</div>
