<?php

namespace Tanwencn\Blog\Http\Controllers;

use Tanwencn\Blog\Database\Eloquent\Posts;
use Tanwencn\Blog\Http\Resources\ContentResource;

class PostsController extends Controller
{
    use ContentResource;

    protected $model = Posts::class;
}
