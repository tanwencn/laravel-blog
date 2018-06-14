<?php

namespace Tanwencn\Blog\Widgets;

use Arrilot\Widgets\AbstractWidget;

class MenuSideWidget extends AbstractWidget
{
    static $names;
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    public function __construct(array $config = [])
    {
        $this->addConfigDefaults([
            'is_tree' => false
        ]);

        parent::__construct($config);
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run($name, $class)
    {
        static::$names[$class] = $name;

        $data = $this->config['is_tree'] ? ($class::tree()->get()) : ($class::all());

        $class_name = class_basename($class);

        return view('tanwencms::admin.widgets.menu_setting', compact('data', 'name', 'class_name', 'class'));
    }

    public static function getName($class=null){
        if($class){
            return isset(static::$names[$class])?static::$names[$class]:null;
        }else{
            return static::$names;
        }
    }
}
