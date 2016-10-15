<?php
class UserIdentity extends CUserIdentity
{
    private $_id;

    public function authenticate()
    {
        $record = Users::model()->findByAttributes(array('email'=>$this->username),array('select'=>'id,email,password,status'));
        if($record===null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if(!$record->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else if($record->status != Users::STATUS_OK)
           $this->errorCode = '3';
        else
        {
            $this->_id = $record->id;
            $this->setState('login', $record->email);
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}
?>
