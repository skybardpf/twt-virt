<?php
class AccessControlFilter extends CAccessControlFilter
{
	public $userComponentName = 'user';

	protected function preFilter($filterChain)
	{
		$app=Yii::app();
		$request=$app->getRequest();
		/** @var $user CWebUser */
		$user=$app->getComponent($this->userComponentName);
		$verb=$request->getRequestType();
		$ip=$request->getUserHostAddress();

		foreach($this->getRules() as $rule)
		{
			if(($allow=$rule->isUserAllowed($user,$filterChain->controller,$filterChain->action,$ip,$verb))>0) // allowed
				break;
			else if($allow<0) // denied
			{
				if(isset($rule->deniedCallback))
					call_user_func($rule->deniedCallback, $rule);
				else
					$this->accessDenied($user,$this->resolveErrorMessage($rule));
				return false;
			}
		}

		return true;
	}
}