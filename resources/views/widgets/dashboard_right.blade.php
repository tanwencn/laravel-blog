<div class="col-lg-6 col-xs-12" style="padding-left: 0;">
    <!-- small box -->
    <div class="small-box bg-yellow">
        <div class="inner">
            <h3>{{ $users_count }}</h3>

            <p>{{ trans_choice('admin.user', 1) }}</p>
        </div>
        <div class="icon">
            <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer">{{ trans('admin.more') }} <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./col -->
<div class="col-lg-6 col-xs-12" style="padding-right: 0">
    <!-- small box -->
    <div class="small-box bg-red">
        <div class="inner">
            <h3>{{ $comments_count }}</h3>

            <p>{{ trans_choice('admin.comment', 1) }}</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">{{ trans('admin.more') }} <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
