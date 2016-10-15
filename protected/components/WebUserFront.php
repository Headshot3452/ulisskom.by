<?php
    /**
     * @property $language language code
     * @property $language_id
     */
    class WebUserFront extends CWebUser
    {
        private $_model = null;
        private $_user;

        public function getRole()
        {
            if($user = $this->getModel())
            {
                return $user->role;
            }
        }

        public function getUser()
        {
            if ($this->_user == null)
            {
                $this->_user = Users::model()->findByPk($this->id);
            }
            return $this->_user;
        }

        public function getModel()
        {
            if (!$this->isGuest && $this->_model === null)
            {
                $this->_model = Users::model()->active()->findByPk($this->id, array('select' => 'role'));
            }
            return $this->_model;
        }

        public function afterLogin($fromCookie)
        {
            $event = new CModelEvent($this);
            $this->onLogin($event);
        }

        public function onLogin($event)
        {
            $this->raiseEvent('onLogin', $event);
        }

        public function issetCaptcha()
        {
            return $this->getState('captcha', false);
        }

        public function addCaptcha()
        {
            $this->setState('captcha', true);
        }

        public function removeCaptcha()
        {
            $this->setState('captcha', false);
        }
    }