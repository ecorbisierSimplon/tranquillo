<?php

namespace App\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    public const CREATE = 'TASK_CREATE';
    public const VIEW = 'TASK_VIEW';
    public const EDIT = 'TASK_EDIT';
    public const DELETE = 'TASK_DELETE';
    public const LIST = 'TASK_LIST';

    /**
     * @param string $attribute 
     * @param mixed $subject 
     * @return bool 
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        return
            in_array($attribute, [self::CREATE]) ||
            in_array($attribute, [self::EDIT, self::VIEW, self::DELETE, self::LIST])
            && $subject instanceof \App\Entity\Task;
    }

    /**
     * @param mixed Task $subject 
     * @return bool 
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::VIEW:
            case self::EDIT:
            case self::DELETE:
            case self::LIST:
                return intval($subject->getUsersId()) == intval($user->getId());
                break;
            case self::CREATE:
                return true;
                break;
        }

        return false;
    }
}
