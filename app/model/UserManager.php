<?php

namespace App\Model;

use App\Model\Entity\Users;
use Nette,
	Nette\Utils\Strings,
	Nette\Security\Passwords;


/**
 * Users management.
 */
class UserManager implements Nette\Security\IAuthenticator
{

	/**
	 * @var UsersModel
	 */
	protected $usersModel;

	/**
	 * @var ClientUserModel
	 */
	protected $clientUserModel;

	public function __construct(UsersModel $usersModel, ClientUserModel $clientUserModel)
	{
		$this->usersModel = $usersModel;
		$this->clientUserModel = $clientUserModel;
	}


	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($email, $password, $module) = $credentials;

		if($module == 'admin') {
			$user = $this->usersModel->findByEmail($email);
		}
		else
			$user = $this->clientUserModel->findByLogin($email);


		if (!$user) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $user->pass)) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} elseif (Passwords::needsRehash($user->pass)) {
			$user->setPass(Passwords::needsRehash($password));
			$this->usersModel->save($user);

		}

		$temp = $this->usersModel->find($user->getId(), true);

		return new Nette\Security\Identity($user->getId(), 1, $temp);
	}


	/**
	 * @param $email
	 * @param $password
	 * @throws DuplicateNameException
	 */
	public function add($email, $password)
	{
			$test_user = $this->usersModel->findByEmail($email);
			if ($test_user) {
				throw new DuplicateNameException();
			}
			else{
				$user = new Users();
				$user->setEmail($email);
				$user->setPass(Passwords::hash($password));
				$this->usersModel->save($user);
			}
	}

}



class DuplicateNameException extends \Exception
{}
