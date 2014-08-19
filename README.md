# FlexPress theme component

## Implement concreate class
```
class MyConcreteThemeClass extends AbstractTheme {}
```

## Implement the abstract setupRoutes() method
- Please consult the documentation for the component-routing for how to setup routes
- Here is a simple example:
```
protected function setupRoutes()
{

  // Search route
  $this->router->addRoute(
      'searchController',
      function () {
          return is_search();
      }
  );
  
}
```

## Install via Pimple
- Please note you will have to create all the components listed below in your pimple config, of which you will need to consult the corresponding components documentation.
```
$pimple["theme"] = function($c) {
  return new MyConcreateThemeClass(
    $c,
    $c['router'],
    $c['hooker'],
    $c['templatingFunctions'],
    $c['taxonomyHelper'],
    $c['postTypeHelper'],
    $c['ACFHelper'],
    $c['shortcodeHelper'],
    $c['imageSizeHelper']
  );
};
```

## Public methods

### init($themePath)
- This method, as the name suggests initialises the theme, which does the setting up of allt the hooks required to add the functionality. Use the $themePath to set the root directory of the theme:
```
// Setup in the functions.php file
$pimple['FlexPress']->init(__DIR__);
```
### afterSetupTheme()
- Used by the hook after_theme_setup, which utilised all the helpers used by the theme, such as setting up image sizes, terms and custom post types.
 
### templateInclude()
- Used by the hook template_include, which overrides the wordpress templating system in favour of the MVC with Timber/Twig setup.
 
### getThemePath()
- Getter method which returns the path to the theme.
 
### getThemeURL()
- Getter method for the theme url.

### getDIC()
- Getter method for the DIC (pimple).

## Protected methods

### setupRoutes()
- Used to setup the routes, must be implmented.

