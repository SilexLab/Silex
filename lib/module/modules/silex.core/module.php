<?php
class silex_core implements IModule {
	protected $template = null;
	protected $user = null;
	protected $page = null;
	protected $style = null;
	protected $navigation = null;

	public function __construct() {
		// Something what is to do when module object is created (not registered!)
	}

	public function register() {
		/* do all the stuff */
		// User and session stuff
		Session::start();

		LoginCheck::init();
		$this->user = LoginCheck::getUser(); // TODO: change this

		// Initiate language
		Language::init();

		// Check URL
		URL::check();

		// Navigation
		$this->navigation = new NavigationFactory();

		// Initiate page
		PageFactory::init();
		$this->page = PageFactory::getPage();

		// Style
		$styleFactory = new StyleFactory();
		$this->style = $styleFactory->getStyle();


		// Initiate templates
		Template::init(DTPL, !Silex::isDebug());
		$this->page->prepare();
		$this->navigation->prepare();

		Event::fire('silex.construct.before_template_assign');
		// Assign some default template variables
		$this->page->assignTemplate();
		$this->style->assignTemplate();
		$this->navigation->assignTemplate();
		$this->user->assignTemplate();
		Language::assignTemplate();

		$baseURL = Config::get('url.base');
		$assetsURL = Config::get('url.assets');
		Template::assign([
			'DEBUG' => DEBUG,
			'url'   => [
				'base'  => $baseURL,
				'asset' => $assetsURL ? $assetsURL : $baseURL.RASSET,
				'tpl'   => $baseURL.RTPL,
				'style' => $baseURL.RSTYLE
			]
		]);

		// Display template
		if (true) {
			Event::fire('silex.construct.before_display');
			header('Content-Type: text/html; charset=utf-8');
			Template::display('root.tpl');
		}
	}

	public function getParents() {
		return null;
	}

	public function getPriority() {
		return 1;
	}

	public function getModuleGroup() {
		return null;
	}

	/**
	 * Get the methods wich are called in Silex provided by this module
	 * called by __callStatic() in Silex (Silex::MethodName()->[...])
	 * @return array
	 */
	public function getMethods() {
		return ['getUser', 'getPage', 'getNav', 'getStyle'];
	}

	/**
	 * This handle and call requested methods
	 * @param  string $name
	 * @param  array  $args
	 * @return mixed
	 */
	public function callMethod($name, $args) {
		if (in_array($name, ['getUser', 'getPage', 'getStyle']))
			return $this->{strtolower(preg_replace('/^get(.*)$/', '$1', $name))};
		if (method_exists($this, $name))
			return call_user_func_array([$this, $name], $args);
	}

	/**
	 * @return Navigation
	 */
	public function getNav() {
		return $this->navigation;
	}
}
