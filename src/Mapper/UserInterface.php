<?php
/**
 * LaminasUser
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @license AGPL-3.0 <https://www.gnu.org/licenses/agpl-3.0.en.html>
 */

namespace LaminasUser\Mapper;

interface UserInterface
{
    /**
     * @param $email
     * @return \LaminasUser\Entity\UserInterface
     */
    public function findByEmail($email);

    /**
     * @param string $username
     * @return \LaminasUser\Entity\UserInterface
     */
    public function findByUsername($username);

    /**
     * @param string|int $id
     * @return \LaminasUser\Entity\UserInterface
     */
    public function findById($id);

    /**
     * @param \LaminasUser\Entity\UserInterface $user
     */
    public function insert(\LaminasUser\Entity\UserInterface $user);

    /**
     * @param \LaminasUser\Entity\UserInterface $user
     */
    public function update(\LaminasUser\Entity\UserInterface $user);
}
