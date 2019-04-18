<?php

namespace App\Model;

use App\Model\Entity\ClientUser;
use Nette,
	Nette\Utils\Strings,
	Nette\Security\Passwords;


/**
 * Client Users management.
 */
class ClientUserManager extends Nette\Object implements Nette\Security\IAuthenticator
{

	/**
	 * @var ClientUserModel
	 */
	protected $clientUserModel;

	public function __construct(ClientUserModel $clientUserModel)
	{
		$this->clientUserModel = $clientUserModel;
	}


	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($login, $password) = $credentials;

		$user = $this->clientUserModel->findByLogin($login);

		//$row = $this->database->table(self::TABLE_NAME)->where(self::COLUMN_NAME, $username)->fetch();

		if (!$user) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $user->pass)) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} elseif (Passwords::needsRehash($user->pass)) {

			$user->setPass(Passwords::needsRehash($password));
			$this->clientUserModel->save($user);

		}

		$temp = $this->clientUserModel->find($user->getId(), true);

		return new Nette\Security\Identity($user->getId(), 1, $temp);
	}


	/**
	 * @param $email
	 * @param $password
	 * @throws DuplicateNameException
	 */
	public function add($email, $password)
	{
		$test_user = $this->clientUserModel->findByEmail($email);
		if ($test_user) {
			throw new DuplicateNameException();
		}
		else{
			$user = new Users();
			$user->setEmail($email);
			$user->setPass(Passwords::hash($password));
			$this->clientUserModel->save($user);
		}

	}

}
