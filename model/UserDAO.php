<?php

namespace model;

use PDOException;

class UserDAO extends AbstractDAO
{
    /**
     * @return void
     */
    protected function setTable()
    {
        $this->table = 'users';
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function registerUser(User $user): bool
    {
            $params = [
                'firstName'   => $user->getFirstName(),
                'lastName'    => $user->getLastName(),
                'email'       => $user->getEmail(),
                'password'   => $user->getPassword(),
                'active'      => $user->getActive(),
                'role'        => $user->getRole()
            ];
            $query = "
                INSERT INTO
                    users (
                        first_name,
                        last_name,
                        email,
                        password,
                        active,
                        role
                    )
                VALUES (
                    :firstName,
                    :lastName,
                    :email,
                    :password,
                    :active,
                    :role
                    )";
            $this->prepareAndExecute(
                $query,
                $params
            );
            $user->setId($this->lastInsertId());
            return true;
        }
}