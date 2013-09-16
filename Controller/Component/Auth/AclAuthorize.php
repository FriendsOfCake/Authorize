<?php
App::uses('BaseAuthorize', 'Controller/Component/Auth');
App::uses('Router', 'Routing');

/**
 * An authorization adapter for AuthComponent.  Provides the ability to
 * authorize using row based CRUD mappings. CRUD mappings allow you to translate
 * controller actions into *C*reate *R*ead *U*pdate *D*elete actions.
 * This is then checked in the AclComponent as specific permissions.
 *
 * For example, taking `/posts/view/1` as the current request.  The default
 * mapping for `view`, is a `read` permission check. The Acl check would then be
 * for the Post record with id=1 with the `read` permission.  This allows you to
 * create permission systems that focus more on what is being done to which
 * record, rather than the specific actions being visited, or only what is being
 * done to resources.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 */
class AclAuthorize extends BaseAuthorize {

/**
 * Sets up additional actionMap values that match the configured
 * `Routing.prefixes`.
 *
 * @param ComponentCollection $collection The component collection from the
 * controller.
 * @param string $settings An array of settings.  This class does not use any
 * settings.
 */
	public function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
		$this->_setPrefixMappings();
	}

/**
 * sets the crud mappings for prefix routes.
 *
 * @return void
 */
	protected function _setPrefixMappings() {
		$crud = array('create', 'read', 'update', 'delete');
		$map = array_combine($crud, $crud);

		$prefixes = Router::prefixes();
		if (!empty($prefixes)) {
			foreach ($prefixes as $prefix) {
				$map = array_merge($map, array(
					$prefix . '_index' => 'read',
					$prefix . '_add' => 'create',
					$prefix . '_edit' => 'update',
					$prefix . '_view' => 'read',
					$prefix . '_remove' => 'delete',
					$prefix . '_create' => 'create',
					$prefix . '_read' => 'read',
					$prefix . '_update' => 'update',
					$prefix . '_delete' => 'delete'
				));
			}
		}
		$this->mapActions($map);
	}

/**
 * Authorize a user using the mapped actions and the AclComponent.
 *
 * @param array $user The user to authorize
 * @param CakeRequest $request The request needing authorization.
 * @return boolean
 * @throws CakeException
 */
	public function authorize($user, CakeRequest $request) {
		if (!isset($this->settings['actionMap'][$request->params['action']])) {
			throw new CakeException(__d('cake_dev',
				'AclAuthorize::authorize() - Attempted access of un-mapped action "%1$s" in controller "%2$s"',
				$request->action,
				$request->controller
			));
		}

		if (empty($request->params['pass'][0])) {
			return false;
		}
		$user = array($this->settings['userModel'] => $user);
		$acoNode = $this->_getAco($request->params['pass'][0]);

		$Acl = $this->_Collection->load('Acl');
		return $Acl->check(
			$user,
			$acoNode,
			$this->settings['actionMap'][$request->params['action']]
		);
	}

/**
 * Builds acoNode for Acl->check()
 *
 * @param integer $id The passed id param
 * @return array
 */
	protected function _getAco($id) {
		$modelClass = $this->_Controller->modelClass;
		return array('model' => $modelClass, 'foreign_key' => $id);
	}

}
