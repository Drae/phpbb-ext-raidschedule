<?php
/**
 *
 * This file is part of the phpBB Forum Software package.
 *
 * @copyright (c) phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * For full copyright and license information, please see
 * the docs/CREDITS.txt file.
 *
 */

namespace numeric\raidschedule\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	/* @var \phpbb\controller\helper */
	protected $helper;

	protected $template;

	/**
	* Constructor
	*
	* @param \phpbb\controller\helper	$helper		Controller helper object
	*/
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template)
	{
		$this->helper = $helper;
		$this->template = $template;
	}

	/**
	*
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions' => 'wire_permissions',
			'core.user_setup' => 'load_language_on_setup',
			'core.page_header' => 'page_header',
		);
	}

	/**
	*
	*/
	public function wire_permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_cal_sign'] = array('lang' => 'ACL_U_CAL_SIGN', 'cat' => 'misc');
		$permissions['u_cal_select'] = array('lang' => 'ACL_U_CAL_SELECT', 'cat' => 'misc');
		$permissions['a_cal_create'] = array('lang' => 'ACL_A_CAL_CREATE', 'cat' => 'misc');
		$permissions['a_cal_delete'] = array('lang' => 'ACL_A_CAL_DELETE', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

	public function load_language_on_setup($event)
    {
        $lang_set_ext = $event['lang_set_ext'];
        $lang_set_ext[] = array(
            'ext_name' => 'numeric/raidschedule',
            'lang_set' => 'common',
        );
        $event['lang_set_ext'] = $lang_set_ext;
	}

	public function page_header($event)
	{
		$this->template->assign_vars(array(
			'U_SCHEDULE' => $this->helper->route('numeric_raidschedule_controller__no_rid'),
		));
	}
}
