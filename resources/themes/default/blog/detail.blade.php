@extends('app')

@section('title'){{ $model->title }}@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">{{ __('Blog') }}</a></li>
    <li class="breadcrumb-item active">{{ $model->title }}</li>
@endsection

@section('content')
    <!-- LEFT COLUMN _________________________________________________________-->
        <div id="blog-post" class="col-md-9">
            <p class="text-muted text-uppercase mb-small text-right text-sm">{{ $model->created_at->format('m-d, Y') }}</p>
            <p class="lead">{{ $model->excerpt }}</p>
            <div id="post-content">
                {!! $model->description !!}
            </div>
            <div id="comment_list">
                <h4 class="text-uppercase">{{ $comments->total() }} {{__('Comments')}}</h4>
                @php
                    $replyHistory = function($comment)use(&$replyHistory){
                        if(!empty($comment->parent)){
                            echo ' //@'.$comment->parent->user->name().':'.$comment->parent->message;
                            $replyHistory($comment->parent);
                        }
                    }
                @endphp
                @foreach ($comments as $comment)
                    <div class="row comment @if ($loop->last) last @endif">
                        <div class="col-sm-3 col-md-1 text-center-xs">
                            <p><img src="{{ $comment->user->avatar }}" alt="" class="img-fluid rounded-circle"></p>
                        </div>
                        <div class="col-sm-9 col-md-10">
                            <h5 class="text-uppercase">{{ $comment->user->name }}</h5>
                            <p class="posted"><i class="fa fa-clock-o"></i> {{ $comment->created_at->format('m-d H:i:s, Y') }}</p>
                            <p>{{ $comment->message }} {{ $replyHistory($comment) }}</p>
                            <p class="reply"><a href="javascript:;"><i class="fa fa-reply"></i> 回复</a></p>
                            <form method="post" action="{{ route('comments.submit') }}" style="display: none">
                                {{ csrf_field() }}
                                {{ comments_target($model) }}
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="message" rows="4" class="form-control">{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <button class="btn btn-template-outlined"><i class="fa fa-comment-o"></i> 提交评论</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach

                <nav aria-label="Page navigation example">
                    {{ $comments->links(null, ['size' => 'sm']) }}
                </nav>
            </div>
            <div id="comment">
                @foreach($errors->all() as $message)
                <div role="alert" class="alert alert-danger">
                    {{ $message }}
                </div>
                @endforeach
                <h4 class="text-uppercase">{{ __('Leave a Reply') }}</h4>
                    @auth
                        <form method="post" action="{{ route('comments.submit') }}">
                            {{ csrf_field() }}
                            {{ comments_target($model) }}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea name="message" rows="4" class="form-control">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <button class="btn btn-template-outlined"><i class="fa fa-comment-o"></i> {{ __('Post Comment') }}</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div role="alert" class="alert alert-info">{{ __('Please login to comment') }}. <a href="{{ route('login') }}">{{ __('Log In') }}</a></div>
                    @endauth
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default sidebar-menu">
                <div class="panel-heading">
                    <h3 class="h4 panel-title">{{ __('Related Categories') }}</h3>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-pills flex-column text-sm">
                        @foreach($model->categories as $category)
                            <li class="nav-item"><a href="{{ route('posts.index', ['category' => $category->id]) }}" class="nav-link">{{ $category->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="panel sidebar-menu">
                <div class="panel-heading">
                    <h3 class="h4 panel-title">{{ __('Related Tags') }}</h3>
                </div>
                <div class="panel-body">
                    <ul class="tag-cloud list-inline">
                        @foreach($model->tags as $tag)
                            <li class="list-inline-item"><a href="{{ route('posts.index', ['tag' => $tag->id]) }}"><i class="fa fa-tags"></i> {{ $tag->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
    <script>
        $(function(){
            $('.reply').click(function(){
                $(this).next().fadeToggle();
            });
        });
    </script>
@endpush