<?php

namespace App\Security\Voter;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BookVoter extends Voter
{
    public const EDIT = 'book.edit';

    public function __construct(
        private readonly AuthorizationCheckerInterface $checker
    ) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::EDIT
            && $subject instanceof Book;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if ($this->checker->isGranted('ROLE_ADMIN')) {
            return true;
        }
        if (!$token->getUser() instanceof User) {
            return false;
        }

        /** @var Book $subject */
        return $subject->getCreatedBy() === $token->getUser();
    }
}
