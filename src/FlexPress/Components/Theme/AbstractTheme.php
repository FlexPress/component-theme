<?php

namespace FlexPress\Components\Theme;

use FlexPress\Components\Routing\Router;
use FlexPress\Components\Hooks\Hooker;
use FlexPress\Components\Templating\Functions As TemplateFunctions;
use FlexPress\Components\Taxonomy\Helper As TaxonomyHelper;
use FlexPress\Components\PostType\Helper As PostTypeHelper;
use FlexPress\Components\ACF\Helper as ACFHelper;
use FlexPress\Components\Shortcode\Helper as ShortcodeHelper;
use FlexPress\Components\ImageSize\Helper as ImageSizesHelper;

abstract class AbstractTheme
{

    /**
     * @var string
     */
    protected $themePath;

    /**
     * @var string
     */
    protected $themeURL;

    /**
     * @var \Pimple
     */
    protected $pimple;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Hooker
     */
    protected $hooker;

    /**
     * @var TaxonomyHelper
     */
    protected $taxonomyHelper;

    /**
     * @var PostTypeHelper
     */
    protected $postTypeHelper;

    /**
     * @var ACFHelper
     */
    protected $fieldsHelper;

    /**
     * @var TemplatingFunctions
     */
    protected $templateFunctions;

    /**
     * @var ShortocodeHelper
     */
    protected $shortcodeHelper;

    /**
     * @var ImageSizesHelper
     */
    protected $imageSizesHelper;

    /**
     * Uses constructor injection to deal with all the dependencies
     *
     * @param \Pimple $pimple
     * @param Router $router
     * @param Hooker $hooker
     * @param TemplateFunctions $templateFunctions
     * @param TaxonomyHelper $taxonomyHelper
     * @param PostTypeHelper $postTypeHelper
     * @param ACFHelper $fieldsHelper
     * @param ShortcodeHelper $shortcodeHelper
     * @param ImageSizesHelper $imageSizesHelper
     *
     * @author Tim Perry
     */
    public function __construct(
        \Pimple $pimple,
        Router $router,
        Hooker $hooker,
        TemplateFunctions $templateFunctions,
        TaxonomyHelper $taxonomyHelper,
        PostTypeHelper $postTypeHelper,
        ACFHelper $fieldsHelper,
        ShortcodeHelper $shortcodeHelper,
        ImageSizesHelper $imageSizesHelper
    ) {

        $this->pimple = $pimple;
        $this->router = $router;
        $this->hooker = $hooker;
        $this->templateFunctions = $templateFunctions;
        $this->taxonomyHelper = $taxonomyHelper;
        $this->postTypeHelper = $postTypeHelper;
        $this->fieldsHelper = $fieldsHelper;
        $this->shortcodeHelper = $shortcodeHelper;
        $this->imageSizesHelper = $imageSizesHelper;

    }

    /**
     * For the given theme path, it sets up the theme
     *
     * @param $themePath
     * @return $this
     * @author Tim Perry
     */
    public function init($themePath)
    {
        $this->themePath = $themePath;
        $this->themeURL = get_bloginfo('url');

        add_action('after_setup_theme', array($this, 'afterSetupTheme'));
        add_action('wp', array($this, 'wp'));

    }

    /**
     *
     * Called after the theme is setup, allows us to setup hooks
     * post types, taxonomies etc
     *
     * @author Tim Perry
     *
     */
    public function afterSetupTheme()
    {
        $this->imageSizesHelper->registerImageSizes();
        $this->postTypeHelper->registerPostTypes();
        $this->taxonomyHelper->registerTaxonomies();
        $this->fieldsHelper->registerFieldGroups();
        $this->hooker->hookUp();
        $this->shortcodeHelper->registerShortcodes();

    }

    /**
     *
     * Called when the wp object is setup, so we can route properly
     *
     * @author Tim Perry
     *
     */
    public function wp()
    {
        $this->setupRoutes();
        $this->router->route();
    }

    /**
     * Returns the path to the theme folder
     *
     * @return string
     * @author Tim Perry
     */
    public function getThemePath()
    {
        return $this->themePath;
    }

    /**
     * Gets the theme url
     *
     * @return string
     * @author Tim Perry
     */
    public function getThemeURL()
    {
        return $this->themeURL;
    }

    /**
     * Gets the Dependency Injection Container for the theme
     *
     * @return \Pimple
     * @author Tim Perry
     */
    public function getDIC()
    {
        return $this->pimple;
    }

    /**
     * Used to add routes to the theme
     *
     * @return mixed
     * @author Tim Perry
     */
    abstract protected function setupRoutes();

}
