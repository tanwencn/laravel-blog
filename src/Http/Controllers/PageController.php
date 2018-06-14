<?php

namespace Tanwencn\Blog\Http\Controllers;

use Tanwencn\Blog\Database\Eloquent\Page;
use Tanwencn\Blog\Http\Resources\ContentResource;

class PageController extends Controller
{
    use ContentResource;

    protected $model = Page::class;
}
