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
		LanguageFactory::init();

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
		$this->template = new Template(DIR_TPL, !Silex::isDebug());
		$this->page->prepare();
		$this->navigation->prepare();
		// Assign some default template variables
		Event::fire('silex.construct.before_template_assign');
		$this->template->assign([
			'DEBUG' => DEBUG,
			'page'  => $this->page->getTemplateArray(),
			'style' => $this->style->getTemplateArray(),
			'nav'   => $this->navigation->getTemplateArray(),
			'url'   => ['base' => Silex::getConfig()->get('url.base')],
			'user'  => $this->user->getTemplateArray(),
			'lang'  => Silex::getLanguage()->getTemplateArray()
		]);

		// Display template
		if(true) {
			Event::fire('silex.construct.before_display');
			header('Content-Type: text/html; charset=utf-8');
			$this->template->display('index.tpl');
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
		return ['getTemplate', 'getUser', 'getPage', 'getNav', 'getStyle'];
	}

	/**
	 * This handle and call requested methods
	 * @param  string $name
	 * @param  array  $args
	 * @return mixed
	 */
	public function callMethod($name, $args) {
		if(in_array($name, ['getTemplate', 'getUser', 'getPage', 'getStyle']))
			return $this->{strtolower(preg_replace('/^get(.*)$/', '$1', $name))};
		if(method_exists($this, $name))
			return call_user_func_array([$this, $name], $args);
	}

	/**
	 * @return Navigation
	 */
	public function getNav() {
		return $this->navigation;
	}
}
