<?php
	/**
	 * @example $dialog = new La\Dialog();
	 */
	namespace La
	{
		/**
		 * Class to create GtkMessageDialog using the namespace La
		 * You can use to create alerts and get the answer, if exist
		 * 
		 * @author Renato Cassino - Labanca Framework
		 */
		class Dialog extends \GtkMessageDialog
		{
			/**
			 * @property GtkWindow $parent - declare a GtkWindow or null
			 */
			public $parent = null;

			/**
			 * @property int flag
			 * @example: Gtk::DIALOG_MODAL || Gtk::DIALOG_DESTROY_WITH_PARENT
			 */
			public $flag = \Gtk::DIALOG_MODAL;

			/**
			 * @property int $type_alert
			 * @example:
			 * 	0	Gtk::MESSAGE_INFO - Informational message
			 * 	1	Gtk::MESSAGE_WARNING - Nonfatal warning message
			 *	2	Gtk::MESSAGE_QUESTION - Question requiring a choice
			 *	3	Gtk::MESSAGE_ERROR - Fatal error message
			 */
			public $type_alert = 1;

			/**
			 * @property int $buttons;
			 * @example:
			 *	0	Gtk::BUTTONS_NONE - No buttons at all.
			 *	1	Gtk::BUTTONS_OK - An OK button.
			 *	2	Gtk::BUTTONS_CLOSE - A Close button.
			 *	3	Gtk::BUTTONS_CANCEL - A Cancel button.
			 *	4	Gtk::BUTTONS_YES_NO - Yes and No buttons.
			 *	5	Gtk::BUTTONS_OK_CANCEL - OK and Cancel buttons.
			 */
			public $buttons = 1;

			/**
			 * @property string $message
			 */
			public $message = '';	

			/**
			 * @property int $_answer - Callback from the function
			 * @example:
			 * 	Gtk::RESPONSE_YES - If the user click on Yes
			 * 	Gtk::RESPONSE_NO - If the user click on No
			 */
			private $_answer = NULL;

			public function __construct() {}

			/**
			 * Method to create an Error Dialog
			 * @property string $message
			 * @property bool $autorun
			 */
			public function error($message,$autorun = false)
			{
				$this->message = $message;
				$this->type_alert = \Gtk::MESSAGE_ERROR;

				return ($autorun) ? $this->run() : null;
			}

			/**
			 * Method to create an Alert Dialog
			 * @property string $message
			 * @property bool $autorun
			 */
			public function alert($message,$autorun = false)
			{
				$this->message = $message;
				$this->type_alert = \Gtk::MESSAGE_WARNING;

				return ($autorun) ? $this->run() : null;
			}

			/**
			 * Method to create an Info Dialog
			 * @property string $message
			 * @property bool $autorun
			 */
			public function info($message,$autorun = false)
			{
				$this->message = $message;
				$this->type_alert = \Gtk::MESSAGE_INFO;

				return ($autorun) ? $this->run() : null;
			}

			/**
			 * Method to create a Dialog withou image on left
			 * @property string $message
			 * @property bool $autorun
			 */
			public function alert_without_image($message,$autorun = false)
			{
				$this->message = $message;
				$this->type_alert = 4;

				return ($autorun) ? $this->run() : null;
			}

			/**
			 * Render the dialog
			 * @return int $_answer
			 */
			public function run()
			{
				parent::__construct($this->parent,$this->flag,$this->type_alert,$this->buttons,$this->message);
				parent::set_markup($this->message);

				$this->__return = parent::run();
				parent::destroy();

				// The answer
				return $this->__return;
			}
		}
	}
?>
