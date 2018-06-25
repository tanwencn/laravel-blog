<?php

namespace Tanwencn\Blog\Http\Controllers;

use Tanwencn\Blog\Database\Eloquent\Post;
use Tanwencn\Blog\Http\Resources\ContentResource;

class PostController extends Controller
{
    use ContentResource;

    protected $model = Post::class;
}
