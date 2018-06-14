<?php

namespace Tanwencn\Blog\Widgets;

use Arrilot\Widgets\AbstractWidget;

class AssetWidget extends AbstractWidget
{
    public function __construct($config)
    {
        $this->addConfigDefaults([
            'is_file' => true
        ]);
        parent::__construct($config);
    }


    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run($type, $content)
    {
        $is_file = $this->config['is_file'];

        return view('tanwencms::admin.widgets.asset', compact('type', 'content', 'is_file'));
    }
}
