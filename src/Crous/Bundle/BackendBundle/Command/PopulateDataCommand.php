<?php
namespace Crous\Bundle\BackendBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class PopulateDataCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('crous:populate:data')
            ->setDescription('Populating data')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        
        if ($this->populateRole($em)) {
            $output->writeln("<fg=green>Populating role data successful!</fg=green>");       
        }

        if ($this->populateUser($em)) {
            $output->writeln("<fg=green>Populating user data successful!</fg=green>");       
        }

    }

    protected function truncate($em, $clsName)
    {
        $cmd = $em->getClassMetadata($clsName);
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->beginTransaction();

        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
            return true;
        }
        catch (\Exception $e) {
            $connection->rollback();
        }

        return false;
    }

    protected function populateUser($em)
    {
        if ($this->truncate($em, 'Crous\Bundle\BackendBundle\Entity\User')) {
            $users = array(
                array('admin', 'admin', 'Johnny', 'Depp', 'ROLE_ADMIN', 'admin@crous.com', true),
            );
            /* @var $userManager \Crous\Bundle\BackendBundle\Manager\UserManager */
            $userManager = $this->getContainer()->get('user_manager');
            $roleManager = $this->getContainer()->get('role_manager');
            foreach ($users as $item) {
                /* @var $user \Crous\Bundle\BackendBundle\Entity\User */
                $user = $this->getContainer()->get('entity_factory')->create('User');
                $user->setUsername($item[0])
                    ->setRegionId(1)
                    ->setPassword($item[1])
                    ->setFirstname($item[2])
                    ->setLastname($item[3])
                    ->setEmail($item[5])
                    ->setActive(1)
                    ;

                $role = $roleManager->getRepository()->findOneBy(array('role'=>$item[4]));
                if ($role != null && $role instanceof \Crous\Bundle\BackendBundle\Entity\Role) {
                    $user->setRole($role);            
                }

                //Encrypt password
                $factory = $this->getContainer()->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);        
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());  

                $user->setPassword($password);
                $userManager->save($user);
                return true;
            }
        }
        return false;
    }

    protected function populateRole($em)
    {
        if ($this->truncate($em, 'Crous\Bundle\BackendBundle\Entity\Role')) {
            $roles = array(
                array('Administrator', 'ROLE_ADMIN'),
                array('Standard User', 'ROLE_USER'),
                array('Guest', 'ROLE_GUEST'),
            );
            /* @var $roleManager \Crous\Bundle\BackendBundle\Manager\RoleManager */
            $roleManager = $this->getContainer()->get('role_manager');
            foreach ($roles as $item) {
                /* @var $role \Crous\Bundle\BackendBundle\Entity\Role */
                $role = $this->getContainer()->get('entity_factory')->create('Role');
                $role->setName($item[0])
                    ->setRole($item[1])
                    ->setType(1)
                    ->setActive(true)
                    ;
                $roleManager->save($role);
            }
            return true;
        }
        return false;
    }
}
