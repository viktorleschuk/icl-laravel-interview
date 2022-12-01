<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Str;

class PostHandlerService
{
    protected ImageHandlerService $imageHandlerService;

    public function __construct(ImageHandlerService $imageHandlerService)
    {
        $this->imageHandlerService = $imageHandlerService;
    }

    public function storePost($data, $image): Post
    {
        $data['image'] = $this->imageHandlerService->storeImage($image);

        $post = new Post();

        return $this->fillPostWithData($post, $data);
    }

    public function updatePost($post, $data, $image)
    {
        $data['image'] = $this->imageHandlerService->storeImage($image);

        return $this->fillPostWithData($post, $data);
    }

    protected function fillPostWithData($post, $data)
    {
        $post->title = $data['title'];
        $post->slug = Str::slug($data['title']);
        $post->description = $data['description'];
        $post->body = $data['body'];
        $post->category_id = $data['category_id'];
        $post->image = $data['image'];

        $post->save();

        $post->tags()->attach($data['tags']);

        return $post;
    }


}
